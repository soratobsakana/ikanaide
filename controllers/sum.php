<?php

// This file is used to sum one single episode or chapter to a user's list entry.
namespace App;

if ((!empty($_GET['medium']) && ($_GET['medium'] === 'anime' || $_GET['medium'] === 'manga')) && (!empty($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT))) {
    if (User::validateSession()) {
        $data['user_id'] = $_COOKIE['user_id'];
        $data['medium_id'] = $_GET['id'];
        $data['medium'] = $_GET['medium'];

        // Comprobación de que el usuario ha visto menos episodios/capítulos de los totales.
        $episodesOrChapters = Listing::getEpisodesOrChapters($data['medium'], $data['medium_id']);
        $userCurrent = User::getEpisodesOrChapters($data['medium'], $data['medium_id'], $data['user_id']);
        if ($userCurrent < $episodesOrChapters) {
            if (User::sumOne($data)) {

                // Se comprueba si el usuario quiere compartir, en un post generado automáticamente, las actualizaciones que realiza sobre su lista de anime|manga.
                if (User::shares($data['user_id'])) {
                    Activity::listUpdate($data);
                }

                if ($episodesOrChapters - $userCurrent === 1) {
                    User::setListStatus($data['medium'], $data['medium_id'], 'completed', $data['user_id']);
                }

                // Si User::sumOne() devuelve true, se reenvía al usuario a la página desde la que viene mediante la variable $_SERVER['HTTP_REFERER'].
                if (!empty($_SERVER['HTTP_REFERER'])) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    die();
                }
            } else {
                header('Location: /404');
                die();
            }
        } else {
            if (!empty($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                die();
            }
        }
    } else {
        header('Location: /logout');
        die();
    }
} else {
    header('Location: /404');
    die();
}
