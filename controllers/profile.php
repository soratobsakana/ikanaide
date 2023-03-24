<?php

include('resources/functions.php');

if (isset($_COOKIE['session'])) {
    if ($_COOKIE['session'] === "Yes" && isset($_COOKIE['username'])) {

        include ('app/User.php');
        $User = new User;

        $userInfo = $User -> getInfo($_COOKIE['username']);


        include('resources/views/user/profile.view.php');
    }
} else {
    exit(header("Location: /home"));
}