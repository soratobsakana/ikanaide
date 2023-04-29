<?php
include_once('resources/functions.php');
include_once('app/User.php');
include_once('app/Activity.php');
$Session = new User;
$Activity = new Activity;

if (isset($_COOKIE['session'])) {
    if ($Session -> validateSession() !== TRUE) {
        exit(header("Location: /logout"));
    }
}

// $user_id viene de /routes/profileRouter.php
if ($user_id !== null) {
    $userInfo  = $Session -> getInfo($user_id);
    $animelist = $Session -> getList('anime', $user_id);
    $mangalist = $Session -> getList('manga', $user_id);
    $animes = $Session -> getAnimes($animelist);
    $mangas = $Session -> getMangas($mangalist);
    $animeStats = $Session -> getStats($animelist, 'anime');
    $mangaStats = $Session -> getStats($mangalist, 'manga');
    $animeScoreAvg = $Session -> getScoreAvg($animelist);
    $mangaScoreAvg = $Session -> getScoreAvg($mangalist);
    $favoriteAnimes = $Session -> getFavorites($user_id, 'anime'); // This is an object that will be looped in _favoritesprofile.view.php
    $favoriteMangas = $Session -> getFavorites($user_id, 'manga'); // This is an object that will be looped in _favoritesprofile.view.php
    $userReviews = $Session -> getReviews($user_id);
    $userPosts = $Session -> getPosts($user_id);
    $select = $Activity -> getSelect(); // La variable $select es asignada con los valores a mostrar en el menú HTML select del wrapper de creación de posts, en el perfil.

    require 'resources/views/user/profile.view.php';
} else {
    exit(header("Location: /404"));
}