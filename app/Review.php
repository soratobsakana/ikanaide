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
            }
            return $reviewsHome;
        } else {
            return null;
        }
    }
}