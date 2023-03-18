<?php
require('resources/functions.php');
require('database/conn.php');

if (isset($_POST['submit'])) {
    // Recolecta de datos.
    foreach ($_POST as $key => $value) {
        if ($key !== 'submit' && $key !== 'studios' && $key !== 'publisher') {
            if ($_GET) {
                $submissionType = parse_url($_SERVER['REQUEST_URI'])['query'];
                switch ($submissionType) {
                    case 'anime':
                        $animeData[$key] = $value;
                        break;
                    case 'manga':
                        $mangaData[$key] = $value;
                        break;
                    case 'vn':
                        $vnData[$key] = $value;
                        break;
                    case 'character':
                        $characterData[$key] = $value;
                        break;
                    case 'staff':
                        $staffData[$key] = $value;
                        break;
                }
            }
        }
    }

    // Inserción de la información.
    switch ($submissionType) {
        case 'anime':
            $stmt = $db -> prepare('INSERT INTO `submit_anime` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )');
            $stmt -> bind_param('ssssissssss',
                $animeData['title'],
                $animeData['english_title'],
                $animeData['japanese_title'],
                $animeData['type'],
                $animeData['episodes'],
                $animeData['status'],
                $animeData['start_date'],
                $animeData['end_date'],
                $animeData['desc'],
                $animeData['cover'],
                $animeData['header']
            );
            $stmt -> execute();
            break;
        case 'manga':
            $stmt = $db -> prepare('INSERT INTO `submit_manga` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt -> bind_param('sssssssssss',
                $mangaData['title'],
                $mangaData['english_title'],
                $mangaData['japanese_title'],
                $mangaData['format'],
                $mangaData['volumes'],
                $mangaData['chapters'],
                $mangaData['status'],
                $mangaData['start_date'],
                $mangaData['end_date'],
                $mangaData['desc'],
                $mangaData['cover'],
                $mangaData['header']
            );
            $stmt -> execute();
            break;
        case 'vn':

            break;
        case 'character':
            $stmt = $db -> prepare('INSERT INTO `submit_character` VALUES (null, ?, ?, ?, ?, ?, ?)');
            $stmt -> bind_param('sssssssssss',
                $characterData['family_name'],
                $characterData['given_name'],
                $characterData['alias'],
                $characterData['japanese_name'],
                $characterData['biography'],
                $characterData['picture']
            );
            $stmt -> execute();
            break;
        case 'staff':
            $stmt = $db -> prepare('INSERT INTO `submit_staff` VALUES (null, ?, ?, ?, ?, ?, ?)');
            $stmt -> bind_param('sssssssssss',
                $staffData['family_name'],
                $staffData['given_name'],
                $staffData['alias'],
                $staffData['japanese_name'],
                $staffData['biography'],
                $staffData['picture']
            );
            $stmt -> execute();
            break;
    }

} else {
    require('resources/views/submit/submit.view.php');
}