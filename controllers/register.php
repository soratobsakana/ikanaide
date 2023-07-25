<?php

if (\App\User::validateSession()) {
    header('Location: /home');
    die();
}

// Recogida de valores del formulario resources/views/user/register.view.php.
if ($_POST) {
    foreach ($_POST as $key => $value) {
        if ($key !== 'register') {
            $registerInfo[$key] = $value;
        }
    }

    if (\App\User::register($registerInfo)) {
        header('Location: /'.$registerInfo['username']);
        die();
    }
}

// Muestra de las vista del formulario de registro.
// Se muestra de primera visita y cuando el usuario falla en alguna de las verificaciones de la función register() de la clase User.
require view('user/register.view.php');