<?php

require_once 'app/User.php';
$User = new User;

if ((isset($_POST['add']) || isset($_POST['delete']) || isset($_POST['favourite']) || isset($_POST['unfavourite']) || isset($_POST['save'])) && $User -> validateSession() === TRUE) {
    if (isset($_COOKIE['session'])) {
        if (isset($_POST['add'])) {
            $User -> addToList($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id'], $_COOKIE['user_id'], $_SESSION['entry']);
        } else if (isset($_POST['delete'])) {
            $User -> deleteFromList($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id'], $_COOKIE['user_id'], $_SESSION['entry']);
        } else if (isset($_POST['favourite'])) {
            $User -> favourite($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id'], $_COOKIE['user_id'], $_SESSION['entry']);
        } else if (isset($_POST['unfavourite'])) {
            $User -> unfavourite($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id'], $_COOKIE['user_id'], $_SESSION['entry']);
        } else if (isset($_POST['save'])) {
            $User -> editListEntry($_SESSION['medium'], $_SESSION[$_SESSION['medium'] . '_id'], $_COOKIE['user_id'], $_SESSION['entry'], $_SESSION['counter']);
        }
    }
} else {
    header('Location: /404');
}