<?php

require_once 'resources/functions.php';
require_once 'app/User.php';
require_once 'app/Activity.php';
require_once 'app/Following.php';

$User = new User;
$Activity = new Activity;
$Following = new Following;

if (isset($_COOKIE['session']) && $User -> validateSession()) {
    $followingTimeline = $Activity -> getFollowingTimeline($_COOKIE['user_id']);
    pre($followingTimeline);
} else {
    print 'haha';
}

require 'resources/views/home/home.view.php';