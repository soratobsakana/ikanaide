<?php

namespace App;

class Review
{
    /**
     * @return array|null
     * Devuelve todas las reviews de la tabla `review` en orden cronológico.
     */
    public static function getReviews(): array|null
    {
        $result = DB::query('SELECT * FROM `review` ORDER BY `date` DESC');
        if ($result -> num_rows > 0) {
            for ($i = 0; $i < $result -> num_rows; $i++) {
                $row = $result -> fetch_assoc();
                $reviewsHome[$i]['review_id'] = $row['review_id'];
                $reviewsHome[$i]['title'] = $row['title'];
                $reviewsHome[$i]['text'] = $row['text'];
                $reviewsHome[$i]['user_id'] = $row['user_id'];

                $user = DB::query('SELECT `username`, `pfp` FROM user WHERE `user_id` = ?', [$row['user_id']]);
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

    public static function getReview(int $review_id): array|null
    {
        $result = DB::query('SELECT * FROM review WHERE review_id = ?', [$review_id]);
        if ($result -> num_rows === 1) {
            $row = $result -> fetch_assoc();
            $review['review_id'] = $row['review_id'];
            $review['title'] = $row['title'];
            $review['text'] = $row['text'];
            $review['user_id'] = $row['user_id'];
            $review['date'] = $row['date'];

            $user = DB::query('SELECT username, pfp FROM user WHERE user_id = ?', [$row['user_id']]);
            if ($user -> num_rows === 1) {
                $row = $user -> fetch_assoc();
                $review['username'] = $row['username'];
                $review['pfp'] = $row['pfp'];
            }

            $entryAnime = DB::query('SELECT anime_id FROM review_anime WHERE review_id = ?', [$review['review_id']]);
            $entryManga = DB::query('SELECT manga_id FROM review_manga WHERE review_id = ?', [$review['review_id']]);

            if ($entryAnime -> num_rows === 1) {
                $medium = 'anime';
                $medium_id = $entryAnime -> fetch_column();
            } else if ($entryManga -> num_rows === 1){
                $medium = 'manga';
                $medium_id = $entryManga -> fetch_column();
            }

            $mediumEntry = DB::query('SELECT title FROM '.$medium.' WHERE '.$medium.'_id = ?', [$medium_id]);
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

    /**
     * @param string $medium
     * @return array|null
     * Devuelve todos los títulos de las tabla `anime` o `manga` para mostrarlos en un menú select en /review/new/anime|manga.
     */
    public static function getTitles(string $medium): array|null
    {
        $result = DB::query('SELECT title FROM '.$medium.' ORDER BY title');
        if ($result -> num_rows > 0) {
            while ($row = $result -> fetch_column()) {
                $titles[] = $row;
            }
            return $titles;
        } else {
            return null;
        }
    }

    public static function createReview(string $medium, array $review)
    {
        if (User::validateSession()) {
            if (isset($review['title']) || isset($review['reviewTitle']) || isset($review['reviewContent'])) {
                DB::query('INSERT INTO review VALUES (null, ?, ?, ?, default)', [$review['reviewTitle'], $review['reviewContent'], $_COOKIE['user_id']]);
                $review_id = DB::insertedId();
                $medium_id = Listing::exists($medium, $review['title']);

                if (is_int($medium_id)) {
                    if (DB::query('INSERT INTO review_'.$medium.' VALUES (?, ?)', [$review_id, $medium_id])) {
                        header('Location: /review/'.$review_id);
                        die();
                    }
                }
            }
        } else {
            return null;
        }
    }

    public static function likeReview(int $reviewId, string $action, int $userId): bool
    {
        switch ($action) {
            case 'up':
                if (DB::query('INSERT INTO `review_vote` VALUES(?, ?, true, default) ON DUPLICATE KEY UPDATE `vote` = true', [$userId, $reviewId])) {
                    return true;
                } else {
                    return false;
                }
            case 'down';
                if (DB::query('INSERT INTO `review_vote` VALUES(?, ?, false, default) ON DUPLICATE KEY UPDATE `vote` = false', [$userId, $reviewId])) {
                    return true;
                } else {
                    return false;
                }
            default:
                return false;
        }
    }

    public static function getReviewVotes(int $reviewId): array|null
    {
        $reviewVotes['upvotes'] = DB::query('SELECT count(review_id) FROM `review_vote` WHERE `vote` = true AND `review_id` = ?', [$reviewId]) -> fetch_column();
        $reviewVotes['downvotes'] = DB::query('SELECT count(review_id) FROM `review_vote` WHERE `vote` = false AND `review_id` = ?', [$reviewId]) -> fetch_column();
        $reviewVotes['difference'] = $reviewVotes['upvotes'] - $reviewVotes['downvotes'];
        
        return $reviewVotes;
    }

    /**
     * @param int $reviewId
     * @param int $userId
     * @return bool|null
     * Utilizo los valores true y false en caso de que exista un voto de un usuario para X review. Me sirve para mostrar el icono correcto de voto en _reviewEntry.view.php.
     * El valor null lo añado en caso de que no exista un voto, y me sirve para lo mismo.
     */
    public static function userVote(int $reviewId, int $userId): bool|null
    {
        $result = DB::query('SELECT vote FROM `review_vote` WHERE `review_id` = ? AND `user_id` = ?', [$reviewId, $userId]);
        if ($result -> num_rows === 1) {
            $vote = $result -> fetch_column();
            if ($vote === 1) {
                return true;
            } else if ($vote === 0) {
                return false;
            }
        } else {
            return null;
        }
    }
}