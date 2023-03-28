<?php
include_once('resources/functions.php');
include_once('app/User.php');
$Session = new User;

// $uri viene de routes/web.php
// Las URI de perfiles de usuario es: /nombre_de_usuario, por lo que saco $username de esta manera:
$username = explode("/", $uri)[1];

$user_id = $Session -> getUserID($username);
if ($user_id !== null) {
    $userInfo = $Session -> getInfo($user_id);
    $animelist = $Session -> getList('anime', $user_id);
    $mangalist = $Session -> getList('manga', $user_id);
    $animes = $Session -> getAnimes($animelist);
    $animeStats = $Session -> getStats($animelist);
    $mangaStats = $Session -> getStats($mangalist);
    $animeScoreAvg = $Session -> getScoreAvg($animelist);
    $mangaScoreAvg = $Session -> getScoreAvg($mangalist);

    require 'resources/views/user/profile.view.php';
} else {
    exit(header("Location: /404"));
}
    
if (isset($_COOKIE['session'])) {
    
    if ($Session -> validateSession() === TRUE) {
        
    } else {
        exit(header("Location: /logout"));
    }
}