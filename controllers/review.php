<?php

include_once 'app/Review.php';
include_once 'app/Listing.php';

$reviewGuide = explode('/', $uri);

$Review = new Review;
$Listing = new Listing;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Inspección de que los nombres de campo del formulario HTML no han sido modificados en las herramientas de navegador.
    $fields = ['title', 'reviewTitle', 'reviewContent', 'submit'];
    foreach ($_POST as $key => $value) {
        if (!in_array($key, $fields)) {
            header('Location: /404');
        } else {
            if (!($key === 'submit')) {
                if (!empty($value)) {
                    switch ($key) {
                        case 'title':
                            if ($Listing -> exists('anime', str_replace('-', ' ', $value))) {
                                $newReview[$key] = $value;
                            }
                            break;
                        case 'reviewTitle':
                            if (strlen($value) <= 0 || strlen($value) > 50) {
                                $errorMessage = 'Title cannot be longer than 50 characters';
                            } else {
                                $newReview[$key] = $value;
                            }
                            break;
                        case 'reviewContent':
                            $newReview[$key] = $value;
                            break;
                    }
                } else {
                    $newReview = null;
                    header('Location: /404');
                }
            }
        }
    }
    pre($newReview);
} else {
    if ($reviewGuide[1] === 'reviews') {
        $reviewsHome = $Review -> getReviews();
    } else if (($reviewGuide[1] === 'review' && is_numeric($reviewGuide[2])) && !isset($reviewGuide[3])) {
        $review_id = $reviewGuide[2];
        $review = $Review -> getReview($review_id);
    } else if (($reviewGuide[1] === 'review' && $reviewGuide[2] === 'new') && (isset($reviewGuide[3]) && !isset($reviewGuide[4]))) {
        if ($reviewGuide[3] === 'anime' || $reviewGuide[3] === 'manga') {
            $titles = $Review -> getTitles($reviewGuide[3]);
        }
    } else if (($reviewGuide[1] === 'review' && $reviewGuide[2] === 'new') && (isset($reviewGuide[3]) && isset($reviewGuide[4]))) {
        if ($reviewGuide[3] === 'anime' || $reviewGuide[3] === 'manga') {
            if ($Listing -> exists($reviewGuide[3], str_replace('-', ' ', $reviewGuide[4]))) {
                $entryToReview = str_replace('-', ' ', $reviewGuide[4]);
            } else {
                header('Location: /404');
            }
        }
    }

    if (isset($reviewsHome) || isset($review) || isset($titles) || isset($entryToReview)) {
        require('resources/views/reviews/review.view.php');
    } else {
        header('Location: /404');
    }
}