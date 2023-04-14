<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $page = parse_url($_SERVER['REQUEST_URI'])['path'];
    $username = explode("/", $page)[1];

    // Si el primer elemento del URI es 'anime' o 'manga' y existe un segundo elemento (que correspondría a la entrada listada), se recoge el título para ponerlo en el <title></title>
    $guide = explode("/", $page);
    if (($username === 'anime' || $username === 'manga') && isset($guide[2])) {
        $entryURI = explode("/", $page)[2];
        $entryTitle = str_replace('-', ' ', $entryURI);
    } else {
        $entryURI = '';
    }

    // For the root path and URI's that have more than one word.
    switch ($page) {
        case '/':
            $tabTitle = '/home';
            break;
        case '/submit/anime':
            $tabTitle = 'submit a new anime';
            break;
        case '/submit/manga':
            $tabTitle = 'submit a new manga';
            break;
        case '/submit/vn':
            $tabTitle = 'submit a new visual novel';
            break;
        case '/submit/character':
            $tabTitle = 'submit a new character';
            break;
        case '/submit/staff':
            $tabTitle = 'submit a new staff';
            break;
        case '/'.$username.'/animelist':
            $tabTitle = $username . '\'s animelist';
            break;
        case '/'.$username.'/mangalist':
            $tabTitle = $username . '\'s mangalist';
            break;
        case '/'.$username.'/reviews':
            $tabTitle = $username . '\'s reviews';
            break;
            case '/'.$username.'/favorites':
            $tabTitle = $username . '\'s favorites';
            break;
        case '/anime/' . $entryURI:
        case '/manga/' . $entryURI:
            $tabTitle = $entryTitle;
            break;
        case '/review/new/anime':
            $tabTitle = 'new anime review';
            break;
        case '/review/new/manga':
            $tabTitle = 'new manga review';
            break;
        default:
            $tabTitle = $username;
    }
    ?>
    <title><?=$tabTitle?> / ikanaide</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/app.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
</head>
<body>
<script>0</script>
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