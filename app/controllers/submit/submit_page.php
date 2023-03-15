<?php

include('resources/functions.php');
require('database/conn.php');

if (isset($_POST['submit'])) {
    $test[] = $anime_id = $_GET['aid'] ?? null;
    $test[] = $title = $_POST['title'] ?? null;
    $test[] = $english_title = $_POST['english_title'] ?? null;
    $test[] = $japanese_title = $_POST['japanese_title'] ?? null;
    $test[] = $type = $_POST['type'] ?? null;
    $test[] = $episodes = $_POST['episodes'] ?? null;
    $test[] = $status = $_POST['status'] ?? null;
    $test[] = $start_date = $_POST['start_date'] ?? null;
    $test[] = $end_date = $_POST['end_date'] ?? null;
    $test[] = $desc = $_POST['desc'] ?? null;
    $test[] = $cover = $_POST['cover'] ?? null;
    $test[] = $header = $_POST['header'] ?? null;

    pre($test);

    // $stmt = $db -> prepare("INSERT INTO `edit_anime` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    // $stmt = bind_param('ssssssssssss', $animeId)
} else {
    // Propósito: mostrar un formulario adecuado para cada medio.
    // Cuando el usuario clica en 'Edit this page' en las paginas de query, se envia a la url: /submit?aid|mid|vid=X';
    // if ($_GET) comprueba que existe una query en la URL. Si no existe, muestra la página de /submit predeterminada.
    if ($_GET) {
        $medium = substr(parse_url($_SERVER['REQUEST_URI'])['query'], 0, 3);
        switch ($medium) {
            case 'aid':
                $anime_id = $_GET['aid'] ?? null;
                if (isset($anime_id)) {
                    $stmt = $db->prepare("SELECT * FROM anime WHERE anime_id = ?");
                    $stmt->bind_param('i', $anime_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows === 1) {
                        $row = $result->fetch_assoc();
                        foreach ($row as $key => $value) {
                            $animeInfo[$key] = $value;
                        }
                        $animeInfo['studios'] = 'Sunrise';
                    } else {
                        // Si ninguna entrada de la base de datos coincide con $_GET['aid'], manda un 404.
                        header('Location: /404');
                    }

                    foreach ($animeInfo as $key => $value) {
                        if (!($key === 'members' || $key === 'favorited' || $key === 'anime_id')) {
                            $animeForm[$key] = $value;
                        }
                    }
                }
                break;
            case 'mid':
                $manga_id = $_GET['id'] ?? null;
                break;
            case 'vid':
                $vn_id = $_GET['id'] ?? null;
                break;
            default:
                header('Location: /404');
        }
    }
}


$db -> close();

require('resources/views/submit/submit.view.php');