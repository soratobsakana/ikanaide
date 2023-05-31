<?php

require('database/conn.php');
require_once 'app/Listing.php';
require_once 'app/User.php';
require_once 'app/Submit.php';

$Listing = new Listing;
$User = new User;
$Submit = new Submit;

$id = $_COOKIE['user_id'] ?? null;

if (isset($_POST['submit'])) {
    // Recolecta de datos.
    foreach ($_POST as $key => $value) {
        if ($key !== 'submit' && $key !== 'studios' && $key !== 'publisher') {
            if ($_GET) {
                $submissionType = parse_url($_SERVER['REQUEST_URI'])['query'];

                // Comprobación de que la URI actual es una con la que poder trabajar:
                $submissionTypes = ['anime', 'manga', 'character', 'staff'];
                if (!in_array($submissionType, $submissionTypes)) {
                    header('Location: /404');
                    die();
                }

                // Proceso de validación de la información:
                switch ($submissionType) {
                    case 'anime':
                        switch ($key) {
                            case 'title':
                            case 'english_title':
                            case 'japanese_title':
                            case 'desc':
                                $value !== '' ? $animeData[$key] = $value : $animeData[$key] = null;
                                if (is_null($animeData['title'])) {
                                    exit('There needs to be a title. <a class="low-opacity link" href="/submit">Comeback</a>');
                                }
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
                                if (is_null($mangaData['title'])) {
                                    exit('There needs to be a title. <a class="low-opacity link" href="/submit/manga">Comeback</a>');
                                }
                                break;
                            case 'format':
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
                        break;
                    case 'character':
                        $value !== '' ? $characterData[$key] = $value : $characterData[$key] = null;
                        if (is_null($characterData['family_name']) && is_null($characterData['given_name']) && is_null($characterData['alias']) && is_null($characterData['japanese name'])) {
                            exit('The character needs to be identified with some name. <a class="low-opacity link" href="/submit/character">Comeback</a>');
                        }
                        break;
                    case 'staff':
                        $value !== '' ? $staffData[$key] = $value : $staffData[$key] = null;
                        if (is_null($staffData['family_name']) && is_null($staffData['given_name']) && is_null($staffData['alias']) && is_null($staffData['japanese name'])) {
                            exit('The staff needs to be identified with some name. <a class="low-opacity link" href="/submit/manga">Comeback</a>');
                        }
                        break;
                }
            }
        }
    }

    // Validación e inserción de las imágenes.
    foreach ($_FILES as $fileInput => $values) {
        // Extracción de la información de las imágenes
        $file['path'] = $values['tmp_name'];


        // Si no se ha subido ningún archivo, $file['path'] contendrá una string vacía.
        if ($file['path'] !== '') {

            $file['size'] = filesize($file['path']);
            $file['info'] = finfo_open(FILEINFO_MIME_TYPE);
            $file['type'] = finfo_file($file['info'], $file['path']);

            // Validación de la información de las imagenes
            if (!($file['size'] <= 0 || $file['size'] > 3145728)) {
                $allowedMIMES = [
                    'image/png' => 'png',
                    'image/jpeg' => 'jpg',
                    'image/webp' => 'webp'
                ];

                // Comprobar que el archivo es una imagen mediante la extensión del mismo.
                if (in_array($file['type'], array_keys($allowedMIMES))) {
                    $extension = $allowedMIMES[$file['type']];
                } else {
                    exit('Images can only be of .png, .jpg and .webp extensions.');
                }
            } else {
                exit('Images size can\'t be greater than 3MB.');
            }

            // Asignación del nombre del archivo y la ruta absoluta donde guardar el archivo. DIRECTORY_SEPARATOR utiliza "/" o "\" dependiendo del SO en el que se esté ejecutando este archivo.
            // DIR proviene de /index.php e indica la ruta absoluta de la raiz de esta página web.
            if ($User -> validateSession() && $_COOKIE['username'] === 'adrian') {
                $targetDirectory = DIR . DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . $submissionType . DIRECTORY_SEPARATOR . $fileInput;
            } else {
                $targetDirectory = DIR . DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . "submissions" . DIRECTORY_SEPARATOR . $submissionType . DIRECTORY_SEPARATOR . $fileInput;
            }
            $filename = $submissionType."_".uniqid();
            $newFilepath = $targetDirectory . DIRECTORY_SEPARATOR . $filename . "." . $extension;

            // $sqlFilepath será el valor introducido en la base de datos.
            if ($User -> validateSession() && $_COOKIE['username'] === 'adrian') {
                $sqlFilepath = '/storage/public/' . $submissionType . '/' . $fileInput . '/' . $filename . "." . $extension;
            } else {
                $sqlFilepath = '/storage/submissions/' . $submissionType . '/' . $fileInput . '/' . $filename . "." . $extension;
            }

            // Copio el archivo desde la ruta temporal hacia la ruta final. Si funciona, lo elimino de dicha ruta temporal y asigno $sqlFilepath al array que hace de parámetro en User::editProfile().
            if (!copy($file['path'], $newFilepath)) {
                print 'a';
                die();
                header('Location: /404');
                die();
            } else {
                // Elimino el archivo temporal mediante unlink().
                unlink($file['path']);
                switch($submissionType) {
                    case 'anime':
                        $animeData[$fileInput] = $sqlFilepath;
                        break;
                    case 'manga':
                        $mangaData[$fileInput] = $sqlFilepath;
                        break;
                    case 'character':
                        $characterData[$fileInput] = $sqlFilepath;
                        break;
                    case 'staff':
                        $staffData[$fileInput] = $sqlFilepath;
                        break;
                }
            }
        }
    }

    // Inserción de la información.
    switch ($submissionType) {
        case 'anime':
            if ($User -> validateSession()) {
                if ($_COOKIE['username'] === 'adrian') {
                    $status = $Submit -> submitNewAnime($animeData); // True or False
                } else {
                    $status = $Submit -> newAnimeProposal($animeData, $_COOKIE['user_id']); // True or False
                }
            } else {
                $status = false;
            }
            break;
        case 'manga':
            if ($User -> validateSession()) {
                if ($_COOKIE['username'] === 'adrian') {
                    $status = $Submit -> submitNewManga($mangaData); // True or False
                } else {
                    $status = $Submit -> newMangaProposal($mangaData, $_COOKIE['user_id']); // True or False
                }
            } else {
                $status = false;
            }
            break;
        case 'character':
            if ($User -> validateSession()) {
                if ($_COOKIE['username'] === 'adrian') {
                    $status = $Submit -> submitNewCharacter($characterData); // True or False
                } else {
                    $status = $Submit -> newCharacterProposal($characterData, $_COOKIE['user_id']); // True or False
                }
            } else {
                $status = false;
            }
            break;
        case 'staff':
            if ($User -> validateSession()) {
                if ($_COOKIE['username'] === 'adrian') {
                    $status = $Submit -> submitNewStaff($staffData); // True or False
                } else {
                    $status = $Submit -> newStaffProposal($staffData, $_COOKIE['user_id']); // True or False
                }
            } else {
                $status = false;
            }
            break;
        default:
            $status = false;
    }
    if ($status === TRUE) {
        print '<p>Your '.$submissionType.' submission has been succesful. Thanks!</p>';
        print "<a class='low-opacity link' href='/submit'>Click here to go back.</a>";
    } else if ($status === FALSE) {
        print '<p>Your '.$submissionType.' submission was not succesful. Sorry</p>';
        print "<a class='low-opacity link' href='/submit'>Click here to go back.</a>";
    }
} else {
    require('resources/views/submit/submit.view.php');
}