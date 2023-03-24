<?php

// Recogida de valores del formulario resources/views/user/login.view.php.
if ($_POST) {
    foreach ($_POST as $key => $value) {
        if ($key !== 'register') {
            $loginInfo[$key] = $value;
        }
    }

    require 'app/User.php';
    $login = new User;

    // Verificación y autenticación de la coincidencia de usuario y contraseña de una entrada de la BBDD con lo introducido por el usuario.
    if (($message = $login -> login($loginInfo)) === 'Ok') {
        exit(header('Location: /profile'));
    }
}

require 'resources/views/user/login.view.php';