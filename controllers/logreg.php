<?php


if ($_POST) {
    foreach ($_POST as $key => $value) {
        if ($key !== 'register') {
            $registerInfo[$key] = $value;
        }
    }

    if ($registerInfo['password'] === $registerInfo['confirm']) {
        require 'app/User.php';
        $register = new User;
        if (($message = $register -> register($registerInfo)) === 'Ok') {
            header('Location: /profile');
        }
    } else {
        $message = 'Password confirmation don\'t match';
    }
}

switch($page) {
    case '/register':
        require 'resources/views/user/register.view.php';
        break;
    case '/login':
        require 'resources/views/user/login.view.php';
        break;
}