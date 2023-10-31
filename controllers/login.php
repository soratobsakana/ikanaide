<?php



// Recogida de valores del formulario resources/views/user/login.view.php.
if ($_POST) {

    foreach ($_POST as $key => $value) {
        if ($key !== 'login') {
            $loginInfo[$key] = $value;
        }
    }

    // Verificación y autenticación de la coincidencia de usuario y contraseña de una entrada de la BBDD con lo introducido por el usuario.
    // Si la información es correcta, se envía un header hacia su perfil.
    if (($error = \App\User::login($loginInfo)) == 1) {
        header('Location: /home');
        die();
    }
}

require view('user/login.view.php');