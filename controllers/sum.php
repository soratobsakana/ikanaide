<?php

// This file is used to sum one single episode or chapter to a user's list entry.
require_once 'app/User.php';
require_once 'resources/functions.php';
$User = new User;

if (!(empty($_GET['medium']) && empty($_GET['id']))) {
    if ($User -> validateSession()) {
        $data['user_id'] = $_COOKIE['user_id'];
        $data['medium_id'] = $_GET['id'];
        $data['medium'] = $_GET['medium'];
        if ($User -> sumOne($data)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: /404');
        }
    } else {
        header('Location: /404');
    }
} else {
    header('Location: /404');
}
