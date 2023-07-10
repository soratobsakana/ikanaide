<?php

namespace App;

class Ranking
{
    private object $con;
    private object $listing;
    private object $user;

    public function __construct()
    {
        $this -> con = new Database;
        $this -> listing = new Listing;
        $this -> user = new User;
    }

    /**
     * @param string $medium
     * @return array|null
     * Devuelve todos los animes|mangas clasificados. Un anime|manga está clasificado si existe en las tablas de `animelist` o `mangalist` y tiene asignado, al menos, una nota (`score`) en alguna de las filas.
     * Se extrae la información necesitada en la página de clasificación (/rankings): ID de cada entrada, su nota, su puesto en la clasificación, el número de usuarios que lo tienen en su lista, el título y la carátula.
     */
    public function getRankings(string $medium): array|null
    {
        $result = $this -> con -> db -> execute_query('select '.$medium.'_id, round(avg(score), 2) as score, row_number() over(order by avg(score) desc) as ranking from '.$medium.'list where score is not null group by '.$medium.'_id');
        if ($result -> num_rows > 0) {
            for ($i=0; $i < $result -> num_rows; $i++) {
                $row = $result -> fetch_assoc();
                $entry[$i] = $this -> con -> db -> execute_query('select '.$medium.'_id, title, cover from '.$medium.' where '.$medium.'_id='.$row[$medium.'_id']) -> fetch_assoc();
                $entry[$i]['members'] = $this -> listing -> getMembers($medium, $row[$medium.'_id']);
                $entry[$i]['score'] = $row['score'];
                $entry[$i]['rank'] = $row['ranking'];
                
                if ($this -> user -> validateSession()) {
                    $userInfo['list'] = $this -> con -> db -> execute_query('SELECT count(user_id) FROM '.$medium.'list WHERE user_id = ? AND '.$medium.'_id = ?', [$_COOKIE['user_id'], $row[$medium.'_id']]) -> fetch_column();
                    if ($userInfo['list'] === 1) {
                        $entry[$i]['userList'] = true; 
                    } else {
                        $entry[$i]['userList'] = false;
                    }

                    $userInfo['list'] = $this -> con -> db -> execute_query('SELECT favorite FROM '.$medium.'list WHERE user_id = ? AND '.$medium.'_id = ?', [$_COOKIE['user_id'], $row[$medium.'_id']]) -> fetch_column();
                    if ($userInfo['list'] === 1) {
                        $entry[$i]['userFav'] = true; 
                    } else {
                        $entry[$i]['userFav'] = false;
                    }
                }
                
            }

            return $entry;
        } else {
            return null;
        }
    }

    public function add(string $medium, int $medium_id, $userId): bool
    {
        if ($this -> con -> db -> execute_query('INSERT INTO `'.$medium.'list` (`user_id`, `'.$medium.'_id`, `progress`) VALUES (?, ?, default)',[$userId, $medium_id])) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(string $medium, int $medium_id, $userId): bool
    {
        if ($this -> con -> db -> execute_query('DELETE FROM `'.$medium.'list` WHERE '.$medium.'_id = ? AND user_id = ?',[$medium_id, $userId])) {
            return true;
        } else {
            return false;
        }
    }

    public function favorite(string $medium, int $medium_id, $userId): bool
    {
        if ($this -> con -> db -> execute_query('UPDATE '.$medium.'list SET favorite = true WHERE '.$medium.'_id = ? AND user_id = ?', [$medium_id, $userId])) {
            return true;
        } else {
            return false;
        }
    }

    public function unfavorite(string $medium, int $medium_id, $userId): bool
    {
        if ($this -> con -> db -> execute_query('UPDATE '.$medium.'list SET favorite = false WHERE '.$medium.'_id = ? AND user_id = ?', [$medium_id, $userId])) {
            return true;
        } else {
            return false;
        }
    }
}