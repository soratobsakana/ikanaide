<?php

session_start();
require('resources/functions.php');

// $page viene de /index.php y almacena el path de la URI actual.
$medium = substr($page, 1);
require_once 'app/Listing.php';
require_once 'app/User.php';
$Listing = new Listing;

// Se comprueba que existe una query en la URI de nombre 'id' antes de realizar el extracto de la información.
if ($_GET) {
    
    // Con esto busco crear una condición de ID dinámica: SELECT * FROM $medium . _id = $id;
    $column = $medium . '_id';
    $id = $_GET['id'] ?? null;

    if (isset($_COOKIE['session'])) {
        $Session = new User;
        if ($Session -> validateSession() === TRUE) {
            $user_id = $_COOKIE['user_id'];

            // Comprobación de que el usuario tiene, o no, como favorito el anime o manga mostrado.
            $User = new Database;
            $result = $User -> db -> execute_query('select `favorite` from `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $id]);
            $favOrNot = $result -> fetch_column();
        } else {
            exit(header("Location: /logout"));
        }
    }

    // Asigno estos valores a una superglobal para utilizarlos en el fichero addToList.php
    $_SESSION[$medium . '_id'] = $id;
    $_SESSION['medium'] = $medium;

    if (isset($id)) {
        // Consulta de los datos a mostrar.
        $mediumInfo = $Listing -> getInfo($medium, $column, [$id]);
        $characters = $Listing -> getChars($medium, [$id]);
        $staff = $Listing -> getStaff($medium, [$id]);
        $reviews = $Listing -> getReviews($medium, [$id]);
        $members = $Listing -> getMembers($medium, $id);
        $favourites = $Listing -> getFavourites($medium, $id);



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

    $homeInfo = $Listing -> getHome($medium);

    require('resources/views/medium/mediumhome.view.php');
}