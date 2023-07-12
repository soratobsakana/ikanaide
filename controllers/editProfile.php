<?php

namespace App;

if (isset($_POST['edit-profile_submit'])) {
    $postFields = ['edit-profile_bio', 'edit-profile_country', 'edit-profile_birthday', 'edit-profile_twitter', 'edit-profile_github', 'edit-profile_discord', 'edit-profile_website', 'edit-profile_submit'];
    foreach ($postFields as $postField) {
        if (!in_array($postField, $postFields)) {
            header('Location: /404');
            die();
        }
    }

    $filesFields = ['edit-profile_pfp', 'edit-profile_header'];
    foreach ($filesFields as $filesField) {
        if (!in_array($filesField, $filesFields)) {
            header('Location: /404');
            die();
        }
    }

    foreach ($_FILES as $fileInput => $values) {
        // Extracción de la información de las imágenes
        $file['path'] = $values['tmp_name'];

        // Si no se ha subido ningún archivo, $file['path'] contendrá una string vacía.
        if ($file['path'] !== '') {
            $file['size'] = filesize($file['path']);
            $file['info'] = finfo_open(FILEINFO_MIME_TYPE);
            $file['type'] = finfo_file($file['info'], $file['path']);

            // Validación de la información de las imagenes
            if (!($file['size'] <= 0 || $file['size'] > 1048576 )) {
                $allowedMIMES = [
                    'image/png' => 'png',
                    'image/jpeg' => 'jpg',
                    'image/webp' => 'webp'
                ];
    
                // Comprobar que el archivo es una imagen mediante la extensión del mismo.
                if (in_array($file['type'], array_keys($allowedMIMES))) {
                    $extension = $allowedMIMES[$file['type']];
                }
            } else {
                exit('Images size can\'t be greater than 3MB.');
            }
    
            // Asignación del nombre del archivo y la ruta absoluta donde guardar el archivo. DIRECTORY_SEPARATOR utiliza "/" o "\" dependiendo del SO en el que se esté ejecutando este archivo.
            // DIR proviene de /index.php e indica la ruta absoluta de la raiz de esta página web.
            switch ($fileInput) {
                case 'edit-profile_pfp':
                    $targetDirectory = DIR . "storage" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR . "pfp";
                    $filename = "pfp_".uniqid();
                    $newFilepath = $targetDirectory . DIRECTORY_SEPARATOR . $filename . "." . $extension;

                    // $sqlFilepath será el valor introducido en la base de datos.
                    $sqlFilepath = '/storage/users/pfp/' . $filename . "." . $extension;

                    $currentImageType = 'pfp';
                    break;
                case 'edit-profile_header':
                    $targetDirectory = DIR . "storage" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR . "header";
                    $filename = "header_".uniqid();
                    $newFilepath = $targetDirectory . DIRECTORY_SEPARATOR . $filename . "." . $extension;


                    // $sqlFilepath será el valor introducido en la base de datos.
                    $sqlFilepath = '/storage/users/header/' . $filename . "." . $extension;
                    
                    $currentImageType = 'header';
                    break;
            }
    
            // Copio el archivo desde la ruta temporal hacia la ruta final. Si funciona, lo elimino de dicha ruta temporal y asigno $sqlFilepath al array que hace de parámetro en User::editProfile().
            if (!copy($file['path'], $newFilepath)) {
                header('Location: /404');
                die();
            } else {
                // Elimino el archivo temporal mediante unlink().
                unlink($file['path']);
                $profileEdition[$currentImageType] = $sqlFilepath;
            }
        }
    }
    
    foreach ($_POST as $key => $value) {
        if ($key !== 'edit-profile_submit') {
            switch ($key) {
                case 'edit-profile_bio':
                    (!empty($value)) ? $profileEdition['biography'] = $value : $profileEdition['biography'] = null;
                    break;
                case 'edit-profile_country':
                    (!empty($value)) ? $profileEdition['country'] = $value : $profileEdition['country'] = null;
                    break;
                case 'edit-profile_birthday':
                    $date = date_parse($value);
                    if (checkdate($date['month'], $date['day'], $date['year']) && strlen($date['year']) === 4) {
                        $profileEdition['birthday'] = $value;
                    } else {
                        $profileEdition['birthday'] = null;
                    }
                    break;
                case 'edit-profile_twitter':
                    // El número máximo de caracteres permitidos en un nombre de usuario de Twitter es 15.
                    if (strlen($value) < 16 && strlen($value) > 0) {
                        $profileEdition['twitter'] = $value;
                    } else {
                        $profileEdition['twitter'] = null;
                    }
                    break;
                case 'edit-profile_github':
                    // El número máximo de caracteres permitidos en un nombre de usuario de GitHub es 39.
                    if (strlen($value) < 40 && strlen($value) > 0) {
                        $profileEdition['github'] = $value;
                    } else {
                        $profileEdition['github'] = null;
                    }
                    break;
                case 'edit-profile_discord':
                    // El formato de los nombres de usuario de la aplicación Discord es username#4923. Compruebo que se ha introducido correctamente separando 'username' del tag (#XXXX).
                    if (isset($value) && strlen($value) > 6) {
                        $username = strtok($value, '#');
                        $tag = substr($value, -5);
                        if ((strlen($username) < 33 && strlen($username) > 1) && (substr($tag, 0, 1) === '#') && is_numeric(substr($tag, 1, 4))) {
                            $profileEdition['discord'] = $value;
                        } else {
                            $profileEdition['discord'] = null;
                        }
                    } else {
                        $profileEdition['discord'] = null;
                    }
                    break;
                case 'edit-profile_website':
                    if (!empty($_POST[$key]) && filter_var($value, FILTER_VALIDATE_URL)) {
                        $profileEdition['website'] = $value;
                    } else {
                        $profileEdition['website'] = null;
                    }
                    break;
                default:
                    break;
            }
        }
    }

    if (User::validateSession()) {
        $userId = $_COOKIE['user_id'];
        if (User::editProfile($profileEdition, $userId)) {
            header('Location: /'.$_COOKIE['username']);
            die();
        } else {
            exit('Sorry,there was an error updating your profile. Comeback clicking <a class="low-opacity link" href="/'.$_COOKIE['username'].'">here</a>');
        }
    } else {
        header('Location: /logout');
        die();
    }
}