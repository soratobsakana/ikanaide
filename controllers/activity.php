<?php

require_once 'resources/functions.php';
require_once 'app/Activity.php';

$Activity = new Activity;
$User = new User;

// $guide y $postId han sido declaradas en el archivo /routes/web.php

if ($Activity -> exists($postId)) {
    // $post contendrá la información de los posts a mostrar.
    $post = $Activity -> getPost($postId);
    // $loggedUser contendrá la información del usuario logeado, que se utilizará en caso de que interactue con los posts mostrados.
    if ($User -> validateSession()) {
        $loggedUser = $User -> getInfoLess($_COOKIE['user_id']);
    }

    require 'resources/views/activity/activity.view.php';
} else {
    header('Location: /404');
}