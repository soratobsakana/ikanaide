<?php

require_once 'app/Activity.php';
$Activity = new Activity;

// Comprobación de que el formulario no ha sido alterado mediante las herramientas de navegador.
$fields = ['post-content', 'post'];
if (isset($_POST)) {
    foreach($_POST as $key => $value) {
        if (!in_array($key, $fields)) {
            header('Location: /404');
        } else {
            if ($key === 'post-content') {
                $post['content'] = $value;
            }
        }
    }
    if (isset($_COOKIE['user_id']) && is_numeric($_COOKIE['user_id'])) {
        $post['user_id'] = intval($_COOKIE['user_id']);
    }
    if (isset($post['content']) && isset($post['user_id'])) {
        $check = $Activity -> post($post);
        if ($check) {
            if (isset($_COOKIE['username'])) {
                header('Location: /' . $_COOKIE['username']);
            } else {
                header('Location: /logout');
            }
            
        }
    }
}