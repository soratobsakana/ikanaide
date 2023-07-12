<?php

namespace App;

if (isset($_GET['id'], $_GET['action']) && (filter_var($_GET['id'], FILTER_VALIDATE_INT) && ($_GET['action'] === 'up' || $_GET['action'] === 'down'))) {
    if (User::validateSession()) {
        if (Review::likeReview($_GET['id'], $_GET['action'], $_COOKIE['user_id'])) {
            header('Location: '.$_SERVER['HTTP_REFERER']);
            die();
        } else {
            exit('Sorry, there was an error');
        }
    } else {
        header('Location: /logout');
        die();
    }
} else {
    header('Location: /404');
}