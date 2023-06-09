<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php

    if ($_SERVER['REQUEST_URI'] === '/') {
        header('Location: /home');
    }

    // Defino el directorio raíz de la página web para usarlo en cualquier archivo
    const DIR = __DIR__;
    require_once 'routes/titles.php';

    ?>
    <title><?=$tabTitle?> / ikanaide</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/app.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

</head>
<body>
<script>0</script> <!-- Sin aplicar esto, el css no carga a tiempo en algunos navegadores. -->
<div class="container">
    <!-- Este wrapper sirve para colocar el header y  cuerpo en la parte superior de la web y el footer en la inferior, mediante la propiedad flex 'space-between' en div.container -->
    <div class="wrapper">
        <?php require 'resources/views/header.view.php' ?>

        <main>
            <?php require 'routes/web.php' ?>
        </main>

    </div>
        <?php require "resources/views/footer.view.php" ?>
</div>

</body>
</html>

<?php ob_end_flush(); ?>