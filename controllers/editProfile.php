<?php

require_once 'app/User.php';
require_once 'resources/functions.php';
$User = new User;

if (isset($_POST['edit-profile_submit'])) {
    $postFields = ['edit-profile_bio', 'edit-profile_country', 'edit-profile_birthday', 'edit-profile_twitter', 'edit-profile_github', 'edit-profile_discord', 'edit-profile_website', 'edit-profile_submit'];
    foreach ($postFields as $postField) {
        if (!in_array($postField, $postFields)) {
            header('Location: /404');
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
            }
        }
    }

    if ($User -> validateSession()) {
        $userId = $_COOKIE['user_id'];
        if ($User -> editProfile($profileEdition, $userId)) {
            header('Location: /'.$_COOKIE['username']);
        } else {
            exit('Sorry,there was an error updating your profile. Comeback clicking <a class="low-opacity link" href="/'.$_COOKIE['username'].'">here</a>');
        }
    } else {
        header('Location: /logout');
    }
}