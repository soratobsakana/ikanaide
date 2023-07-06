<?php

require_once '../app/Ranking.php';
require_once '../app/User.php';

$User = new User;
$Ranking = new Ranking;

if ($page === '/rankings') {
    header('Location: /rankings/anime');
    die();
}

$medium = explode('/', $uri)[2]; // anime|manga

$ranking = $Ranking -> getRankings($medium);

require '../resources/views/rankings/rankings.view.php';