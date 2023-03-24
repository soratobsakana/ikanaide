<?php

// Devuelve la URI y la parsea eliminando una posible query (ej. en /pagina?id=100 devolverá /pagina).
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// Array con las todas las rutas de la página web.
$routes = array(
    '/' => 'resources/views/home.view.php',
    '/home' => 'resources/views/home.view.php',
    '/anime' => 'controllers/medium.php',
    '/manga' => 'controllers/medium.php',
    '/vn' => 'controllers/medium.php',
    '/rankings' => 'controllers/rankings.php',
    '/community' => 'controllers/community.php',
    '/edit' => 'controllers/edit.php',
    '/submit' => 'controllers/submit.php',
    '/submit/anime' => 'controllers/submit.php',
    '/submit/manga' => 'controllers/submit.php',
    '/submit/vn' => 'controllers/submit.php',
    '/submit/character' => 'controllers/submit.php',
    '/submit/staff' => 'controllers/submit.php',
    '/login' => 'controllers/login.php',
    '/register' => 'controllers/register.php',
    '/profile' => 'controllers/profile.php',
    '/logout' => 'controllers/logout.php',
    '/404' => 'resources/views/404.view.php'
);

// Filtrar la $uri a traves del array de rutas y requerir el archivo al que refiere esa URI.
if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    // En caso de no existir el URI solicitado, envía un error 404 al usuario y le avisa por pantalla.
    http_response_code(404);
    include('resources/views/404.view.php');
    die();
}
