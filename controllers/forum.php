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

require 'resources/views/forum/forum.view.php';