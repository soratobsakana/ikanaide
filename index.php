<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $page = parse_url($_SERVER['REQUEST_URI'])['path'];
    // For the root path and URI's that have more than one word.
    switch ($page) {
        case '/':
            $page = '/home';
            break;
        case '/submit/anime':
            $page = '/submit a new anime';
            break;
        case '/submit/manga':
            $page = '/submit a new manga';
            break;
        case '/submit/vn':
            $page = '/submit a new visual novel';
            break;
        case '/submit/character':
            $page = '/submit a new character';
            break;
        case '/submit/staff':
            $page = '/submit a new staff';
            break;
    }
    ?>
    <title><?=ucfirst(substr($page, 1))?> / Ikanaide</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/app.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
</head>
<body>
<script>0</script>
<?php
    include 'database/conn.php';
    include 'resources/functions.php';
    include 'app/Test.php';
    $query = 'SELECT * FROM anime WHERE anime_id = ?';
    $parameters = [1];
    $database = new Test;
    $animeInfo = $database -> animeInfo;
    var_dump($database);
    $database -> getInfo($query, $parameters);
    pre($animeInfo);
?>
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