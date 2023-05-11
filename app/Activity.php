<?php

include_once 'Database.php';
include_once 'User.php';
include_once 'Listing.php';

class Activity
{
    public object $con;
    private object $user;
    private object $listing;

    public function __construct()
    {
        $this -> con = new Database;
        $this -> user = new User;
        $this -> listing = new Listing;
    }

    /**
     * @param array $post
     * @return bool
     * Crea un post mediante $post['user_id'] y $post['content'] y lo asigna a un usuario.
     */
    public function post(array $post): bool
    {
        if (isset($post['content']) && isset($post['user_id'])) {
            if ($this -> user -> validateSession()) {
                if ($this -> con -> db -> execute_query('INSERT INTO `post`(`post_id`, `user_id`, `content`, `date`) VALUES (null, ?, ?, default)', [$post['user_id'], $post['content']])) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param string $medium
     * @param int $post_id
     * @param int $user_id
     * @param int $entry
     * @return bool
     * Añade la relación entre anime|manga y post.
     */
    public function setPostRelation(string $medium, int $post_id, int $user_id, int $entry): bool
    {
        if ($this -> con -> db -> execute_query('INSERT INTO post_'.$medium.' VALUES (?, ?)', [$post_id, $entry])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $data
     * @return bool
     * Se crea un post cuando un usuario (que permita esto en sus ajustes) actualiza su lista de anime|manga.
     * Esto signfica que se creará un post personalizado para cada vez que el usuario: ->
     * <- añada una entrada a su lista, sume un episodio|capítulo a una entrada de su lista o cambie el valor de la columna `status` en las tablas de las listas.
     */
    public function listUpdate(array $data): bool
    {
        if (isset($data['user_id']) && isset($data['medium']) && isset($data['medium_id'])) {
            if ($this -> user -> validateSession()) {
                if ($this -> listing -> existsWithID($data['medium'], $data['medium_id'])) {
                    $data['medium'] === 'anime' ? $current = 'watched' : $current = 'read';
                    $data['medium'] === 'anime' ? $current2 = 'episode' : $current2 = 'chapter';
                    $current3 = $this -> user -> getEpisodesOrChapters($data['medium'], $data['medium_id'], $data['user_id']);
                    $current4 = $this -> listing -> getTitle($data['medium'], $data['medium_id']);
                    $post['content'] = 'I have ' . $current . " " . $current2 . " " .  $current3 . ' from ' . $current4 . '.';
                    $post['user_id'] = $data['user_id'];
                    if ($this -> post($post)) {
                        $data['post_id'] = $this -> con -> db ->  insert_id;
                        if ($this -> setPostRelation($data['medium'], $data['post_id'], $data['user_id'], $data['medium_id'])) {
                            return true;
                        }
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param array $data
     * @return bool
     * Se añade una fila a la entrada de post_like cuando un usuario da click sobre el icono de corazón de un post.
     */
    public function like(array $data): bool
    {
        if (isset($data['post_id']) && $data['user_id']) {
            if ($this -> user -> validateSession()) {
                 if ($this -> con -> db -> execute_query('SELECT user_id FROM post_like WHERE post_id = ? AND user_id = ?', [$data['post_id'], $data['user_id']]) -> num_rows === 0) {
                    if ($this -> con -> db -> execute_query('INSERT INTO `post_like` VALUES(?, ?, default)', [$data['post_id'], $data['user_id']])) {
                        return true;
                    } else {
                        return false;
                    }
                 } else {
                    if ($this -> con -> db -> execute_query('DELETE FROM `post_like` WHERE post_id = ? AND user_id = ?', [$data['post_id'], $data['user_id']])) {
                        return true;
                    } else {
                        return false;
                    }
                 }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @return array $select
     * Hace una lista con todos los anime y manga de la base de datos para mostrar en un select dentro del wrapper de creación de post.
     * Con esto, un usuario puede relacionar un post a un anime o manga.
     */
    public function getSelect(): array
    {
        $animes = $this -> con -> db -> execute_query('SELECT title FROM anime ORDER BY title');
        $mangas = $this -> con -> db -> execute_query('SELECT title FROM manga ORDER BY title');

        for ($i = 0; $i < $animes -> num_rows; $i++) {
            $anime = $animes -> fetch_column();
            $select[] = $anime . ' (anime)';
        }

        for ($i = 0; $i < $mangas -> num_rows; $i++) {
            $manga = $mangas -> fetch_column();
            $select[] = $manga . ' (manga)';
        }

        return $select;
    }

    /**
     * @param int $post_id
     * @return bool
     */

    public function exists(int $post_id): bool
    {
        if ($this -> con -> db -> execute_query('SELECT * FROM post WHERE post_id = ?', [$post_id]) -> num_rows === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $post_id
     * @return array
     * Este método requiere el previo uso del método Activity -> exists() para que no de error en caso de no existir el post.
     */
    public function getPost(int $post_id): array
    {
        $result = $this -> con -> db -> execute_query('SELECT * FROM post WHERE post_id = ?', [$post_id]) -> fetch_assoc();
        
        foreach ($result as $key => $value) {
            if ($key === 'date') {
                // Recogida de las fechas para crear el tiempo que ha pasado desde la creación de cada post mediante mi función timeAgo().
                $post['post']['date'] = $value;
                $current = date('Y-m-d H:i:s');
                $reference = $post['post']['date'];
                $timeAgo = timeAgo($current, $reference);
                $post['post']['time_ago'] = $timeAgo;
            } else if ($key === 'user_id') {
                $post['user']['user_id'] = $value;
            } else {
                $post['post'][$key] = $value;
            }
        }
        
        $post['user']['username'] = $this -> user -> getUsername($post['user']['user_id']);

        // Cálculo del número de respuestas y likes asociados a un post.
        $replyCount = $this -> con -> db -> execute_query('SELECT count(reply_id) FROM `post_reply` WHERE post_id = ?;', [$post['post']['post_id']]) -> fetch_column();
        $likeCount = $this -> con -> db -> execute_query('SELECT count(user_id) FROM `post_like` WHERE post_id = ?;', [$post['post']['post_id']]) -> fetch_column();
        $bookmarkCount = $this -> con -> db -> execute_query('SELECT count(user_id) FROM `bookmark` WHERE post_id = ?;', [$post['post']['post_id']]) -> fetch_column();
        $post['post']['reply_count'] = $replyCount;
        $post['post']['like_count'] = $likeCount;
        $post['post']['bookmark_count'] = $bookmarkCount;

        // Comprobación de si un post tiene relación con un anime o manga.
        $animeId = $this -> con -> db -> execute_query('SELECT anime_id FROM `post_anime` WHERE post_id = ?', [$post['post']['post_id']]);
        $mangaId = $this -> con -> db -> execute_query('SELECT manga_id FROM `post_manga` WHERE post_id = ?', [$post['post']['post_id']]);
        if ($animeId -> num_rows === 1) {
            $post['post']['medium'] = 'anime';
            $post['post']['medium_id'] = $animeId -> fetch_column();
            $post['post']['medium_title'] = $this -> con -> db -> execute_query('SELECT title FROM anime WHERE anime_id = ?', [$post['post']['medium_id']]) -> fetch_column();
        } else if ($mangaId -> num_rows === 1) {
            $post['post']['medium'] = 'manga';
            $post['post']['medium_id'] = $mangaId -> fetch_column();
            $post['post']['medium_title'] = $this -> con -> db -> execute_query('SELECT title FROM manga WHERE manga_id = ?', [$post['post']['medium_id']]) -> fetch_column();
        }

        // Comprobación de si un post es una respuesta o un post original.
        $original = $this -> con -> db -> execute_query('SELECT post_id FROM `post_reply` WHERE reply_id = ?', [$post['post']['post_id']]);
        if ($original -> num_rows === 1) {
            $mainPost = $original -> fetch_column();
            $userId = $this -> con -> db -> execute_query('select user_id from post where post_id = ?', [$mainPost]) -> fetch_column();
            $post['post']['replying_to'] = $this -> user -> getUsername($userId);
        }

        if ($userInfo = $this -> user -> getInfoLess($post['user']['user_id'])) {
            foreach ($userInfo as $key => $value) {
                $post['user'][$key] = $value;
            }
        }

        if (isset($_COOKIE['session']) && $this -> user -> validateSession()) {
            if ($this -> con -> db -> execute_query('SELECT user_id FROM post_like WHERE post_id = ? AND user_id = ?', [$post['post']['post_id'], $_COOKIE['user_id']]) -> num_rows === 1) {
                $post['user']['liked'] = true;
            } else {
                $post['user']['liked'] = false;
            }
        }

        if (isset($_COOKIE['session']) && $this -> user -> validateSession()) {
            if ($this -> con -> db -> execute_query('SELECT user_id FROM bookmark WHERE post_id = ? AND user_id = ?', [$post['post']['post_id'], $_COOKIE['user_id']]) -> num_rows === 1) {
                $post['user']['bookmarked'] = true;
            } else {
                $post['user']['bookmarked'] = false;
            }
        }
        
        return $post;
    }

    /**
     * @param int $post_id
     * @return array|null
     */

    public function getPostReplies(int $post_id): array|null
    {
        $result = $this -> con -> db -> execute_query('SELECT post_id, reply_id FROM post_reply WHERE post_id = ? ORDER BY reply_id DESC', [$post_id]);
        if ($result -> num_rows > 0) {
            for ($i = 0; $i < $result -> num_rows; $i++) {
                $row = $result -> fetch_assoc();
                $replies[] = $this -> getPost($row['reply_id']);
            }
            return $replies;
        } else {
            return null;
        }
    }

    public function getRepliedPost(int $postReply): array|null
    {
        $result = $this -> con -> db -> execute_query('SELECT post_id FROM post_reply WHERE reply_id = ?', [$postReply]);
        if ($result -> num_rows === 1) {
            $column = $result -> fetch_column();
            $repliedPost = $this -> getPost($column);
            return $repliedPost;
        } else {
            return null;
        }
    }

    /**
     * @param int $postId
     * @param string $postReplyId
     * @return bool
     * Crea una entrada en `post_reply` si un usuario a escrito una respuesta a un post.
     */

    public function postReply(int $postId, string $postReplyId): bool
    {
        if ($this -> con -> db -> execute_query('INSERT INTO post_reply VALUES (?, ?)', [$postId, $postReplyId])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $postId
     * @return array|null
     */

    public function getRelation(int $postId): array|null
    {
        $animeId = $this -> con -> db -> execute_query('SELECT anime_id FROM `post_anime` WHERE post_id = ?', [$postId]);
        $mangaId = $this -> con -> db -> execute_query('SELECT manga_id FROM `post_manga` WHERE post_id = ?', [$postId]);
        if ($animeId -> num_rows === 1) {
            $post['medium'] = 'anime';
            $post['medium_id'] = $animeId -> fetch_column();
        } else if ($mangaId -> num_rows === 1) {
            $post['medium'] = 'manga';
            $post['medium_id'] = $mangaId -> fetch_column();
        }

        if (isset($post)) {
            return $post;
        } else {
            return null;
        }
    }

    /**
     * @param int $userId
     * @return array|null
     * Devuelve un array con los usuarios a los que otro usuario sigue.
     */

    public function getFollowing(int $userId): array|null
    {
        $following = $this -> con -> db -> execute_query('SELECT `followed_user` FROM `follow` WHERE `following_user` = ?', [$userId]);
        if ($following -> num_rows > 0) {
            for ($i = 0; $i < $following -> num_rows; $i++) {
                $followingUsers[] = $following -> fetch_column();
            }
            return $followingUsers;
        } else {
            return null;
        }
    }

    /**
     * @param int $userId
     * @return array|null
     * Devuelve un array con los nuevos posts de los usuarios que sigue otro usuario.
     */
    public function getFollowingTimeline(int $userId): array|null
    {
        $result = $this -> con -> db -> execute_query('SELECT `post_id` FROM `post` WHERE `user_id` IN (SELECT `followed_user` FROM `follow` WHERE `following_user` = ?) ORDER BY `date` DESC', [$userId]);
        if ($result -> num_rows > 0) {
            for ($i = 0; $i < $result -> num_rows; $i++) {
                $posts[$i] = $result -> fetch_column();
            }
            foreach($posts as $post) {
                $followingTimeline[] = $this -> getPost($post);
            }
            return $followingTimeline;
        } else {
            return null;
        }
    }

    /**
     * 
     */
    public function getGlobalTimeline(): array|null
    {
        $result = $this -> con -> db -> execute_query('SELECT post_id FROM post ORDER BY date DESC');
        if ($result -> num_rows > 0) {
            for ($i = 0; $i < $result -> num_rows; $i++) {
                $posts[$i] = $result -> fetch_column();
            }
            foreach($posts as $post) {
                $globalTimeline[] = $this -> getPost($post);
            }
            return $globalTimeline;
        } else {
            return null;
        }
    }

}