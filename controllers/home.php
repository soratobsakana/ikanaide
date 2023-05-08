<?php

require_once 'resources/functions.php';
require_once 'app/User.php';
require_once 'app/Activity.php';
require_once 'app/Following.php';

$User = new User;
$Activity = new Activity;
$Following = new Following;

if (isset($_COOKIE['session']) && $User -> validateSession()) {
    if (isset($_COOKIE['home_timeline']) && $_COOKIE['home_timeline'] === 'default') {
        $followingTimeline = $Activity -> getFollowingTimeline($_COOKIE['user_id']);
    } else if (isset($_COOKIE['home_timeline']) && $_COOKIE['home_timeline'] === 'global') {
        $globalTimeline = $Activity -> getGlobalTimeline();
    }
} else {
    header('Location: /login');
}

require 'resources/views/home/home.view.php';