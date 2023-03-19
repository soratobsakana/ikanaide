<?php
require_once('database/conn.php');
require('resources/functions.php');

switch ($page) {
    case '/anime':
        $anime_id = $_GET['id'] ?? null;
        break;
    case '/manga':
        $manga_id = $_GET['id'] ?? null;
        break;
    case '/vn':
        $vn_id = $_GET['id'] ?? null;
        break;
}

$user_id = 1;

// Si existe un anime_id, se extrae la información del anime correspondiente a ese ID y se muestra al usuario mediante la vista '_animequery.view.php'.
if (isset($anime_id) || isset($manga_id) || isset($vn_id)) {
    switch ($page) {
        case '/anime':
            require '_anime_anime.php';
            break;
        case '/manga':
            require '_anime_manga.php';
            break;
        case '/vn':
            require '_anime_vn.php';
            break;
    }

} else {
    // Si no existe un id, mostramos una pagina predeterminada.
    // $page proviene de /index.php y almacena la URI actual.
    switch ($page) {
        case '/anime':
            $stmt = $db -> prepare('SELECT anime_id, title, cover FROM anime');
            $stmt -> execute();
            $result = $stmt -> get_result();
            break;
        case '/manga':
            $stmt = $db -> prepare('SELECT manga_id, title, cover FROM manga');
            $stmt -> execute();
            $result = $stmt -> get_result();
            break;
        case '/vn':
            $stmt = $db -> prepare('SELECT vn_id, title, cover FROM vn');
            $stmt -> execute();
            $result = $stmt -> get_result();
            break;
    }
    $db -> close();

    require('resources/views/anime/_animehome.view.php');
}