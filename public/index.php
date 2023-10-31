<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php

    const BASE_PATH = __DIR__ . '/../';
    const DIR = __DIR__ . '/';

    require BASE_PATH . 'app/helpers.php';
    require path('routes/titles.php');

    ?>

<title><?=$tabTitle?> / ikanaide</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <meta name="twitter:site" content="@ikanaidecom">
    <meta property="og:url" content="https://ikanaide.com">
    <meta property="og:title" content="Ikanaide">
    <meta property="og:description" content="Create anime and manga lists, interact with the database and post your reactions and opinions">

    <link type="image/png" sizes="32x32" rel="icon" href="/storage/sys/favico2.png">
    <link rel="stylesheet" href="/app.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

</head>
<body>
<script>0</script> <!-- Sin aplicar esto, el css no carga a tiempo en algunos navegadores. -->
<div class="container">
    <?php

    spl_autoload_register(function ($class) {
        $file = path(str_replace('\\', DIRECTORY_SEPARATOR, lcfirst($class)) . '.php');
        if (file_exists($file)) {
            require $file;
        } else {
            exit($file);
        }
    });

    ?>

    <!-- Este wrapper sirve para colocar el header y  cuerpo en la parte superior de la web y el footer en la inferior, mediante la propiedad flex 'space-between' en div.container -->
    <div class="wrapper">
        <?php require '../resources/views/header.view.php' ?>

        <!-- For production
        <div class="top-info">
            <p>This website is currently in the making and far from completed. It's online for portfolio reasons or reference.</p>
        </div>
        -->

        <main>

            <?php require '../routes/web.php' ?>
        </main>

    </div>
    <?php require "../resources/views/footer.view.php" ?>

</div>

</body>
</html>

<?php ob_end_flush(); ?>