<?php

// Este archivo es utilizado para registrar nuevos posts en la base de datos.

require_once 'app/Activity.php';
require_once 'app/Listing.php';
$Activity = new Activity;
$Listing = new Listing;

$fields = ['post-content', 'post', 'on-medium'];
if (isset($_POST)) {
    foreach($_POST as $key => $value) {
        // Comprobación de que el formulario no ha sido alterado mediante las herramientas de navegador.
        if (!in_array($key, $fields)) {
            header('Location: /404');
        } else {
            if ($key === 'post-content' && !empty($key)) {
                $post['content'] = $value;
            } else if ($key === 'on-medium' && !empty($key)) {
                $post['relation'] = $value;
            }
        }
    }
    if (isset($_COOKIE['user_id']) && is_numeric($_COOKIE['user_id'])) {
        $post['user_id'] = intval($_COOKIE['user_id']);
    }
    if (isset($post['content']) && isset($post['user_id'])) {
        if ($Activity -> post($post)) {

            // Consigo el ID del último post introducido
            $post_id = $Activity -> con -> db -> insert_id;

            // El formato es: Nombre de Anime (anime) ó Nombre de Manga (manga).
            // Mediante substr(), compruebo que los values de los option no han sido alterado mediante las herramientas de navegador.
            if (!empty($_POST['on-medium'])) {
                $medium = substr($post['relation'], -6, 5); // anime|manga
                if ($medium === 'anime' || $medium === 'manga') {
                    $entry = substr($post['relation'], 0, -8); // título de anime|manga
                    if ($entryId = $Listing -> exists($medium, $entry)) {
                        if ($Activity -> setPostRelation($medium, $post_id, $post['user_id'], $entryId)) {
                            header('Location: /' . $_COOKIE['username']);
                        }
                    }
                }
            }
            if (isset($_COOKIE['username'])) {
                header('Location: /' . $_COOKIE['username']);
            } else {
                header('Location: /logout');
            }
        }
    }
}