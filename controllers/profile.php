<?php
include_once('resources/functions.php');
include_once('app/User.php');
include_once('app/Activity.php');
include_once('app/Following.php');
$Session = new User;
$Activity = new Activity;
$Following = new Following;

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
    $postCount = $Session -> getPostCount($user_id);
    $followCount = $Session -> getFollowCount($user_id);
    $animeStats = $Session -> getStats($animelist, 'anime');
    $mangaStats = $Session -> getStats($mangalist, 'manga');
    $animeScoreAvg = $Session -> getScoreAvg($animelist);
    $mangaScoreAvg = $Session -> getScoreAvg($mangalist);
    $select = $Activity -> getSelect(); // La variable $select es asignada con los valores a mostrar en el menú HTML select del wrapper de creación de posts, en el perfil.

    if (isset($guide[2])) {
        switch ($guide[2]) {
            case 'animelist':
            case 'mangalist':
                $animes = $Session -> getAnimes($animelist);
                $mangas = $Session -> getMangas($mangalist);
                break;
            case 'reviews':
                $userReviews = $Session -> getReviews($user_id);
                break;
            case 'favorites':
                $favoriteAnimes = $Session -> getFavorites($user_id, 'anime'); // This is an object that will be looped in _favoritesprofile.view.php
                $favoriteMangas = $Session -> getFavorites($user_id, 'manga'); // This is an object that will be looped in _favoritesprofile.view.php
                break;
        }
    } else { // Si pasa por este else, significa que se está mostrando la ventana de overview.
        $userPosts = $Session -> getPosts($user_id);
    }

    require 'resources/views/user/profile.view.php';
} else {
    exit(header("Location: /404"));
}