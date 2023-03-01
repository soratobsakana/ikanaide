<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home / Ikanaide</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="app.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="main">
            <?php
                include "app/header/index.php";
            ?>
            <section class="ikanaide-body">
                <?php
                    include "app/body/anime.php";
                ?>
            </section>
        </div>
        <?php
            include "app/footer/index.php";
        ?>
    </div>
</body>
</html>