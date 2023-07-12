<?php

namespace App;

if (User::validateSession()) {
    if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        $deletePost['post_id'] = intval($_GET['id']);
        $deletePost['user_id'] = $_COOKIE['user_id'];
        Activity::deletePost($deletePost['post_id'], $deletePost['user_id']);
        header('Location: /' . $_COOKIE['username']);
        die();
    }
} else {
    header('Location: /404');
    die();
}