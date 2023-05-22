<?php

require_once 'app/User.php';
require_once 'app/Ranking.php';
$User = new User;
$Ranking = new Ranking;

if (isset($_GET['medium'], $_GET['id'], $_GET['action'])) {
    if ($_GET['medium'] === 'anime' || $_GET['medium'] === 'manga') {
        if (filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            if ($User -> validateSession()) {
                $medium = $_GET['medium'];
                $medium_id = intval($_GET['id']);
                $userId = $_COOKIE['user_id'];
                
                switch ($_GET['action']) {
                    case "add":
                        if ($Ranking -> add($medium, $medium_id, $userId)) {
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                            die();
                        }
                        break;
                    case "delete":
                        if ($Ranking -> delete($medium, $medium_id, $userId)) {
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                            die();
                        }
                        break;
                    case "fav":
                        if ($Ranking -> favorite($medium, $medium_id, $userId)) {
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                            die();
                        }
                        break;
                    case "unfav":
                        if ($Ranking -> unfavorite($medium, $medium_id, $userId)) {
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                            die();
                        }
                        break;
                    default:
                        header('Location: /404');
                        die();
                }
                
            }
        }
    }
}