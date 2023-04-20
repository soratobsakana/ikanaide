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

    public function follow()
    {

    }

    public function unfollow()
    {
        
    }
}