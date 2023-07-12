<?php

namespace App;

// $uri viene de routes/web.php
// Las URI de perfiles de usuario es: /nombre_de_usuario, por lo que saco $username de esta manera:
$username = explode("/", $uri)[1];

// Genero el ID del usuario asociado a $username para utilizarlo en los extractos de información de profile.php.
$userId = User::getUserID($username);

$profileRoutes = [
    '/'.$username => '../controllers/profile.php',
    '/'.$username.'/animelist' => '../controllers/profile.php',
    '/'.$username.'/mangalist' => '../controllers/profile.php',
    '/'.$username.'/reviews' => '../controllers/profile.php',
    '/'.$username.'/favorites' => '../controllers/profile.php'
];

if (array_key_exists($uri, $profileRoutes)) {
    require $profileRoutes[$uri];
} else {
    header('Location: /404');
    die();
}