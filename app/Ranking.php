<?php

include_once 'Database.php';
include_once 'Listing.php';

class Ranking
{
    private object $con;
    private object $listing;

    public function __construct()
    {
        $this -> con = new Database;
        $this -> listing = new Listing;
    }

    /**
     * Returns all ranked anime|manga. An anime is ranked if it exists on any of the medium lists (atm: `animelist` and `mangalist`) that has a score.
     * Information needed for the rankings page is: the ID of each entry, its score, its rank, member count, title and cover.
     */
    public function getRankings(string $medium): array|null
    {
        $result = $this -> con -> db -> execute_query('select '.$medium.'_id, round(avg(score), 2) as score, row_number() over(order by avg(score) desc) as ranking from '.$medium.'list where score is not null group by '.$medium.'_id');
        if ($result -> num_rows > 0) {
            for ($i=0; $i < $result -> num_rows; $i++) {
                $row = $result -> fetch_assoc();
                $anime[$i] = $this -> con -> db -> execute_query('select title, cover from '.$medium.' where '.$medium.'_id='.$row[$medium.'_id']) -> fetch_assoc();
                $anime[$i]['members'] = $this -> listing -> getMembers($medium, $row[$medium.'_id']);
                $anime[$i]['score'] = $row['score'];
                $anime[$i]['rank'] = $row['ranking'];
            }
            return $anime;
        } else {
            return null;
        }
    }
}