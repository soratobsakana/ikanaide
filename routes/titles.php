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

// Este switch lo utilizo para títulos de más de una palabra o que necesitan un valor dinámico
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