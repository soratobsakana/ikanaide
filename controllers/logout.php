<?php

// Recorre el array actual de $_COOKIE eliminando cada entrada mediante las llaves del array.
// La eliminación de las cookies conlleva un deslogeo del usuario.
if (isset($_COOKIE)) {
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', time()-1000);
        setcookie($key, '', time()-1000, '/');
    }
}

header("Location: /home");