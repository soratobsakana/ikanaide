<?php

include 'Database.php';
include 'User.php';

class Activity
{
    private object $con;
    private object $user;

    public function __construct()
    {
        $this -> con = new Database;
        $this -> user = new User;
    }

    public function post(array $post): bool
    {
        if (isset($post['content']) && isset($post['user_id'])) {
            if ($this -> user -> validateSession()) {
                if ($this -> con -> db -> execute_query('INSERT INTO `post` VALUES (null, ?, ?, default)', [$post['user_id'], $post['content']])) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}