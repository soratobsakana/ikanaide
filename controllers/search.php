<?php

namespace App;

if (isset($_GET['medium'], $_GET['id']) && ($_GET['medium'] === 'anime' || $_GET['medium'] === 'manga') && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $postResults = Search::getPostResults($_GET['medium'], $_GET['id']);
}

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    if (!empty($keyword)) {
        $searchResults = Search::getKeywordResults($keyword);
    }
}

require view('search/search.view.php');