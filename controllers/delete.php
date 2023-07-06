<?php

require_once '../app/Activity.php';
require_once '../app/User.php';
$User = new User;
$Activity = new Activity;

if (isset($_COOKIE['session'])) {
    if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        $deletePost['post_id'] = intval($_GET['id']);
        $deletePost['user_id'] = $_COOKIE['user_id'];
        $Activity -> deletePost($deletePost['post_id'], $deletePost['user_id']);
        header('Location: /' . $_COOKIE['username']);
    } else {
        header('Location: /404');
    }
} else {
    header('Location: /404');
}