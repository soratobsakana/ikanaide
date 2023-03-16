<?php
    require('database/conn.php');

    $tableName = 'edit_anime';
$stmt = $db -> prepare('SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ?;');
$stmt -> bind_param('s', $tableName);
$stmt -> execute();
$result2 = $stmt -> get_result();
$item = $result2 -> fetch_array();

var_dump($item[0]);




?>