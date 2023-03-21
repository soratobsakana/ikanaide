<?php

class Database {
    public object $db;

    public function __construct()
    {
        // Obliga a utilizar el modo de reporte recomendado
        include 'database/creds.php';
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            require('database/creds.php');
            $this -> db = new mysqli($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
            $this -> db -> set_charset($charset);
        } catch (mysqli_sql_exception $e) {
            throw new mysqli_sql_exception($e -> getMessage(), $e -> getCode());
        } finally {
            unset($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
        }
    }

    // Devuelve un SELECT FROM * de una tabla indicada por parámetro.
    public function selectAll(string $table): array
    {
        $result = $this -> db -> execute_query("SELECT * FROM $table");
        if ($result -> num_rows === 1) {
            $row = $result->fetch_assoc();
            foreach ($row as $key => $value) {
                $animeInfo[$key] = $value;
            }
        }
    return $animeInfo;
    }
}