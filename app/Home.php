<?php

namespace App;

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

    /**
     * @return array|null
     * Devuelve todas las reviews de la tabla `review` en orden cronológico.
     */
    public function getReviews(): array|null
    {
        $result = $this -> con -> db -> execute_query('SELECT * FROM `review` ORDER BY `date` DESC LIMIT 4');
        if ($result -> num_rows > 0) {
            for ($i = 0; $i < $result -> num_rows; $i++) {
                $row = $result -> fetch_assoc();
                $reviewsHome[$i]['review_id'] = $row['review_id'];
                $reviewsHome[$i]['title'] = $row['title'];
                $reviewsHome[$i]['text'] = $row['text'];
                $reviewsHome[$i]['user_id'] = $row['user_id'];

                $user = $this -> con -> db -> execute_query('SELECT username, pfp FROM user WHERE user_id = ?', [$row['user_id']]);
                if ($user -> num_rows === 1) {
                    $row = $user -> fetch_assoc();
                    $reviewsHome[$i]['username'] = $row['username'];
                    $reviewsHome[$i]['pfp'] = $row['pfp'];
                }

                $entryAnime = $this -> con -> db -> execute_query('SELECT anime_id FROM review_anime WHERE review_id = ?', [$reviewsHome[$i]['review_id']]);
                $entryManga = $this -> con -> db -> execute_query('SELECT manga_id FROM review_manga WHERE review_id = ?', [$reviewsHome[$i]['review_id']]);
                if ($entryAnime -> num_rows === 1) {
                    $medium = 'anime';
                    $medium_id = $entryAnime -> fetch_column();
                } else if ($entryManga -> num_rows === 1){
                    $medium = 'manga';
                    $medium_id = $entryManga -> fetch_column();
                }

                $mediumEntry = $this -> con -> db -> execute_query('SELECT title, header FROM '.$medium.' WHERE '.$medium.'_id = ?', [$medium_id]);
                if ($mediumEntry -> num_rows === 1) {
                    $row = $mediumEntry -> fetch_assoc();
                    $reviewsHome[$i]['entry'] = $row['title'];
                    $reviewsHome[$i]['header'] = $row['header'];
                    $reviewsHome[$i]['medium'] = $medium;
                }
            }
            return $reviewsHome;
        } else {
            return null;
        }
    }
}