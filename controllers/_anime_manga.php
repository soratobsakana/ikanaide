<?php

$stmt = $db -> prepare("SELECT * FROM manga WHERE manga_id = ?");
$stmt -> bind_param('i', $manga_id);
$stmt -> execute();
// get_result() no funciona con $stmt porque pertenece a la clase mysqli_result y no a mysqli_stmt.
$result = $stmt -> get_result();

// Propósito: crear un array asociativo con la información de la fila escogida desde la tabla `manga`. Cada par del array tendrá este formato: ['nombre_columna'] => 'valor_columna'.
if ($result -> num_rows === 1) {
    $row = $result->fetch_assoc();
    foreach ($row as $key => $value) {
        $mangaInfo[$key] = $value;
    }

    $mangaInfo['studios'] = 'Sunrise';

    $formattedStartDate = strtolower(dateFormat($mangaInfo['start_date']));
    $formattedEndDate = strtolower(dateFormat($mangaInfo['end_date']));


    // Información de personajes y asociación.
    $stmt = $db->prepare("SELECT `character`.*, `character_manga`.role FROM `character`, `character_manga` WHERE `character_manga`.`manga_id` = ? AND `character`.`character_id`=`character_manga`.character_id");
    $stmt->bind_param('i', $manga_id);
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
    $stmt = $db->prepare("SELECT `staff`.*, `staff_manga`.`role` FROM `staff`, `staff_manga` WHERE `staff_manga`.`manga_id` = ? AND `staff`.`staff_id`=`staff_manga`.staff_id");
    $stmt->bind_param('i', $manga_id);
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
    $stmt = $db->prepare("SELECT `review`.* FROM `review`, `review_manga` WHERE `review_manga`.`manga_id` = ? AND `review`.review_id = `review_manga`.`review_id`");
    $stmt->bind_param('i', $manga_id);
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
    require('resources/views/manga/_mangaquery.view.php');
} else {
    header('Location: /404');
}