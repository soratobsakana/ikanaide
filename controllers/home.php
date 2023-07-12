<?php

namespace App;

if (User::validateSession()) {
    if ($_COOKIE['home_timeline'] === 'default') {
        $followingTimeline = Activity::getFollowingTimeline($_COOKIE['user_id']);
    } else if ($_COOKIE['home_timeline'] === 'global') {
        $globalTimeline = Activity::getGlobalTimeline();
    }

    $watchingAnimes = Home::getWatchingAnimes($_COOKIE['user_id']);
    $readingMangas = Home::getReadingMangas($_COOKIE['user_id']);
    $latestReviews = Home::getReviews();
    $mostPosted = Activity::getMostPosted();

} else {
    header('Location: /login');
    die();
}

require view('home/home.view.php');