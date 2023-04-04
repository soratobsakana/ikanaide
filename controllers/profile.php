<?php
include_once('resources/functions.php');
include_once('app/User.php');
$Session = new User;

if (isset($_COOKIE['session'])) {
    if ($Session -> validateSession() !== TRUE) {
        exit(header("Location: /logout"));
    }
}

// $user_id viene de /routes/profileRouter.php
if ($user_id !== null) {
    $userInfo  = $Session -> getInfo($user_id);
    $animelist = $Session -> getList('anime', $user_id);
    if (count($animelist) > 0) {
        for ($i=0; $i<count($animelist);$i++) {
            foreach ($animelist[$i] as $key => $value) {
                if ($key === 'status') {
                    switch($value) {
                        case 'watching':
                            $watching = $animelist[$i];
                            break;
                        case 'completed':
                            $completed = $animelist[$i];
                            break;
                        case 'planned':
                            $planned = $animelist[$i];
                            break;
                        case 'stalled':
                            $stalled = $animelist[$i];
                            break;
                        case 'dropped':
                            $dropped = $animelist[$i];
                            break;
                    }
                }
            }
        }
    }

    $mangalist = $Session -> getList('manga', $user_id);
    $animes = $Session -> getAnimes($animelist);
    $mangas = $Session -> getMangas($mangalist);
    $animeStats = $Session -> getStats($animelist, 'anime');
    $mangaStats = $Session -> getStats($mangalist, 'manga');
    $animeScoreAvg = $Session -> getScoreAvg($animelist);
    $mangaScoreAvg = $Session -> getScoreAvg($mangalist);
    $favoriteAnimes = $Session -> getFavorites($user_id, 'anime'); // This is an object that will be looped in _favoritesprofile.view.php
    $favoriteMangas = $Session -> getFavorites($user_id, 'manga'); // This is an object that will be looped in _favoritesprofile.view.php

    require 'resources/views/user/profile.view.php';
} else {
    exit(header("Location: /404"));
}