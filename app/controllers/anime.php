<?php
require_once('database/conn.php');
require('resources/functions.php');

// Queried anime's general information.
$anime_id = 1;
$user_id = 1;

$stmt = $db -> prepare("SELECT * FROM anime WHERE anime_id = ?");
$stmt -> bind_param('i', $anime_id);
$stmt -> execute();
// get_result() no funciona con $stmt porque pertenece a la clase mysqli_result y no a mysqli_stmt.
$result = $stmt -> get_result();

// Propósito: crear un array asociativo con la información de la fila escogida desde la tabla `anime`. Cada par del array tendrá este formato: ['nombre_columna'] => 'valor_columna'.
if ($result -> num_rows == 1) {
    $row = $result -> fetch_assoc();
    foreach ($row as $key => $value) {
        $animeInfo[$key] = $value;
    }
}

$animeInfo['studios'] = 'Sunrise';

$formattedStartDate = strtolower(dateFormat($animeInfo['start_date']));
$formattedEndDate = strtolower(dateFormat($animeInfo['end_date']));


// Información de personajes y asociación.
$stmt = $db -> prepare("SELECT `character`.*, `character_anime`.role FROM `character`, `character_anime` WHERE `character_anime`.`anime_id` = ? AND `character`.`character_id`=`character_anime`.character_id");
$stmt -> bind_param('i', $anime_id);
$stmt -> execute();
$result = $stmt -> get_result();

if ($result -> num_rows > 0) {
    while ($row = $result -> fetch_assoc()) {
        foreach ($row as $key => $value) {
            $characterInfo[$key] = $value;
        }
        // Este array guarda guarda un array asociativo por cada personaje encontrado en la base de datos.
        $characters[] = $characterInfo;
    }
}


// Información de staff y asociación.
$stmt = $db -> prepare("SELECT `staff`.*, `staff_anime`.`role` FROM `staff`, `staff_anime` WHERE `staff_anime`.`anime_id` = ? AND `staff`.`staff_id`=`staff_anime`.staff_id");
$stmt -> bind_param('i', $anime_id);
$stmt -> execute();
$result = $stmt -> get_result();

if ($result -> num_rows > 0) {
    while ($row = $result -> fetch_assoc()) {
        foreach ($row as $key => $value) {
            $staffInfo[$key] = $value;
        }
        $staff[] = $staffInfo;
    }
}


// Información de reviews y asociación.
$stmt = $db -> prepare("SELECT `review`.* FROM `review`, `review_anime` WHERE `review_anime`.`anime_id` = ? AND `review`.review_id = `review_anime`.`review_id`");
$stmt -> bind_param('i', $anime_id);
$stmt -> execute();
$result = $stmt -> get_result();

if ($result -> num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $key => $value) {
            $reviewInfo[$key] = $value;
        }
        $reviews[] = $reviewInfo;
    }
}