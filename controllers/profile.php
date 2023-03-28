<?php
include('resources/functions.php');
include('app/User.php');

if (isset($_COOKIE['session'])) {
    $Session = new User;
    if ($Session -> validateSession() === TRUE) {
        $userInfo = $Session -> getInfo($_COOKIE['username']);
        $animelist = $Session -> getList($_COOKIE['username'], 'anime');
        $mangalist = $Session -> getList($_COOKIE['username'], 'manga');
        $animes = $Session -> getAnimes($animelist);
        $animeStats = $Session -> getStats($animelist);
        $mangaStats = $Session -> getStats($mangalist);
        $animeScoreAvg = $Session -> getScoreAvg($animelist);
        $mangaScoreAvg = $Session -> getScoreAvg($mangalist);

        include('resources/views/user/profile.view.php');
    } else {
        exit(header("Location: /logout"));
    }
} else {
    exit(header("Location: /404"));
}