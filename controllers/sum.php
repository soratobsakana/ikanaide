<?php

// This file is used to sum one single episode or chapter to a user's list entry.
require_once 'app/User.php';
require_once 'app/Listing.php';
require_once 'resources/functions.php';
$User = new User;
$Listing = new Listing;

if ((!empty($_GET['medium']) && ($_GET['medium'] === 'anime' || $_GET['medium'] === 'manga')) && (!empty($_GET['id']) && is_numeric($_GET['id']))) {
    if ($User -> validateSession()) {
        $data['user_id'] = $_COOKIE['user_id'];
        $data['medium_id'] = $_GET['id'];
        $data['medium'] = $_GET['medium'];
        $episodesOrChapters = $Listing -> getEpisodesOrChapters($data['medium'], $data['medium_id']);
        $userCurrent = $User -> getEpisodesOrChapters($data['medium'], $data['medium_id'], $data['user_id']);
        if ($userCurrent < $episodesOrChapters) {
            if ($User -> sumOne($data)) {
                if (!empty($_SERVER['HTTP_REFERER'])) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            } else {
                header('Location: /404');
            }
        } else {
            if (!empty($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
    } else {
        header('Location: /404');
    }
} else {
    header('Location: /404');
}
