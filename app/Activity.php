<?php

namespace App;

class Activity
{
    /**
     * @param array $post
     * @return bool
     * Crea un post mediante $post['user_id'] y $post['content'] y lo asigna a un usuario.
     */
    public static function post(array $post): bool
    {
        if (isset($post['content']) && isset($post['user_id'])) {
            if (User::validateSession()) {
                if (DB::query('INSERT INTO `post`(`post_id`, `user_id`, `content`, `date`) VALUES (null, ?, ?, default)', [$post['user_id'], $post['content']])) {
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
    public static function setPostRelation(string $medium, int $post_id, int $user_id, int $entry): bool
    {
        if (DB::query('INSERT INTO post_'.$medium.' VALUES (?, ?)', [$post_id, $entry])) {
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
    public static function listUpdate(array $data): bool
    {
        if (isset($data['user_id']) && isset($data['medium']) && isset($data['medium_id'])) {
            if (Listing::existsWithID($data['medium'], $data['medium_id'])) {
                $data['medium'] === 'anime' ? $current = 'watched' : $current = 'read';
                $data['medium'] === 'anime' ? $current2 = 'episode' : $current2 = 'chapter';
                $current3 = User::getEpisodesOrChapters($data['medium'], $data['medium_id'], $data['user_id']);
                $current4 = Listing::getTitle($data['medium'], $data['medium_id']);
                $post['content'] = 'I have ' . $current . " " . $current2 . " " .  $current3 . ' from ' . $current4 . '.';
                $post['user_id'] = $data['user_id'];
                if (Activity::post($post)) {
                    $data['post_id'] = DB::insertedId();
                    if (self::setPostRelation($data['medium'], $data['post_id'], $data['user_id'], $data['medium_id'])) {
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
        } else {
            return false;
        }
    }

    /**
     * @param array $data
     * @return bool
     * Se añade una fila a la entrada de post_like cuando un usuario da click sobre el icono de corazón de un post.
     */
    public static function like(array $data): bool
    {
        if (isset($data['post_id']) && $data['user_id']) {
             if (DB::query('SELECT user_id FROM post_like WHERE post_id = ? AND user_id = ?', [$data['post_id'], $data['user_id']]) -> num_rows === 0) {
                if (DB::query('INSERT INTO `post_like` VALUES(?, ?, default)', [$data['post_id'], $data['user_id']])) {
                    return true ?? false;
                }
             } else {
                if (DB::query('DELETE FROM `post_like` WHERE post_id = ? AND user_id = ?', [$data['post_id'], $data['user_id']])) {
                    return true ?? false;
                }
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
    public static function getSelect(): array
    {
        $animes = DB::query('SELECT title FROM anime ORDER BY title');
        $mangas = DB::query('SELECT title FROM manga ORDER BY title');

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

    public static function exists(int $post_id): bool
    {
        if (DB::query('SELECT * FROM post WHERE post_id = ?', [$post_id]) -> num_rows === 1) {
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
    public static function getPost($post_id): array
    {
        $result = DB::query('SELECT * FROM post WHERE post_id = ?', [$post_id]) -> fetch_assoc();

        // Get the info from `post` into $post.
        foreach ($result as $key => $value) {
            if ($key === 'date') {
                // Recogida de las fechas para crear el tiempo que ha pasado desde la creación de cada post mediante mi función timeAgo().
                $current = date('Y-m-d H:i:s');
                $reference = $value;
                $post['post']['time_ago'] = timeAgo($current, $reference);
                $post['post']['date'] = $value;
            } else if ($key === 'user_id') {
                $post['user']['user_id'] = $value;
                $post['user']['username'] = User::getUsername($post['user']['user_id']);
            } else {
                $post['post'][$key] = $value;
            }
        }

        // Reply, like and bookmark count
        $post['post']['reply_count'] = DB::query('SELECT count(reply_id) FROM `post_reply` WHERE post_id = ?;', [$post['post']['post_id']]) -> fetch_column();
        $post['post']['like_count'] = DB::query('SELECT count(user_id) FROM `post_like` WHERE post_id = ?;', [$post['post']['post_id']]) -> fetch_column();
        $post['post']['bookmark_count'] = DB::query('SELECT count(user_id) FROM `bookmark` WHERE post_id = ?;', [$post['post']['post_id']]) -> fetch_column();

        // Check if the post is related to an anime or manga.
        $animeId = DB::query('SELECT anime_id FROM `post_anime` WHERE post_id = ?', [$post['post']['post_id']]);
        if ($animeId -> num_rows === 1) {
            $post['post']['medium'] = 'anime';
            $post['post']['medium_id'] = $animeId -> fetch_column();
            $post['post']['medium_title'] = DB::query('SELECT title FROM anime WHERE anime_id = ?', [$post['post']['medium_id']]) -> fetch_column();
        } else {
            $mangaId = DB::query('SELECT manga_id FROM `post_manga` WHERE post_id = ?', [$post['post']['post_id']]);
            if ($mangaId -> num_rows === 1) {
                $post['post']['medium'] = 'manga';
                $post['post']['medium_id'] = $mangaId -> fetch_column();
                $post['post']['medium_title'] = DB::query('SELECT title FROM manga WHERE manga_id = ?', [$post['post']['medium_id']]) -> fetch_column();
            }
        }

        // Comprobación de si un post es una respuesta o un post original.
        $original = DB::query('SELECT post_id FROM `post_reply` WHERE reply_id = ?', [$post['post']['post_id']]);
        if ($original -> num_rows === 1) {
            $mainPost = $original -> fetch_column();
            $userId = DB::query('select user_id from post where post_id = ?', [$mainPost]) -> fetch_column();
            $post['post']['replying_to'] = User::getUsername($userId);
        }

        foreach (User::getInfoLess($post['user']['user_id']) as $key => $value) {
            $post['user'][$key] = $value;
        }

        if (DB::query('SELECT user_id FROM post_like WHERE post_id = ? AND user_id = ?', [$post['post']['post_id'], $post['user']['user_id']]) -> num_rows === 1) {
            $post['user']['liked'] = true;
        } else {
            $post['user']['liked'] = false;
        }

        if (DB::query('SELECT user_id FROM bookmark WHERE post_id = ? AND user_id = ?', [$post['post']['post_id'], $post['user']['user_id']]) -> num_rows === 1) {
            $post['user']['bookmarked'] = true;
        } else {
            $post['user']['bookmarked'] = false;
        }
        
        return $post;
    }

    /**
     * @param int $post_id
     * @return array|null
     */

    public static function getPostReplies(int $post_id): array|null
    {
        $result = DB::query('SELECT post_id, reply_id FROM post_reply WHERE post_id = ? ORDER BY reply_id DESC', [$post_id]);
        if ($result -> num_rows > 0) {
            for ($i = 0; $i < $result -> num_rows; $i++) {
                $row = $result -> fetch_assoc();
                $replies[] = self::getPost($row['reply_id']);
            }
            return $replies;
        } else {
            return null;
        }
    }

    public static function getRepliedPost(int $postReply): array|null
    {
        $result = DB::query('SELECT post_id FROM post_reply WHERE reply_id = ?', [$postReply]);
        if ($result -> num_rows === 1) {
            return self::getPost($result -> fetch_column());
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

    public static function postReply(int $postId, string $postReplyId): bool
    {
        if (DB::query('INSERT INTO post_reply VALUES (?, ?)', [$postId, $postReplyId])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $postId
     * @return array|null
     */

    public static function getRelation(int $postId): array|null
    {
        $animeId = DB::query('SELECT anime_id FROM `post_anime` WHERE post_id = ?', [$postId]);
        if ($animeId -> num_rows === 1) {
            $post['medium'] = 'anime';
            $post['medium_id'] = $animeId -> fetch_column();
        } else {
            $mangaId = DB::query('SELECT manga_id FROM `post_manga` WHERE post_id = ?', [$postId]);
            if ($mangaId -> num_rows === 1) {
                $post['medium'] = 'manga';
                $post['medium_id'] = $mangaId -> fetch_column();
            }
        }

        return $post ?? null;
    }

    /**
     * @param int $userId
     * @return array|null
     * Devuelve un array con los usuarios a los que otro usuario sigue.
     */

    public function getFollowing(int $userId): array|null
    {
        $following = DB::query('SELECT `followed_user` FROM `follow` WHERE `following_user` = ?', [$userId]);
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
    public static function getFollowingTimeline(int $userId): array|null
    {
        $posts = DB::query('SELECT `post_id` FROM `post` WHERE `user_id` IN (SELECT `followed_user` FROM `follow` WHERE `following_user` = ?) ORDER BY `date` DESC', [$userId]);
        for ($i = 0; $i < $posts -> num_rows; $i++) {
            $followingTimeline[] = self::getPost($posts -> fetch_column());
        }

        return $followingTimeline ?? null;
    }

    public static function getGlobalTimeline(): array|null
    {
        $posts = DB::query('SELECT post_id FROM post ORDER BY date DESC');
        for ($i = 0; $i < $posts -> num_rows; $i++) {
            $globalTimeline[] = self::getPost($posts -> fetch_column());
        }

        return $globalTimeline ?? null;
    }

    public static function deletePost(int $postId, int $userId): bool
    {
        if (User::validateSession()) {
            if (DB::query('DELETE FROM `post` WHERE post_id = ? AND user_id = ?', [$postId, $userId])) {
                return true;
            } else {
                return false;
            }
        } else {
            header('Location: /logout');
            die();
        }
    }

    /**
     * @return array|null
     * Devuelve los 3 animes|mangas que más aparezcan en las tablas `post_anime` y `post_manga`.
     */
    public static function getMostPosted(): array|null
    {
        $mediums = ['anime', 'manga'];
        foreach($mediums as $medium) {
            if ($result = DB::query('select '.$medium.'_id, count(post_id) as posts from post_'.$medium.' group by '.$medium.'_id order by posts desc limit 3')) {
                for ($i=0; $i < $result -> num_rows; $i++) { 
                    $row = $result -> fetch_assoc();
                    $mostPosted[$medium][$i]['title'] = Listing::getTitle($medium, $row[$medium.'_id']);
                    $mostPosted[$medium][$i][$medium.'_id'] = $row[$medium.'_id'];
                    $mostPosted[$medium][$i]['posts'] = $row['posts'];
                }
            }
        }
        return $mostPosted ?? null;
    }

    public static function getPostRelationCount(string $medium, int $medium_id): int|null
    {
        if (Listing::existsWithId($medium, $medium_id)) {
            $result = DB::query('SELECT count(post_id) as post_count FROM post_'.$medium.' WHERE '.$medium.'_id = ?', [$medium_id]) -> fetch_column();
            if ($result >= 0) {
                return $result;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}