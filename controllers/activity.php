<?php

require_once 'resources/functions.php';
require_once 'app/Activity.php';

$Activity = new Activity;
$User = new User;

// $guide, $page y $postId han sido declaradas en el archivo /routes/web.php

if ($Activity -> exists($postId)) {
    // $post contendrá la información de los posts a mostrar.
    $post = $Activity -> getPost($postId);

    // $loggedUser contendrá la información del usuario logeado, que se utilizará en caso de que interactue con los posts mostrados.
    if ($User -> validateSession()) {
        $loggedUser = $User -> getInfoLess($_COOKIE['user_id']);
    }

    // Si el usuario ha escrito una respuesta a un post, se añade a la base de datos mediante el siguiente bloque:
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Comprobación de que los campos del formulario no han sido alterados por el usuario.
        $fields = ['post-reply', 'submit-reply'];
        foreach ($_POST as $key => $value) {
            if (!array_key_exists($key, $fields)) {
                header('Location: /404');
            }
        }

        if (isset($_POST['submit-reply'])) {

            if (!empty($_POST['post-reply']) && $Activity -> postReply($postId, $_POST['post-reply'])) {
                header('Location: '. $page);
            } else {
                header('Location: /404');
            }
        }
    }


    require 'resources/views/activity/activity.view.php';
} else {
    header('Location: /404');
}