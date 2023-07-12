<?php

namespace App;

class Bookmark
{
    public object $con;
    private object $user;
    private object $listing;

    public function __construct()
    {
        $this -> con = new Database;
        $this -> user = new User;
        $this -> listing = new Listing;
    }

    public function bookmark(int $userId, int $postId): bool
    {
        if (DB::query('SELECT * FROM `bookmark` WHERE post_id = ? AND user_id = ?', [$userId, $postId]) -> num_rows === 0) {
            if (DB::query('INSERT INTO `bookmark` VALUES (?, ?, default)', [$userId, $postId])) {
                return true;
            } else {
                return false;
            }
        } else if (DB::query('DELETE FROM `bookmark` WHERE post_id = ? AND user_id = ?', [$userId, $postId])) {
            return true;
        } else {
            return false;
        }
        
    }
}