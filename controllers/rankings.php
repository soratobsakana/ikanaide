<?php

require_once 'app/Ranking.php';

if ($page === '/rankings') {
    header('Location: /rankings/anime');
}

$medium = explode('/', $uri)[2]; // anime|manga
$Ranking = new Ranking;

$animes = $Ranking -> getRankings($medium);

require 'resources/views/rankings/rankings.view.php';