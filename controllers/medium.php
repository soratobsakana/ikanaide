<?php
require('resources/functions.php');

$medium = substr($page, 1);
$user_id = 1;
include 'app/Listing.php';
$listing = new Listing;

// Si existe un anime_id, se extrae la información del anime correspondiente a ese ID y se muestra al usuario mediante la vista '_animequery.view.php'.
if ($_GET) {
    
    $column = $medium . '_id';
    $id = $_GET['id'] ?? null;

    $mediumInfo = $listing -> selectAll($medium, $column, [$id]);
    $characters = $listing -> selectChars($medium, [$id]);
    $staff = $listing -> selectStaff($medium, [$id]);
    $reviews = $listing -> selectReviews($medium, [$id]);
    require('resources/views/' . $medium . '/_' . $medium . 'query.view.php');
    

} else {
    // Si no existe un id, mostramos una pagina predeterminada.
    // $page proviene de /index.php y almacena la URI actual.

    $homeInfo = $listing -> getHomeInfo($medium);

    require('resources/views/_mediumhome.view.php');
}