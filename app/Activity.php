<?php

include_once 'Database.php';
include_once 'User.php';

class Activity
{
    private object $con;
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
                        return true;
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
                 if ($this -> con -> db -> execute_query('INSERT INTO `post_like` VALUES(?, ?, default)', [$data['post_id'], $data['user_id']])) {
                    return true;
                 }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}