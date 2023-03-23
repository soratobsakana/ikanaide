<?php

include 'Database.php';

class Listing
{
    private object $con;
    public array $queryInfo;

    public function __construct()
    {
        $this -> con = new Database;
    }

    // Devuelve todos los valores de la fila de una tabla indicada por parámetro.
    public function getInfo(string $table, string $column, array $params): array|null
    {
        $result = $this -> con -> db -> execute_query("SELECT * FROM `$table` WHERE `$column` = ?", $params);
        if ($result -> num_rows === 1) {
            $row = $result->fetch_assoc();
            foreach ($row as $key => $value) {
                $queryInfo[$key] = $value;
            }
            return $queryInfo;
        } else {
            return $queryInfo = null;
        }
        
        $this -> con -> db -> close();
    }

    // Devuelve la información sobre los personajes asociados a una entrada de la base de datos.
    public function getChars(string $table, array $params): array|null
    {
        $characters = [];
        
        $result = $this -> con -> db -> execute_query("SELECT `character`.*, `character_anime`.`role` FROM `character`, `character_anime`
        WHERE `character_anime`.`anime_id` = ?
        AND `character`.`character_id`=`character_anime`.character_id", $params);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $characterInfo[$key] = $value;
                }
                // Este array guarda guarda un array asociativo por cada personaje encontrado en la base de datos.
                $characters[] = $characterInfo;
            }
            return $characters;
        } else {
            return $characters = null;
        }
        
        $this -> con -> db -> close();
    }

    // Devuelve la información sobre los miembros de staff asociados a una entrada de la base de datos.
    public function getStaff(string $table, array $params): array|null
    {
        
        $staff = [];

        $result = $this -> con -> db -> execute_query("SELECT `staff`.*, `staff_anime`.`role` FROM `staff`, `staff_anime`
        WHERE `staff_anime`.`anime_id` = ?
        AND `staff`.`staff_id`=`staff_anime`.staff_id", $params);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $staffInfo[$key] = $value;
                }
                $staff[] = $staffInfo;
            }
            return $staff;
        } else {
            return $staff = null;
        }

        $this -> con -> db -> close();
    }

    // Devuelve la información sobre las reviews asociadas a una entrada de la base de datos.
    public function getReviews(string $table, array $params): array|null
    {
        $reviews = [];

        $result = $this -> con -> db -> execute_query("SELECT `review`.* FROM `review`, `review_anime`
        WHERE `review_anime`.`anime_id` = ?
        AND `review`.review_id = `review_anime`.`review_id`", $params);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $reviewInfo[$key] = $value;
                }
                $reviews[] = $reviewInfo;
            }
            return $reviews;
        } else {
            return $reviews = null;
        }

        $this -> con -> db -> close();
    }

    // 
    public function getHome($medium): object
    {
        $mediumHomeInfo = [];
        $query = 'SELECT ' . $medium . '_id, title, cover FROM ' . $medium;
        $result = $this -> con -> db -> execute_query($query);
        
        return $result;

        $this -> con -> db -> close();
    }
}