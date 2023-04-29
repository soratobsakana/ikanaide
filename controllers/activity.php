<?php

require_once 'resources/functions.php';
require_once 'app/Activity.php';

$Activity = new Activity;

$postId = intval($guide[2]);

if ($Activity -> exists($postId)) {
    print 'y';
} else {
    print 'n';
}