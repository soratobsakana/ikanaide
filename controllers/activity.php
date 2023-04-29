<?php

require_once 'resources/functions.php';
require_once 'app/Activity.php';

$Activity = new Activity;

// $guide y $postId han sido declaradas en el archivo /routes/web.php

if ($Activity -> exists($postId)) {
    $post = $Activity -> getPost($postId);

    require 'resources/views/activity/activity.view.php';
} else {
    header('Location: /404');
}