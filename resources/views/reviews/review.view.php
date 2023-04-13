<?php

if (isset($reviewsHome)) {
    // /reviews
    require '_reviewHome.view.php';
} else if (isset($review)) {
    // /review/review_id
    require '_reviewEntry.view.php';
} else if (isset($newReview)) {
    // /review/new/anime|manga
    require '_reviewNew.view.php';
} else if ($uri === '/review/new') {
    header('Location: /review/new/anime');
} else if ($uri === '/review/new/anime' && $uri === '/review/new/manga') {
    require '_reviewNew.view.php';
} else {
    header('Location: /404');
}

?>