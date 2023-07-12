<?php

namespace App;

if (User::validateSession()) {
    if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) && $User -> validateSession()) {
        $bookmark['user_id'] = $_COOKIE['user_id'];
        $bookmark['post_id'] = intval($_GET['id']);
        if ($Bookmark -> bookmark($bookmark['post_id'], $bookmark['user_id'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        } else {
            // Pasar por aqui significa que validateSession() en Activity::like() ha dado falso, por lo que provoco un logout.
            header('Location: /logout');
            die();
        }
    } else {
        header('Location: /404');
        die();
    }
} else {
    header('Location: /login');
    die();
}