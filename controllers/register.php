<?php

foreach ($_POST as $key => $value) {
    if ($key !== 'submit') {
        $registerInfo[$key] = $value;
    }
}

if ($registerInfo['password'] === $registerInfo['confirm']) {
    require 'app/User.php';
    $register = new Register;
    if ($register -> register($registerInfo)) {
        exit('good job');
    } else {
        exit('bad job');
    }
} else {
    exit('passwords dont match');
}

// $this -> con -> db -> execute_query('SELECT user_id FROM user WHERE username = ?', [$registerInfo['username']]);