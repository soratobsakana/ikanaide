<?php

namespace App;

class Following
{
    public static function follow(int $followingUser, int $followedUser): bool
    {
        if (User::validateSession()) {
            if (DB::query('INSERT INTO `follow` VALUES (?, ?, default)', [$followingUser, $followedUser])) {
                return true;
            } else {
                return false;
            }
        } else {
            header('Location: /logout');
            die();
        }
    }

    public static function unfollow(int $unfollowingUser, int $unfollowedUser):bool
    {
        if (User::validateSession()) {
            if (DB::query('DELETE FROM `follow` WHERE following_user = ? AND followed_user = ?', [$unfollowingUser, $unfollowedUser])) {
                return true;
            } else {
                return false;
            }
        } else {
            header('Location: /logout');
            die();
        }
    }

    public static function isFollowing(int $loggedInUser, int $loggedOffUser): bool
    {
        if (User::validateSession()) {
            if (DB::query('SELECT * FROM `follow` WHERE `following_user` = ? AND `followed_user` = ?', [$loggedInUser, $loggedOffUser]) -> num_rows === 1) {
                return true;
            } else {
                return false;
            }
        } else {
            header('Location: /logout');
            die();
        }
    }
}