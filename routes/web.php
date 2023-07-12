<?php

require_once '../resources/functions.php';

// Devuelve la URI y la parsea eliminando una posible query (ej. en /pagina?id=100 devolverá /pagina).
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// La URI normal de un listado de anime o manga es: /anime|manga/Nombre-De-Anime|Manga. Hago explode() de la URI para conseguir el medio (anime o manga) y el entry que voy a listar.
$guide = explode("/", $uri);
$medium = $guide[1]; // anime|manga

// Si se indica un anime o manga por URL, significa que explode('/', $uri) va a devolver un tercer valor. Si esto pasa, creo una ruta dinámica en $mediumRoutes que utilizo abajo mediante un else if.
// Si no existe un tercer valor, se require el controlador indicado para /anime y /manga indicado en $routes.
// Ambos casos conducen al mismo controlador (/../controllers/medium.php), que se encarga de mostrar el listado de un anime o manga, o mostrar la página predeterminada de cada medio.
if (($guide[1] === 'anime' || $guide[1] === 'manga') && isset($guide[2])) {
    $entry = $guide[2];  // Nombre-de-Anime|Manga
    $mediumRoutes = [
        '/'.$medium.'/'.$entry => '../controllers/medium.php',
        '/'.$medium.'/'.$entry.'/characters'=> '../controllers/medium.php',
        '/'.$medium.'/'.$entry.'/staff'=> '../controllers/medium.php',
        '/'.$medium.'/'.$entry.'/reviews'=> '../controllers/medium.php',
    ];
}

/**
 * Esta condición permite las siguientes URI:
 * /reviews
 * /review/new/anime ó /review/new/manga
 * /review/new/anime|manga/Nombre-De-Anime|Manga
 */

if ($guide[1] === 'review' && is_numeric($guide[2])) {
    $reviewEntry = $guide[2];  // Review ID
    $reviewRoutes = [
        '/review/'.$reviewEntry => '../controllers/review.php'
    ];
} else if ($guide[1] === 'review' && isset($guide[4])) {
    $reviewMedium = $guide[3]; // anime|manga
    $reviewEntry = $guide[4];  // Nombre-de-Anime|Manga
    $reviewRoutes = [
        '/review/new/'.$reviewMedium.'/'.$reviewEntry => '../controllers/review.php'
    ];
}

// Esta condición permite el siguiente tipo de URI: /activity/54
if ($guide[1] === 'activity' && isset($guide[2])) {
    if (is_numeric($guide[2])) {
        $postId = $guide[2];
        $postRoutes = [
            '/activity/' . $postId => '../controllers/activity.php'
        ];
    }
}

// Array con las todas las rutas de la página web.
$routes = array(
    '/' => '../controllers/home.php',
    '/home' => '../controllers/home.php',
    '/anime' => '../controllers/medium.php',
    '/manga' => '../controllers/medium.php',
    '/vn' => '../controllers/medium.php',
    '/edit' => '../controllers/edit.php',

    '/rankings' => '../controllers/rankings.php',
    '/rankings/anime' => '../controllers/rankings.php',
    '/rankings/manga' => '../controllers/rankings.php',
    '/rankingList' => '../controllers/rankingList.php',

    '/reviews' => '../controllers/review.php',
    '/review/new' => '../controllers/review.php',
    '/review/new/anime' => '../controllers/review.php',
    '/review/new/manga' => '../controllers/review.php',
    '/likeReview' => '../controllers/likeReview.php',

    '/search' => '../controllers/search.php',

    '/terms' => '../resources/views/terms.view.php',
    '/privacy' => '../resources/views/privacy.view.php',
    '/contact' => '../resources/views/contact.view.php',
    '/support' => '../resources/views/support.view.php',

    '/ep' => '../controllers/editProfile.php',
    '/sum' => '../controllers/sum.php',
    '/post' => '../controllers/post.php',
    '/reply' => '../controllers/activity.php',
    '/like' => '../controllers/like.php',
    '/bookmark' => '../controllers/bookmark.php',
    '/delete' => '../controllers/delete.php',
    '/follow' => '../controllers/follow.php',
    '/timeline' => '../controllers/timeline.php',
    '/report' => '../controllers/report.php',

    '/submit' => '../controllers/submit.php',
    '/submit/anime' => '../controllers/submit.php',
    '/submit/manga' => '../controllers/submit.php',
    '/submit/vn' => '../controllers/submit.php',
    '/submit/character' => '../controllers/submit.php',
    '/submit/staff' => '../controllers/submit.php',

    '/login' => '../controllers/login.php',
    '/register' => '../controllers/register.php',
    '/logout' => '../controllers/logout.php',

    '/add' => '../controllers/lists.php',

    '/404' => '../resources/views/404.view.php'
);

// Filtrar la $uri a traves del array de rutas y requerir el archivo al que refiere esa URI.
if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else if (($guide[1] === 'anime' || $guide[1] === 'manga') && isset($guide[2])) {
    if (array_key_exists($uri, $mediumRoutes)) {
        require $mediumRoutes[$uri];
    } else {
        header('Location: /404');
        die();
    }
} else if (isset($reviewRoutes)) {
   if (array_key_exists($uri, $reviewRoutes)) {
       require $reviewRoutes[$uri];
   } else {
       header('Location: /404');
       die();
   }
} else if (isset($postRoutes)) {
    if (array_key_exists($uri, $postRoutes)) {
        require $postRoutes[$uri];
    } else {
        header('Location: /404');
        die();
    }
} else {
    // En caso de no existir el URI solicitado, se procesa la información mediante profileRouter.php para encontrar un usuario.
    require 'profileRouter.php';
}