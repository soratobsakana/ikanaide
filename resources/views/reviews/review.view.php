<?php

if (isset($reviewsHome)) {
    require '_reviewHome.view.php';
} else if (isset($review)) {
    require '_reviewEntry.view.php';
} else if (isset($titles) || isset($entryToReview)) {
    require '_reviewNew.view.php';
} else {
    header('Location: /404');
}