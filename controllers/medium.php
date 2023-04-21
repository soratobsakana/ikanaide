<?php

session_start(); // I use this to pass information about the current entry to the edit form through $_SESSION.
require_once('resources/functions.php');
require_once 'app/Listing.php';
require_once 'app/User.php';


// $uri viene de /routes/web.php
$guide = explode("/", $uri);
$medium = $guide[1]; // anime|manga

$Listing = new Listing;

// Si $guide[2] tiene asignado un valor, se espera que la URI sea algo así: /anime|manga/Nombre-de-anime|manga
if (isset($guide[2])) {
    $entryOnDB = str_replace('-', ' ', $guide[2]);
    $result = $Listing -> exists($medium, $entryOnDB);

    if ($result !== false) {
        $id = $Listing -> exists($medium, $entryOnDB);

        // Con esto busco crear una condición de ID dinámica: SELECT * FROM $medium . _id = $id;
        $column = $medium . '_id';

        if (isset($_COOKIE['session'])) {
            $Session = new User;
            if ($Session -> validateSession() === TRUE) {
                $user_id = $_COOKIE['user_id'];

                // Extraigo la información de la lista (`animelist` o `mangalist`) del usuario logeado para utilizarla en mediumpage.view.php.
                $User = new User;
                $listEntry = $User -> getListEntry($medium, $id, $user_id);
            } else {
                exit(header("Location: /logout"));
            }
        }

        // Asigno estos valores a una superglobal para utilizarlos en el fichero addToList.php.
        $_SESSION[$medium . '_id'] = $id;
        $_SESSION['medium'] = $medium;
        $_SESSION['entry'] = $entry;

        // Consulta de los datos a mostrar.
        $mediumInfo = $Listing -> getInfo($medium, $column, [$id]);
        $characters = $Listing -> getChars($medium, [$id]);
        $staff = $Listing -> getStaff($medium, [$id]);
        $reviews = $Listing -> getReviews($medium, [$id]);
        $members = $Listing -> getMembers($medium, $id);
        $favourited = $Listing -> getFavourites($medium, $id);
        $rank = $Listing -> getRank($medium, $id);
        $popularity = $Listing -> getPopularity($medium, $id);
        $score = $Listing -> getScore($medium, $id);

        if ($mediumInfo !== null) {
            // Introduzco el número de episodios|capitulos en una $_SESSION para utilizar en addToList.php.
            $medium === 'anime' ? $counter = 'episodes' : $counter = 'chapters';
            $_SESSION['counter'] = $mediumInfo[$counter];

            require('resources/views/medium/mediumpage.view.php');
        } else {
            header('Location: /404');
        }
    } else {
        exit(header('Location: /404'));
    }
} else {
    // Si no se ha indicado un segundo elemento en la URI, se muestra una página de inicio predeterminada.
    $homeInfo = $Listing -> getHome($medium);
    require('resources/views/medium/mediumhome.view.php');
}