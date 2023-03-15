<form action="app/controllers/submit.php" method="POST" class="submit-form">
    <div class="submit-form_title">Edit or add information to the database. A moderator will review it and inform you about any possible changes. Thanks for the effort!</div>

<?php

include('resources/functions.php');
require('database/conn.php');

// Propósito: mostrar un formulario adecuado para cada medio.
// Esto está pensado para cuando el usuario pretende editar una entrada de la base de datos clickando en el link de 'Edit this page' de las paginas de query.
if ($_GET) {
    $medium = substr(parse_url($_SERVER['REQUEST_URI'])['query'], 0, 3);

    switch ($medium) {
        case 'aid':
            $anime_id = $_GET['aid'] ?? null;

            if (isset($anime_id)) {
                $stmt = $db->prepare("SELECT * FROM anime WHERE anime_id = ?");
                $stmt->bind_param('i', $anime_id);
                $stmt->execute();
                // get_result() no funciona con $stmt porque pertenece a la clase mysqli_result y no a mysqli_stmt.
                $result = $stmt->get_result();

                // Propósito: crear un array asociativo con la información de la fila escogida desde la tabla `anime`. Cada par del array tendrá este formato: ['nombre_columna'] => 'valor_columna'.
                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
                    foreach ($row as $key => $value) {
                        $animeInfo[$key] = $value;
                    }

                    $animeInfo['studios'] = 'Sunrise';
                }
            }

            foreach ($animeInfo as $key => $value) {
                if (!($key === 'members' || $key === 'favorited' || $key === 'anime_id')) {
                    $animeForm[$key] = $value;
                }
            }

            require('_submit_anime.view.php');
            break;
        case 'mid':
            $manga_id = $_GET['id'] ?? null;
            print "manga";
            break;
        case 'vid':
            $vn_id = $_GET['id'] ?? null;
            print "vn";
            break;
    }
} else {
    print 'XD';
}




?>

    <input class="box" type="submit" value="Submit the entry" name="submit">
</form>
