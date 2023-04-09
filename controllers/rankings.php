<?php

if ($page === '/rankings') {
    header('Location: /rankings/anime');
}

require 'resources/views/rankings/rankings.view.php';