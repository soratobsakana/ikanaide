<?php

include 'Database.php';

class Listing
{
    public object $con;

    // Devuelve todos los valores de la fila de una tabla indicada por parámetro.
    public function selectAll(string $table, string $column, array $params): array
    {
        $con = new Database;
        $result =  $con -> db -> execute_query("SELECT * FROM `$table` WHERE `$column` = ?", $params);
        if ($result -> num_rows === 1) {
            $row = $result->fetch_assoc();
            foreach ($row as $key => $value) {
                $queryInfo[$key] = $value;
            }
        } else {
            $queryInfo = array();
        }

        return $queryInfo;
        
    $con -> db -> close();
    }
}