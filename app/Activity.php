<?php

include 'Database.php';

class Activity
{
    private object $con;

    public function __construct()
    {
        $this -> con = new Database;
    }
}