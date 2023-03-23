<?php

include 'Database.php';

class User
{

    private $con;

    public function __construct()
    {
        $this -> con = new Database;
    }

    public function register()
    {
        $result = $this -> con -> db -> execute_query('SELECT * FROM anime');
        $row = $result -> fetch_assoc();
        return $row;
        
    }

    public function login()
    {
        
    }

    public function authenticate()
    {
        
    }
}