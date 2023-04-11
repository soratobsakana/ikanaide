<?php

include_once 'Database.php';
include_once 'Listing.php';

class Review
{
    private object $con;
    private object $listing;

    public function __construct()
    {
        $this -> con = new Database;
        $this -> listing = new Listing;
    }

    /**
     * @return array|null
     * Devuelve todas las reviews de la tabla `review` en orden cronológico.
     */
    public function getReviews(): array|null
    {
        $result = $this -> con -> db -> execute_query('SELECT * FROM `review` ORDER BY `date` DESC');
        if ($result -> num_rows > 0) {
            for ($i = 0; $i < $result -> num_rows; $i++) {
                $row = $result -> fetch_assoc();
                $reviewsHome[$i]['review_id'] = $row['review_id'];
                $reviewsHome[$i]['title'] = $row['title'];
                $reviewsHome[$i]['text'] = $row['text'];
                $reviewsHome[$i]['user_id'] = $row['user_id'];
                $reviewsHome[$i]['date'] = $row['date'];

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

                $mediumEntry = $this -> con -> db -> execute_query('SELECT title FROM '.$medium.' WHERE '.$medium.'_id = ?', [$medium_id]);
                if ($mediumEntry -> num_rows === 1) {
                    $row = $mediumEntry -> fetch_assoc();
                    $reviewsHome[$i]['entry'] = $row['title'];
                    $reviewsHome[$i]['medium'] = $medium;
                }
                
            }
            return $reviewsHome;
        } else {
            return null;
        }
    }

    public function getReview(int $review_id): array|null
    {
        $result = $this -> con -> db -> execute_query('SELECT * FROM review WHERE review_id = ?', [$review_id]);
        if ($result -> num_rows === 1) {
            $row = $result -> fetch_assoc();
            $review['review_id'] = $row['review_id'];
            $review['title'] = $row['title'];
            $review['text'] = $row['text'];
            $review['user_id'] = $row['user_id'];
            $review['date'] = $row['date'];

            $user = $this -> con -> db -> execute_query('SELECT username, pfp FROM user WHERE user_id = ?', [$row['user_id']]);
            if ($user -> num_rows === 1) {
                $row = $user -> fetch_assoc();
                $review['username'] = $row['username'];
                $review['pfp'] = $row['pfp'];
            }

            $entryAnime = $this -> con -> db -> execute_query('SELECT anime_id FROM review_anime WHERE review_id = ?', [$review['review_id']]);
            $entryManga = $this -> con -> db -> execute_query('SELECT manga_id FROM review_manga WHERE review_id = ?', [$review['review_id']]);

            if ($entryAnime -> num_rows === 1) {
                $medium = 'anime';
                $medium_id = $entryAnime -> fetch_column();
            } else if ($entryManga -> num_rows === 1){
                $medium = 'manga';
                $medium_id = $entryManga -> fetch_column();
            }

            $mediumEntry = $this -> con -> db -> execute_query('SELECT title FROM '.$medium.' WHERE '.$medium.'_id = ?', [$medium_id]);
            if ($mediumEntry -> num_rows === 1) {
                $row = $mediumEntry -> fetch_assoc();
                $review['entry'] = $row['title'];
                $review['medium'] = $medium;
            }
            return $review;
        } else {
            return null;
        }
    }
}