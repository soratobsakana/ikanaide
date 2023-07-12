<?php

namespace App;

class Search
{
    public static function getPostResults(string $medium, int $entryID): array|null
    {
        if (Listing::existsWithId($medium, $entryID)) {
            $result = DB::query('SELECT post_id FROM post_'.$medium.' WHERE '.$medium.'_id = ? ORDER BY post_id DESC', [$entryID]);
            if ($result -> num_rows > 0) {

                foreach ($result as $post) {
                    $searchResults[] = $post['post_id'];
                }

                foreach ($searchResults as $result) {
                    $postResults[] = Activity::getPost($result);
                }

                $postResults['title'] = Listing::getTitle($medium, $entryID);
                $postResults['medium'] = $medium;

            } else {
                $postResults['title'] = Listing::getTitle($medium, $entryID);
            }
            return $postResults;
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
    public static function exists(string $type, string $entry): array|null
    {
        switch($type) {
            case 'anime':
            case 'manga':
                // En este caso, $entry indicará el título (`title` en la tabla `anime` o `manga`).
                $result = DB::query("SELECT title, `".$type."_id` FROM ".$type." WHERE title LIKE CONCAT ('%', ?, '%')", [$entry]);
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
                $result = DB::query("SELECT `user_id`, `username`, `pfp` FROM `user` WHERE `username` LIKE CONCAT ('%', ?, '%') ORDER BY username", [$entry]);
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

    public static function getKeywordResults(string $keyword): array|null
    {
        $ifAnime = self::exists('anime', $keyword);
        $ifManga = self::exists('manga', $keyword);
        $ifUsers = self::exists('user', $keyword);

        if (isset($ifAnime)) {
            foreach ($ifAnime as $occurrence) {
                $mediumResults['anime'][] = [
                    'title' => $occurrence['title'],
                    'anime_id' => $occurrence['anime_id'],
                    'post_count' => Activity::getPostRelationCount('anime', $occurrence['anime_id'])
                ];
            }
        }

        if (isset($ifManga)) {
            foreach ($ifManga as $occurrence) {
                $mediumResults['manga'][] = [
                    'title' => $occurrence['title'],
                    'manga_id' => $occurrence['manga_id'],
                    'post_count' => Activity::getPostRelationCount('manga', $occurrence['manga_id'])
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