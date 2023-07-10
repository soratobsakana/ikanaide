<?php

namespace App;

class Report
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

    public function report(int $reportingUser, int $reportedUser, string $reason): bool
    {
        if ($this -> con -> db -> execute_query('INSERT INTO `report` VALUES (?, ?, ?, default)', [$reportingUser, $reportedUser, $reason])) {
            return true;
        } else {
            return false;
        }
    }
}