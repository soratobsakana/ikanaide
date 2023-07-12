<?php

namespace App;

if (!User::validateSession()) {
    header('Location: /logout');
    die();
}

// $userId is declared at /routes/profileRouter.php
if (isset($userId)) {
    
    $userInfo  = User::getInfo($userId);
    $animelist = User::getList('anime', $userId);
    $mangalist = User::getList('manga', $userId);
    $statusCounter = User::getStatusCounter($userId);
    $postCount = User::getPostCount($userId);
    $followCount = User::getFollowCount($userId);
    $animeStats = User::getStats($animelist, 'anime');
    $mangaStats = User::getStats($mangalist, 'manga');
    $animeScoreAvg = User::getScoreAvg($animelist);
    $mangaScoreAvg = User::getScoreAvg($mangalist);
    $select = Activity::getSelect(); // La variable $select es asignada con los valores a mostrar en el menú HTML select del wrapper de creación de posts, en el perfil.

    //$guide is declared at /routes/profileRouter.php
    if (isset($guide[2])) {
        switch ($guide[2]) {
            case 'animelist':
            case 'mangalist':
                $animes = User::getAnimes($animelist);
                $mangas = User::getMangas($mangalist);
                break;
            case 'reviews':
                $userReviews = User::getReviews($userId);
                break;
            case 'favorites':
                $favoriteAnimes = User::getFavorites($userId, 'anime'); // This is an object that will be looped in _favoritesprofile.view.php
                $favoriteMangas = User::getFavorites($userId, 'manga'); // This is an object that will be looped in _favoritesprofile.view.php
                break;
        }
    } else { // Si pasa por este else, significa que se está mostrando la ventana de overview.
        $userPosts = User::getPosts($userId);
    }

    require view('user/profile.view.php');
} else {
    header("Location: /404");
    die();
}