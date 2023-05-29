<?php

require_once 'Database.php';

class Submit
{
    public object $con;

    public function __construct()
    {
        $this -> con = new Database;
    }

    public function newAnimeProposal(array $animeData, int $userId): bool
    {
        if ($this -> con -> db -> execute_query('INSERT INTO submit_anime VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, default)', [
            $animeData['title'],
            $animeData['english_title'],
            $animeData['japanese_title'],
            $animeData['type'],
            $animeData['episodes'],
            $animeData['status'],
            $animeData['start_date'],
            $animeData['end_date'],
            $animeData['desc'],
            $animeData['cover'] ?? null,
            $animeData['header'] ?? null,
            $userId
        ])) {

            return true;
        } else{
            return false;
        }
    }

    public function newMangaProposal(array $mangaData, int $userId): bool
    {
        if ($this -> con -> db -> execute_query('INSERT INTO submit_manga VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, default)', [
            $mangaData['title'],
            $mangaData['english_title'],
            $mangaData['japanese_title'],
            $mangaData['format'],
            $mangaData['volumes'],
            $mangaData['chapters'],
            $mangaData['status'],
            $mangaData['start_date'],
            $mangaData['end_date'],
            $mangaData['desc'],
            $mangaData['cover'] ?? null,
            $mangaData['header'] ?? null,
            $userId
        ])) {
            return true;
        } else{
            return false;
        }
    }

    public function newCharacterProposal(array $characterData, int $userId): bool
    {
        if ($this -> con -> db -> execute_query('INSERT INTO submit_character VALUES (null, ?, ?, ?, ?, ?, ?,  ?, default)', [
            $characterData['family_name'],
            $characterData['given_name'],
            $characterData['alias'],
            $characterData['japanese_name'],
            $characterData['biography'],
            $characterData['picture'] ?? null,
            $userId
        ])) {
            return true;
        } else{
            return false;
        }
    }

    public function newStaffProposal(array $staffData, int $userId): bool
    {
        if ($this -> con -> db -> execute_query('INSERT INTO submit_staff VALUES (null, ?, ?, ?, ?, ?, ?,  ?, default)', [
            $staffData['family_name'],
            $staffData['given_name'],
            $staffData['alias'],
            $staffData['japanese_name'],
            $staffData['biography'],
            $staffData['picture'] ?? null,
            $userId
        ])) {
            return true;
        } else{
            return false;
        }
    }
}