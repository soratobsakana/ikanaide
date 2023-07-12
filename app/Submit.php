<?php

namespace App;

class Submit
{
    public static function newAnimeProposal(array $animeData, int $userId): bool
    {
        if (DB::query('INSERT INTO submit_anime VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, default)', [
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

    public static function newMangaProposal(array $mangaData, int $userId): bool
    {
        if (DB::query('INSERT INTO submit_manga VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, default)', [
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

    public static function newCharacterProposal(array $characterData, int $userId): bool
    {
        if (DB::query('INSERT INTO submit_character VALUES (null, ?, ?, ?, ?, ?, ?,  ?, default)', [
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

    public static function newStaffProposal(array $staffData, int $userId): bool
    {
        if (DB::query('INSERT INTO submit_staff VALUES (null, ?, ?, ?, ?, ?, ?,  ?, default)', [
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

    public static function submitNewAnime(array $animeData): bool
    {
        if (DB::query('INSERT INTO `anime` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, default)', [
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
        ])) {
            return true;
        } else {
            return false;
        }
    }

    public static function submitNewManga(array $mangaData): bool
    {
        if (DB::query('INSERT INTO `manga` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, default)', [
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
        ])) {
            return true;
        } else {
            return false;
        }
    }

    public static function submitNewCharacter(array $characterData): bool
    {
        if (DB::query('INSERT INTO `character` VALUES (null, ?, ?, ?, ?, ?, ?, default)', [
            $characterData['family_name'],
            $characterData['given_name'],
            $characterData['alias'],
            $characterData['japanese_name'],
            $characterData['biography'],
            $characterData['picture'] ?? null,
        ])) {
            return true;
        } else {
            return false;
        }
    }

    public static function submitNewStaff(array $staffData): bool
    {
        if (DB::query('INSERT INTO `staff` VALUES (null, ?, ?, ?, ?, ?, ?, default)', [
            $staffData['family_name'],
            $staffData['given_name'],
            $staffData['alias'],
            $staffData['japanese_name'],
            $staffData['biography'],
            $staffData['picture'] ?? null,
        ])) {
            return true;
        } else {
            return false;
        }
    }
}