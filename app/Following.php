<?php

include_once 'Database.php';
include_once 'Listing.php';

class Following
{
    private object $con;
    private object $listing;
    private object $user;

    public function __construct()
    {
        $this -> con = new Database;
        $this -> listing = new Listing;
        $this -> user = new User;
    }

    public function follow(int $followingUser, int $followedUser): bool
    {
        if ($this -> user -> validateSession()) {
            if ($this -> con -> db -> execute_query('INSERT INTO `follow` VALUES (?, ?, default)', [$followingUser, $followedUser])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function unfollow(int $unfollowingUser, int $unfollowedUser):bool
    {
        if ($this -> user -> validateSession()) {
            if ($this -> con -> db -> execute_query('DELETE FROM `follow` WHERE following_user = ? AND followed_user = ?', [$unfollowingUser, $unfollowedUser])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function isFollowing(int $loggedInUser, int $loggedOffUser): bool
    {
        if ($this -> user -> validateSession()) {
            if ($this -> con -> db -> execute_query('SELECT * FROM `follow` WHERE `following_user` = ? AND `followed_user` = ?', [$loggedInUser, $loggedOffUser]) -> num_rows === 1) {
                return true;
            } else {
                return false;
            }
        }
    }
}