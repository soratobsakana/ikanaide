<?php

require_once 'resources/functions.php';
require_once 'app/Activity.php';

$Activity = new Activity;
$User = new User;

// $guide, $page y $postId han sido declaradas en el archivo /routes/web.php


// Si el usuario ha escrito una respuesta a un post, se añade a la base de datos mediante el siguiente bloque:
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-reply'])) {
    // Comprobación de que los campos del formulario no han sido alterados por el usuario.
    $fields = ['post-reply', 'submit-reply'];
    foreach ($_POST as $key => $value) {
        if (!in_array($key, $fields)) {
            header('Location: /404');
        }
    }

    if (isset($_POST['submit-reply']) && $User -> validateSession()) {
        $submitPost['content'] = $_POST['post-reply'];
        $submitPost['user_id'] = $_COOKIE['user_id'];
        if (!empty($_POST['post-reply']) && $Activity -> post($submitPost)) {
            // Consigo el ID del último post introducido
            $postReplyId = $Activity -> con -> db -> insert_id;

            $Activity -> postReply($postId, $postReplyId);
            header('Location: '. $page);
        } else {
            exit('miss');
        }
    } else {
        header('Location: /404');
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like-post'])) {
    // Comprobación de que los campos del formulario no han sido alterados por el usuario.
    $fields = ['like-replay'];
    foreach ($_POST as $key => $value) {
        if (!in_array($key, $fields)) {
            header('Location: /404');
        }
    }

    $likePost['post_id'] = $postId;
    $likePost['user_id'] = $_COOKIE['user_id'];
    $Activity -> like($likePost);
} else if ($Activity -> exists($postId)) {
    // $post contendrá la información de los posts a mostrar.
    $post = $Activity -> getPost($postId);
    $replies = $Activity -> getPostReplies($postId);

    // $loggedUser contendrá la información del usuario logeado, que se utilizará en caso de que interactue con los posts mostrados.
    if ($User -> validateSession()) {
        $loggedUser = $User -> getInfoLess($_COOKIE['user_id']);
    }

    require 'resources/views/activity/activity.view.php';
} else {
    header('Location: /404');
}