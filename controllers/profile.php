<?php

if (isset($_COOKIE['session'])) {
    if ($_COOKIE['session'] === "Yes") {
        $username = $_COOKIE['username'] ?? null;
        $user_id = $_COOKIE['user_id'] ?? null;
    }
}