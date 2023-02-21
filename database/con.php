<?php

$mysqli = new mysqli('localhost', 'root', '', 'ikanaide');

if ($mysqli -> connect_errno) {
    echo 'Failed to connect to the database';
}