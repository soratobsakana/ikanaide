<?php

namespace App;

class Home
{
    public static function getWatchingAnimes(int $userId): array|null
    {
        $animes = DB::query('SELECT anime_id, progress FROM animelist WHERE user_id = ? AND status = "watching"', [$userId]);
        if ($animes -> num_rows > 0) {
            for ($i=0; $i < $animes -> num_rows; $i++) { 
                $anime = $animes -> fetch_assoc();
                $watchingAnimes[$i]['anime'] = DB::query('SELECT anime_id, title, episodes, cover FROM anime WHERE anime_id = ?', [$anime['anime_id']]) -> fetch_assoc();
                $watchingAnimes[$i]['user_progress'] = $anime['progress'];
            }
            return $watchingAnimes;
        } else {
            return null;
        }
    }

    public static function getReadingMangas(int $userId): array|null
    {
        $mangas = DB::query('SELECT manga_id, progress FROM mangalist WHERE user_id = ? AND status = "reading"', [$userId]);
        if ($mangas -> num_rows > 0) {
            for ($i=0; $i < $mangas -> num_rows; $i++) { 
                $manga = $mangas -> fetch_assoc();
                $readingMangas[$i]['manga'] = DB::query('SELECT manga_id, title, chapters, cover FROM manga WHERE manga_id = ?', [$manga['manga_id']]) -> fetch_assoc();
                $readingMangas[$i]['user_progress'] = $manga['progress'];
            }
            return $readingMangas;
        } else {
            return null;
        }
    }

    /**
     * @return array|null
     * Returns newest four review entries.
     */
    public static function getReviews(): array|null
    {
        $result = DB::query('SELECT * FROM `review` ORDER BY `date` DESC LIMIT 6');
        if ($result -> num_rows > 0) {
            for ($i = 0; $i < $result -> num_rows; $i++) {
                $row = $result -> fetch_assoc();
                $reviewsHome[$i]['review_id'] = $row['review_id'];
                $reviewsHome[$i]['title'] = $row['title'];
                $reviewsHome[$i]['text'] = $row['text'];
                $reviewsHome[$i]['user_id'] = $row['user_id'];

                $user = DB::query('SELECT username, pfp FROM user WHERE user_id = ?', [$row['user_id']]);
                if ($user -> num_rows === 1) {
                    $row = $user -> fetch_assoc();
                    $reviewsHome[$i]['username'] = $row['username'];
                    $reviewsHome[$i]['pfp'] = $row['pfp'];
                }

                $entryAnime = DB::query('SELECT anime_id FROM review_anime WHERE review_id = ?', [$reviewsHome[$i]['review_id']]);
                if ($entryAnime -> num_rows === 1) {
                    $medium = 'anime';
                    $medium_id = $entryAnime -> fetch_column();
                } else {
                    $entryManga = DB::query('SELECT manga_id FROM review_manga WHERE review_id = ?', [$reviewsHome[$i]['review_id']]);
                    if ($entryManga -> num_rows === 1){
                        $medium = 'manga';
                        $medium_id = $entryManga -> fetch_column();
                    }
                }

                $mediumEntry = DB::query('SELECT title, header FROM '.$medium.' WHERE '.$medium.'_id = ?', [$medium_id]);
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