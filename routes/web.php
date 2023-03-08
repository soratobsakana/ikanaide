<?php

// Devuelve la URI y la parsea eliminando una posible query (ej. en /pagina?id=100 devolverá /pagina).
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// Array con las todas las rutas de la página web.
$routes = array(
    '/' => 'resources/views/home.view.php',
    '/anime' => 'resources/views/anime.view.php',
    '/manga' => 'resources/views/manga.view.php',
    '/submit' => 'resources/views/submit.view.php',
    '/profile' => 'resources/views/profile.view.php',
    '/404' => 'resources/views/404.view.php'
);

// Filtrar la $uri a traves del array de rutas y requerir el archivo al que refiere esa URI.
if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    // En caso de no existir el URI solicitado, envía un error 404 al usuario y le avisa por pantalla.
    http_response_code(404);
    echo '? [404]';
    die();
}
