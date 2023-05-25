<?php

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
                        switch ($key) {
                            case 'title':
                            case 'english_title':
                            case 'japanese_title':
                            case 'desc':
                                $value !== '' ? $animeData[$key] = $value : $animeData[$key] = null;
                                break;
                            case 'type':
                                if ($value !== 'tv' || $value !== 'movie' || $value !== 'ova' ||$value !== 'mv') {
                                    $animeData[$key] = $value;
                                } else {
                                    $animeData[$key] = 'tv'; // Valor por default
                                }
                                break;
                            case 'status':
                                if ($value !== 'announced' || $value !== 'completed' || $value !== 'finished') {
                                    $animeData[$key] = $value;
                                } else {
                                    $animeData[$key] = 'announced'; // Valor por default
                                }
                                break;
                            case 'episodes':
                                if (filter_var($value, FILTER_VALIDATE_INT)) {
                                    $animeData[$key] = intval($value);
                                } else {
                                    $animeData[$key] = null;
                                }
                                break;
                            case 'start_date':
                            case 'end_date':
                                $date = date_parse($value);
                                if (checkdate($date['month'], $date['day'], $date['year']) && strlen($date['year']) === 4) {
                                    $animeData[$key] = $value;
                                } else {
                                    $animeData[$key] = null;
                                }
                                break;
                        }
                        break;
                    case 'manga':
                        switch ($key) {
                            case 'title':
                            case 'english_title':
                            case 'japanese_title':
                            case 'desc':
                                $value !== '' ? $mangaData[$key] = $value : $mangaData[$key] = null;
                                break;
                            case 'type':
                                if ($value !== 'manga' || $value !== 'manhwa' || $value !== 'ln') {
                                    $mangaData[$key] = $value;
                                } else {
                                    $mangaData[$key] = 'manga'; // Valor por default
                                }
                                break;
                            case 'status':
                                if ($value !== 'announced' || $value !== 'completed' || $value !== 'finished') {
                                    $mangaData[$key] = $value;
                                } else {
                                    $mangaData[$key] = 'announced'; // Valor por default
                                }
                                break;
                            case 'volumes':
                            case 'chapters':
                                if (filter_var($value, FILTER_VALIDATE_INT)) {
                                    $mangaData[$key] = intval($value);
                                } else {
                                    $mangaData[$key] = null;
                                }
                                break;
                            case 'start_date':
                            case 'end_date':
                                $date = date_parse($value);
                                if (checkdate($date['month'], $date['day'], $date['year']) && strlen($date['year']) === 4) {
                                    $mangaData[$key] = $value;
                                } else {
                                    $mangaData[$key] = null;
                                }
                                break;
                        }
                        $mangaData[$key] = $value ?? null;
                        break;
                    case 'character':
                        $characterData[$key] = $value ?? null;
                        break;
                    case 'staff':
                        $staffData[$key] = $value ?? null;
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
    print "<a class='low-opacity link' href='/submit'>Click here to go back.</a>";
} else {
    require('resources/views/submit/submit.view.php');
}