<?php

require_once 'resources/functions.php';
require_once 'app/User.php';
require_once 'app/Activity.php';
require_once 'app/Following.php';
require_once 'app/Home.php';
require_once 'app/Review.php';

$User = new User;
$Activity = new Activity;
$Following = new Following;
$Home = new Home;
$Review = new Review;

if (isset($_COOKIE['session']) && $User -> validateSession()) {
    if (isset($_COOKIE['home_timeline']) && $_COOKIE['home_timeline'] === 'default') {
        $followingTimeline = $Activity -> getFollowingTimeline($_COOKIE['user_id']);
    } else if (isset($_COOKIE['home_timeline']) && $_COOKIE['home_timeline'] === 'global') {
        $globalTimeline = $Activity -> getGlobalTimeline();
    }
    $watchingAnimes = $Home -> getWatchingAnimes($_COOKIE['user_id']);
    $readingMangas = $Home -> getReadingMangas($_COOKIE['user_id']);
    $latestReviews = $Home -> getReviews();
    $mostPosted = $Activity -> getMostPosted();

} else {
    header('Location: /login');
    die();
}

require 'resources/views/home/home.view.php';