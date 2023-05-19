<?php

include_once 'Database.php';
include_once 'Listing.php';
include_once 'Activity.php';

class Search
{
    private object $con;
    private object $listing;
    private object $activity;

    public function __construct()
    {
        $this -> con = new Database;
        $this -> listing = new Listing;
        $this -> activity = new Activity;
    }

    public function getPostResults(string $medium, int $entryID): array|null
    {
        if ($this -> listing -> existsWithId($medium, $entryID)) {
            $result = $this -> con -> db -> execute_query('SELECT post_id FROM post_'.$medium.' WHERE '.$medium.'_id = ? ORDER BY post_id DESC', [$entryID]);
            if ($result -> num_rows > 0) {

                foreach ($result as $post) {
                    $searchResults[] = $post['post_id'];
                }

                foreach ($searchResults as $result) {
                    $postResults[] = $this -> activity -> getPost($result);
                }

                $postResults['title'] = $this -> listing -> getTitle($medium, $entryID);
                $postResults['medium'] = $medium;

                return $postResults;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * @param string $medium
     * @param string $entry
     * @return array|null
     * Devuelve las ocurrencias de la DB mediante el operador LIKE '%$entrada%';
     */
    public function exists(string $medium, string $entry): array|null
    {
        $result = $this -> con -> db -> execute_query("SELECT title, `".$medium."_id` FROM ".$medium." WHERE title LIKE CONCAT ('%', ?, '%')", [$entry]);
        if ($result -> num_rows > 0) {
            foreach ($result as $occurrence) {
                $occurrences[] = ['title' => $occurrence['title'], $medium.'_id' => $occurrence[$medium.'_id']];
            }
            return $occurrences;
        } else {
            return null;
        }
    }

    public function getKeywordResults(string $keyword): array|null
    {
        $ifAnime = $this -> exists('anime', $keyword);
        $ifManga = $this -> exists('manga', $keyword);

        if (isset($ifAnime)) {
            foreach ($ifAnime as $occurrence) {
                $searchResults['anime'][] = [
                    'title' => $occurrence['title'],
                    'anime_id' => $occurrence['anime_id'],
                    'post_count' => $this -> activity -> getPostRelationCount('anime', $occurrence['anime_id'])
                ];
            }
        }

        if (isset($ifManga)) {
            foreach ($ifManga as $occurrence) {
                $searchResults['manga'][] = [
                    'title' => $occurrence['title'],
                    'manga_id' => $occurrence['manga_id'],
                    'post_count' => $this -> activity -> getPostRelationCount('manga', $occurrence['manga_id'])
                ];
            }
        }

        // Mediante este bucle ordeno los animes|mangas a partir del numero de posts asociados, de manera descendente.
        // https://stackoverflow.com/a/19454643
        $mediums = ['anime', 'manga'];
        foreach ($mediums as $medium) {
            if (isset($searchResults[$medium])) {
                for ($i = 0; $i < count($searchResults); $i++) {
                    usort($searchResults[$medium], function ($item1, $item2) {
                        return $item2['post_count'] <=> $item1['post_count'];
                    });
                }
            }
        }

        return $searchResults ?? null;
    }
}