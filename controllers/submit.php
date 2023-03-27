<?php

require('resources/functions.php');
require('database/conn.php');

$id = $_COOKIE['user_id'] ?? null;

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
            $stmt = $db -> prepare('INSERT INTO `submit_anime` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, default)');
            $stmt -> bind_param('ssssissssssi',
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
                $animeData['header'],
                $id
            );
            $stmt -> execute();
            break;
        case 'manga':
            $stmt = $db -> prepare('INSERT INTO `submit_manga` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, default)');
            $stmt -> bind_param('ssssiissssssi',
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
                $mangaData['header'],
                $id
            );
            $stmt -> execute();
            break;
        case 'vn':
            $stmt = $db -> prepare('INSERT INTO `submit_vn` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, default)');
            $stmt -> bind_param('ssssssssi',
                $vnData['title'],
                $vnData['english_title'],
                $vnData['japanese_title'],
                $vnData['duration'],
                $vnData['released'],
                $vnData['description'],
                $vnData['cover'],
                $vnData['header'],
                $id
            );
            $stmt -> execute();
            break;
        case 'character':
            $stmt = $db -> prepare('INSERT INTO `submit_character` VALUES (null, ?, ?, ?, ?, ?, ?, ?, default)');
            $stmt -> bind_param('ssssssi',
                $characterData['family_name'],
                $characterData['given_name'],
                $characterData['alias'],
                $characterData['japanese_name'],
                $characterData['biography'],
                $characterData['picture'],
                $id
            );
            $stmt -> execute();
            break;
        case 'staff':
            $stmt = $db -> prepare('INSERT INTO `submit_staff` VALUES (null, ?, ?, ?, ?, ?, ?, ?, default)');
            $stmt -> bind_param('ssssssi',
                $staffData['family_name'],
                $staffData['given_name'],
                $staffData['alias'],
                $staffData['japanese_name'],
                $staffData['biography'],
                $staffData['picture'],
                $id
            );
            $stmt -> execute();
            break;
    }
    $db -> close();
    print '<p>Your '.$submissionType.' submission has been succesful. Thanks!</p>';
    print "<a href='/submit'>Click here to go back.</a>";
} else {
    require('resources/views/submit/submit.view.php');
}