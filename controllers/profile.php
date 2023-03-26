<?php
include('resources/functions.php');
include('app/User.php');

if (isset($_COOKIE['session'])) {
    $Session = new User;
    if ($Session -> validateSession() === TRUE) {
        $userInfo = $Session -> getInfo($_COOKIE['username']);
        $animelist = $Session -> animelist($_COOKIE['username']);
        include('resources/views/user/profile.view.php');
    } else {
        exit(header("Location: /home"));
    }
} else {
    exit(header("Location: /home"));
}