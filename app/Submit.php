<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'Database.php';

class Submit
{
    public object $con;

    public function __construct()
    {
        $this -> con = new Database;
    }
}