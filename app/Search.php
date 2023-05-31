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
                $postResults['title'] = $this -> listing -> getTitle($medium, $entryID);
                return $postResults;
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
    public function exists(string $type, string $entry): array|null
    {
        switch($type) {
            case 'anime':
            case 'manga':
                // En este caso, $entry indicará el título (`title` en la tabla `anime` o `manga`).
                $result = $this -> con -> db -> execute_query("SELECT title, `".$type."_id` FROM ".$type." WHERE title LIKE CONCAT ('%', ?, '%')", [$entry]);
                if ($result -> num_rows > 0) {
                    foreach ($result as $occurrence) {
                        $mediumOccurrences[] = ['title' => $occurrence['title'], $type.'_id' => $occurrence[$type.'_id']];
                    }
                    return $mediumOccurrences;
                } else {
                    return null;
                }
                break;
            case 'user':
                // En este caso, $entry indicará el nombre de usuario.
                $result = $this -> con -> db -> execute_query("SELECT `user_id`, `username`, `pfp` FROM `user` WHERE `username` LIKE CONCAT ('%', ?, '%') ORDER BY username", [$entry]);
                if ($result -> num_rows > 0) {
                    foreach ($result as $occurrence) {
                        $userOccurrences[] = ['user_id' => $occurrence['user_id'], 'username' => $occurrence['username'], 'pfp' => $occurrence['pfp']];
                    }
                    return $userOccurrences;
                } else {
                    return null;
                }
                break;
            default:
                return null;
        }
    }

    public function getKeywordResults(string $keyword): array|null
    {
        $ifAnime = $this -> exists('anime', $keyword);
        $ifManga = $this -> exists('manga', $keyword);
        $ifUsers = $this -> exists('user', $keyword);

        if (isset($ifAnime)) {
            foreach ($ifAnime as $occurrence) {
                $mediumResults['anime'][] = [
                    'title' => $occurrence['title'],
                    'anime_id' => $occurrence['anime_id'],
                    'post_count' => $this -> activity -> getPostRelationCount('anime', $occurrence['anime_id'])
                ];
            }
        }

        if (isset($ifManga)) {
            foreach ($ifManga as $occurrence) {
                $mediumResults['manga'][] = [
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
            if (isset($mediumResults[$medium])) {
                for ($i = 0; $i < count($mediumResults); $i++) {
                    usort($mediumResults[$medium], function ($item1, $item2) {
                        return $item2['post_count'] <=> $item1['post_count'];
                    });
                }
            }
        }

        if (isset($ifUsers)) {
            foreach ($ifUsers as $occurrence) {
                $userResults[] = [
                    'user_id' => $occurrence['user_id'],
                    'username' => $occurrence['username'],
                    'pfp' => $occurrence['pfp']
                ];
            }
        }

        if (!isset($mediumResults) && !isset($userResults)) {
            return null;
        } else {
            $searchResults = [
                'medium' => $mediumResults ?? null,
                'users' => $userResults ?? null
            ];

            return $searchResults;
        }
    }
}