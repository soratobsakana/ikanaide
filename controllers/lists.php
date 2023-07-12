<?php

namespace App;

if (User::validateSession()) {
    if (isset($_POST['add'])) {
        User:: addToList($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id'], $_COOKIE['user_id'], $_SESSION['entry']);
    } else if (isset($_POST['delete'])) {
        User::deleteFromList($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id'], $_COOKIE['user_id'], $_SESSION['entry']);
    } else if (isset($_POST['favourite'])) {
        User::favourite($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id'], $_COOKIE['user_id'], $_SESSION['entry']);
    } else if (isset($_POST['unfavourite'])) {
        User::unfavourite($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id'], $_COOKIE['user_id'], $_SESSION['entry']);
    } else if (isset($_POST['save'])) {
        User::editListEntry($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id'], $_COOKIE['user_id'], $_SESSION['entry'], $_SESSION['counter']);
    }
} else {
    header('Location: /404');
    die();
}