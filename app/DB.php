<?php

namespace App;
use mysqli, mysqli_sql_exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class DB {
    private static object $c;

    private static function mysql()
    {
        // Obliga a utilizar el modo de reporte recomendado
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            require(BASE_PATH . 'database/creds.php');
            self::$c = new mysqli($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
            return true;
        } catch (mysqli_sql_exception $e) {
            throw new mysqli_sql_exception($e -> getMessage(), $e -> getCode());
        } finally {
            unset($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
        }
    }

    public static function query(string $query, array $param = NULL): \mysqli_result|bool
    {
        self::mysql();
        return self::$c->execute_query($query, $param);
    }

    public static function insertedId(): int
    {
        return self::$c->insert_id;
    }
}