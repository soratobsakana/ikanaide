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

    if (isset($id)) {
        $mediumInfo = $listing -> getInfo($medium, $column, [$id]);
        $characters = $listing -> getChars($medium, [$id]);
        $staff = $listing -> getStaff($medium, [$id]);
        $reviews = $listing -> getReviews($medium, [$id]);
        if ($mediumInfo !== null) {
            require('resources/views/' . $medium . '/_' . $medium . 'query.view.php');
        } else {
            header('Location: /404');
        }
    } else {
        header('Location: /404');
    }

   
    

} else {
    // Si no existe un id, mostramos una pagina predeterminada.
    // $page proviene de /index.php y almacena la URI actual.

    $homeInfo = $listing -> getHome($medium);

    require('resources/views/_mediumhome.view.php');
}