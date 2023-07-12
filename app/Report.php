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

    public static function report(int $reportingUser, int $reportedUser, string $reason): bool
    {
        if (DB::query('INSERT INTO `report` VALUES (?, ?, ?, default)', [$reportingUser, $reportedUser, $reason])) {
            return true;
        } else {
            return false;
        }
    }
}