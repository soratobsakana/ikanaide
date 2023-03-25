<?php
require('resources/functions.php');

// $page viene de /index.php y almacena el path de la URI actual.
$medium = substr($page, 1);
$user_id = 1;
include 'app/Listing.php';
$listing = new Listing;

// Se comprueba que existe una query en la URI de nombre 'id' antes de realizar el extracto de la información.
if ($_GET) {
    
    // Con esto busco crear una condición de ID dinámica: SELECT * FROM $medium . _id = $id;
    $column = $medium . '_id';
    $id = $_GET['id'] ?? null;

    if (isset($id)) {
        $mediumInfo = $listing -> getInfo($medium, $column, [$id]);
        $characters = $listing -> getChars($medium, [$id]);
        $staff = $listing -> getStaff($medium, [$id]);
        $reviews = $listing -> getReviews($medium, [$id]);
        if ($mediumInfo !== null) {
            require('resources/views/medium/mediumpage.view.php');
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

    require('resources/views/medium/mediumhome.view.php');
}