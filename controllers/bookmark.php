<?php

require_once 'app/Activity.php';
require_once 'app/User.php';
require_once 'app/Bookmark.php';
$User = new User;
$Bookmark = new Bookmark;
$Activity = new Activity;

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) && $User -> validateSession()) {
    $bookmark['user_id'] = $_COOKIE['user_id'];
    $bookmark['post_id'] = intval($_GET['id']);
    if ($Bookmark -> bookmark($bookmark['post_id'], $bookmark['user_id'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);    
    } else {
        header('Location: /logout');
    }
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}