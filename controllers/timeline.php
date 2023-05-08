<?php

if ($_GET) {

    $fields = ['tl'];
    foreach ($_GET as $field => $value) {
        if (!in_array($field, $fields)) {
            header('Location: /404');
        }
    }
    

    if (empty($_GET['tl']) && ($_GET['tl'] !== 'global' || $_GET['tl'] !== 'default')) {
        header('Location: /404');
    }

    setcookie('home_timeline', $_GET['tl'], strtotime('NOW+60DAYS'));
    header('Location: /home');
}