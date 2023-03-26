<?php

if (isset($_POST['add'])) {
    if (isset($_COOKIE['session'])) {
        require_once 'app/User.php';
        $User = new User;
        $User -> addToList($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id']);
    }
} else if ($_POST['delete']){
    require_once 'app/User.php';
    $User = new User;
    $User -> addToList($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id']);
} else {
    header('Location: /404');
}