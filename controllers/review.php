<?php

include_once 'app/Review.php';

$reviewGuide = explode('/', $uri);
$Review = new Review;

if (!isset($reviewGuide[2])) {
    // URI should be /reviews in here.
    $reviewsHome = $Review -> getReviews();
    require('resources/views/reviews/review.view.php');
}