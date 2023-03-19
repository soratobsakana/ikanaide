<?php

require 'database/conn.php';
require 'resources/functions.php';

switch ($page) {
    case '/anime':
        $stmt = $db -> prepare('SELECT anime_id, title, cover FROM anime');
        $stmt -> execute();
        $result = $stmt -> get_result();
        break;
    case '/manga':
        $stmt = $db -> prepare('SELECT manga_id, title, cover FROM manga');
        $stmt -> execute();
        $result = $stmt -> get_result();
        break;
    case '/vn':
        $stmt = $db -> prepare('SELECT vn_id, title, cover FROM vn');
        $stmt -> execute();
        $result = $stmt -> get_result();
        break;
}
$db -> close();

require('resources/views/anime/_animehome.view.php');