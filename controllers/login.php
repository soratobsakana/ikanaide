<?php

// Recogida de valores del formulario resources/views/user/login.view.php.
if ($_POST) {
    foreach ($_POST as $key => $value) {
        if ($key !== 'register') {
            $loginInfo[$key] = $value;
        }
    }

}

require 'resources/views/user/login.view.php';