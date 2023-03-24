<?php

// Recogida de valores del formulario resources/views/user/register.view.php.
if ($_POST) {
    foreach ($_POST as $key => $value) {
        if ($key !== 'login') {
            $registerInfo[$key] = $value;
        }
    }

    // Verificación de los datos entregados por el usuario en el formulario.
    if ($registerInfo['password'] === $registerInfo['confirm']) {
        require 'app/User.php';
        $register = new User;
        // Si todas las verificaciones son exitosas, crea un ID de sesión y manda al usuario a su nuevo perfil automáticamente.
        if (($message = $register -> register($registerInfo)) === 'Ok') {
            exit(header('Location: /profile'));
        }
    } else {
        // Si alguna de las verificaciones falla, enviará el error específico (definidos en User::register()) al usuario mediante la variable $message.
        $message = 'Password confirmation doesn\'t match';
    }
}

// Muestra de las vista del formulario de registro.
// Se muestra de primera visita y cuando el usuario falla en alguna de las verificaciones de la función register() de la clase User.
require 'resources/views/user/register.view.php';