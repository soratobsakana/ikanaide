<?php

include_once 'Database.php';
include_once 'User.php';
include_once 'Listing.php';

class Home
{
    public object $con;
    private object $user;
    private object $listing;

    public function __construct()
    {
        $this -> con = new Database;
        $this -> user = new User;
        $this -> listing = new Listing;
    }

    public function getWatchingAnimes(int $userId): array|null
    {
        $animes = $this -> con -> db -> execute_query('SELECT anime_id, progress FROM animelist WHERE user_id = ? AND status = "watching"', [$userId]);
        if ($animes -> num_rows > 0) {
            for ($i=0; $i < $animes -> num_rows; $i++) { 
                $anime = $animes -> fetch_assoc();
                $watchingAnimes[$i]['anime'] = $this -> con -> db -> execute_query('SELECT anime_id, title, episodes, cover FROM anime WHERE anime_id = ?', [$anime['anime_id']]) -> fetch_assoc();
                $watchingAnimes[$i]['user_progress'] = $anime['progress'];
            }
            return $watchingAnimes;
        } else {
            return null;
        }
    }

    public function getReadingMangas(int $userId): array|null
    {
        $mangas = $this -> con -> db -> execute_query('SELECT manga_id, progress FROM mangalist WHERE user_id = ? AND status = "reading"', [$userId]);
        if ($mangas -> num_rows > 0) {
            for ($i=0; $i < $mangas -> num_rows; $i++) { 
                $manga = $mangas -> fetch_assoc();
                $readingMangas[$i]['manga'] = $this -> con -> db -> execute_query('SELECT manga_id, title, chapters, cover FROM manga WHERE manga_id = ?', [$manga['manga_id']]) -> fetch_assoc();
                $readingMangas[$i]['user_progress'] = $manga['progress'];
            }
            return $readingMangas;
        } else {
            return null;
        }
    }
}