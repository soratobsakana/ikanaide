<?php

require_once 'Database.php';
require_once 'User.php';

class Listing
{
    private object $con;

    public function __construct()
    {
        $this -> con = new Database;
    }

    public function exists(string $medium, string $entry): int|bool
    {
        $result = $this -> con -> db -> execute_query('SELECT `'.$medium.'_id` FROM '.$medium.' WHERE title= ?', [$entry]);
        if ($result -> num_rows === 1) {
            return $result -> fetch_column();
        } else {
            return false;
        }
    }

    public function existsWithId(string $medium, int $entry): bool
    {
        $result = $this -> con -> db -> execute_query('SELECT `'.$medium.'_id` FROM '.$medium.' WHERE `'.$medium.'_id` = ?', [$entry]);
        if ($result -> num_rows === 1) {
            return true;
        } else {
            return false;
        }
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
    }

    // Retorno una cadena en este método porque, en caso de ser retornar un número entero, prefiero mostrar X.00 en vez de X, en este caso.
    public function getScore(string $medium, int $medium_id): string|null
    {
        return $this -> con -> db -> execute_query('SELECT score FROM (
        SELECT '.$medium.'_id, round(avg(score), 2) AS score FROM '.$medium.'list GROUP BY '.$medium.'_id
        ) AS scores WHERE '.$medium.'_id = ?', [$medium_id]) -> fetch_column();
    }

    public function getFavourites(string $medium, int $medium_id): int
    {
        return $this -> con -> db -> execute_query('SELECT count(favorite) FROM '.$medium.'list WHERE '.$medium.'_id = ? AND favorite=true', [$medium_id]) -> fetch_column();
    }

    public function getMembers(string $medium, int $medium_id): int
    {
        return $this -> con -> db -> execute_query('SELECT count(user_id) FROM '.$medium.'list WHERE '.$medium.'_id = ?', [$medium_id]) -> fetch_column();
    }

    public function getRank(string $medium, int $medium_id): int
    {
        return $this -> con -> db -> execute_query('SELECT score_rank FROM (
        SELECT '.$medium.'_id, ROUND(AVG(score), 2) AS score, ROW_NUMBER() OVER(ORDER BY AVG(score)) AS score_rank
        FROM '.$medium.'list WHERE score IS NOT NULL
        GROUP BY '.$medium.'_id
        ) AS scores WHERE '.$medium.'_id = ?', [$medium_id]) -> fetch_column();
    }

    public function getPopularity(string $medium, int $medium_id): int
    {
        return $this -> con -> db -> execute_query('SELECT pop_rank FROM (
        SELECT '.$medium.'_id, COUNT('.$medium.'_id) AS popularity, ROW_NUMBER() OVER(ORDER BY COUNT('.$medium.'_id) desc) AS pop_rank
        FROM '.$medium.'list
        GROUP BY '.$medium.'_id
        ) AS pop_rank WHERE '.$medium.'_id = ?', [$medium_id]) -> fetch_column();
    }

    // Devuelve la información sobre los personajes asociados a una entrada de la base de datos.
    public function getChars(string $table, array $params): array|null
    {
        $characters = [];
        
        $result = $this -> con -> db -> execute_query("SELECT `character`.*, `character_".$table."`.`role` FROM `character`, `character_".$table."`
        WHERE `character_".$table."`.`".$table."_id` = ?
        AND `character`.`character_id`=`character_$table`.character_id", $params);

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
    }

    // Devuelve la información sobre los miembros de staff asociados a una entrada de la base de datos.
    public function getStaff(string $table, array $params): array|null
    {
        
        $staff = [];

        $result = $this -> con -> db -> execute_query("SELECT `staff`.*, `staff_".$table."`.`role` FROM `staff`, `staff_".$table."`
        WHERE `staff_".$table."`.`".$table."_id` = ?
        AND `staff`.`staff_id`=`staff_".$table."`.staff_id", $params);

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
    }

    // Devuelve la información sobre las reviews asociadas a una entrada de la base de datos.
    public function getReviews(string $table, array $params): array|null
    {
        $reviews = [];

        $result = $this -> con -> db -> execute_query("SELECT `review`.* FROM `review`, `review_".$table."`
        WHERE `review_".$table."`.`".$table."_id` = ?
        AND `review`.review_id = `review_".$table."`.`review_id`", $params);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                // Asignación de las columnas de `review` al array $reviewsHome.
                foreach ($row as $key => $value) {
                    $reviewInfo[$key] = $value;
                }

                $user = $this -> con -> db -> execute_query('SELECT username, pfp FROM user WHERE user_id = ?', [$row['user_id']]);
                if ($user -> num_rows === 1) {
                    $row = $user -> fetch_assoc();
                    $reviewInfo['username'] = $row['username'];
                    $reviewInfo['pfp'] = $row['pfp'];
                }

                $reviews[] = $reviewInfo;
            }
            return $reviews;
        } else {
            return $reviews = null;
        }
    }

    // 
    public function getHome($medium): object
    {
        $query = 'SELECT ' . $medium . '_id, title, cover FROM ' . $medium;
        return $this -> con -> db -> execute_query($query);
    }

    public function getEpisodesOrChapters(string $medium, int $id): int
    {
        $medium === 'anime' ? $current = 'episodes' : $current = 'chapters';
        $result = $this -> con -> db -> execute_query('SELECT '.$current.' FROM '.$medium.' WHERE '.$medium.'_id = ?', [$id]) -> fetch_column();
        if (isset($result)) {
            return $result;
        } else {
            return 0;
        }
    }
}