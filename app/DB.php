<?php

namespace App;
use mysqli, mysqli_sql_exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class DB {
    private static function mysql(): mysqli
    {
        // Obliga a utilizar el modo de reporte recomendado
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            require(BASE_PATH . 'database/creds.php');
            return new mysqli($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
        } catch (mysqli_sql_exception $e) {
            throw new mysqli_sql_exception($e -> getMessage(), $e -> getCode());
        } finally {
            unset($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
        }
    }

    public static function query(string $query, array $param): object
    {
        return self::mysql()->execute_query($query, $param);
    }
}