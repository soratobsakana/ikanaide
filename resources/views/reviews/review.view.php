<?php

if (isset($reviewsHome)) {
    require '_reviewHome.view.php';
} else if (isset($review)) {
    require '_reviewEntry.view.php';
} else if (isset($newReview)) {
    require '_reviewNew.view.php';
} else {
    header('Location: /404');
}

?>