<?php

switch($page) {
    case '/register':
        require 'resources/views/user/register.view.php';
        break;
    case '/login':
        require 'resources/views/user/login.view.php';
        break;
}