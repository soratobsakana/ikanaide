<?php

use App\Connection\Database;

class Test
{
    public array $animeInfo;
    public object $con;

    public function __construct()
    {
        $this -> con = new Database;
    }

    public function getInfo(string $query, array $parameters): array
    {
        $result = $this -> Database -> db -> execute_query($query, $parameters);
        if ($result -> num_rows === 1) {
            $row = $result -> fetch_assoc();

            foreach ($row as $key => $value) {
                $this -> animeInfo = $value;
            }
        }
        $this -> animeInfo = $animeInfo;
        return $this -> animeInfo;
    }
}