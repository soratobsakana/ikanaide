<?php

if (isset($_COOKIE['session'])) {
    if ($_COOKIE['session'] === "Yes") {
        var_dump($_COOKIE);
    }
}