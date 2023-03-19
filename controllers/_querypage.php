<?php

$mediumTable = 'vn';
$mediumIdColumn = 'vn_id';

$stmt = $db -> prepare("SELECT * FROM $mediumTable WHERE $mediumIdColumn = ?");
$stmt -> bind_param('i', $vn_id);
$stmt -> execute();
// get_result() no funciona con $stmt porque pertenece a la clase mysqli_result y no a mysqli_stmt.
$result = $stmt -> get_result();

// Propósito: crear un array asociativo con la información de la fila escogida desde la tabla `vn`. Cada par del array tendrá este formato: ['nombre_columna'] => 'valor_columna'.
if ($result -> num_rows === 1) {
    $row = $result->fetch_assoc();
    foreach ($row as $key => $value) {
        $vnInfo[$key] = $value;
    }

    // Información de personajes y asociación.
    $stmt = $db->prepare("SELECT `character`.*, `character_vn`.role FROM `character`, `character_vn` WHERE `character_vn`.`vn_id` = ? AND `character`.`character_id`=`character_vn`.character_id");
    $stmt->bind_param('i', $vn_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key => $value) {
                $characterInfo[$key] = $value;
            }
            // Este array guarda guarda un array asociativo por cada personaje encontrado en la base de datos.
            $characters[] = $characterInfo;
        }
    }


    // Información de staff y asociación.
    $stmt = $db->prepare("SELECT `staff`.*, `staff_vn`.`role` FROM `staff`, `staff_vn` WHERE `staff_vn`.`vn_id` = ? AND `staff`.`staff_id`=`staff_vn`.staff_id");
    $stmt->bind_param('i', $vn_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key => $value) {
                $staffInfo[$key] = $value;
            }
            $staff[] = $staffInfo;
        }
    }


    // Información de reviews y asociación.
    $stmt = $db->prepare("SELECT `review`.* FROM `review`, `review_vn` WHERE `review_vn`.`vn_id` = ? AND `review`.review_id = `review_vn`.`review_id`");
    $stmt->bind_param('i', $vn_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key => $value) {
                $reviewInfo[$key] = $value;
            }
            $reviews[] = $reviewInfo;
        }
    }

    // Una vez la información ha sido recopilada, cierro la conexión y muestro la página al usuario.
    $db->close();
    require('resources/views/vn/_vnquery.view.php');
} else {
    header('Location: /404');
}