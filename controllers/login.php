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
    // Si la información es correcta, se envía un header hacia su perfil.
    if (($message = $login -> login($loginInfo)) === 'Ok') {
        header('Location: /home');
    }
}

require 'resources/views/user/login.view.php';