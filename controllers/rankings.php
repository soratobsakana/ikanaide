<?php

namespace App;

$medium = explode('/', $uri)[2]; // anime|manga

$ranking = Ranking::getRankings($medium);

require view('rankings/rankings.view.php');