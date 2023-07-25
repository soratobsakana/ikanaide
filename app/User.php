<?php

namespace App;

class User
{

    private object $listing;

    public function __construct()
    {
        $this -> listing = new Listing;
    }

    public static function register(array $registerInfo): string|true
    {
        // Inspección de que los nombres de campo del formulario HTML no han sido modificados en las herramientas de navegador.
        $fields = ['username', 'email', 'password', 'confirm', 'register'];
        foreach ($_POST as $key => $value) {
            if (!in_array($key, $fields)) {
                return 'Please fill up the missing fields.';
            }
        }

        // Estos nombres de usuario no pueden usarse ya que se solaparian con rutas de la web.
        $reservedUsernames = ['home', 'anime', 'manga', 'vn', 'rankings', 'profile', 'reviews', 'forum', 'terms', 'privacy', 'contact', 'support', 'about', 'edit', 'sum', 'post', 'reply', 'like', 'bookmark', 'delete', 'follow', 'timeline', 'submit', 'login', 'register', 'logout', 'home', '404'];

        // Inspección de los datos introducidos.
        if (isset($registerInfo['username'], $registerInfo['email'], $registerInfo['password'], $registerInfo['confirm'])) {
            if (!(empty($registerInfo['username']) || empty($registerInfo['email']) || empty($registerInfo['password']) || empty($registerInfo['confirm']))) {
                if (filter_var($registerInfo['email'], FILTER_VALIDATE_EMAIL)) {
                    if (preg_match('/^[a-zA-Z0-9]+$/', $registerInfo['username']) === 1) {
                        if (!in_array($registerInfo['username'], $reservedUsernames)) {
                            if (strlen($registerInfo['username']) >= 3 && strlen($registerInfo['username']) <= 16) {
                                if ($registerInfo['password'] === $registerInfo['confirm']) {
                                    $result = DB::query('SELECT user_id FROM user WHERE username = ?', [$registerInfo['username']]);
                                    if ($result -> num_rows === 0) {
                                        $result = DB::query('SELECT user_id FROM user WHERE email = ?', [$registerInfo['email']]);
                                        if ($result -> num_rows === 0) {
                                            $password = password_hash($registerInfo['password'], PASSWORD_DEFAULT);
                                            DB::query('INSERT INTO `user` (`username`, `password`, `email`) VALUES (?, ?, ?)', [
                                                $registerInfo['username'],
                                                $password,
                                                $registerInfo['email'],
                                            ]);
                                            $result = DB::query('SELECT user_id FROM user WHERE username = ?', [$registerInfo['username']]);
                                            $user_id = $result -> fetch_column();
                                            setcookie('username', $registerInfo['username'], strtotime('NOW+60DAYS'));
                                            setcookie('user_id', $user_id, strtotime('NOW+60DAYS'));
                                            setcookie('passwd', $password, strtotime('NOW+60DAYS'));
                                            setcookie('session', "Yes", strtotime('NOW+60DAYS'));
                                            setcookie('home_timeline', 'default', strtotime('NOW+60DAYS'));
                                            return true;
                                        } else {
                                            return 'Sorry, that email is already taken';
                                        }
                                    } else {
                                        return 'Sorry, that username is already taken.';
                                    }
                                } else {
                                    return 'Password confirmation doesn\'t match';
                                }
                            } else {
                                return 'The username  must be between 3 and 16 characters long.';
                            }
                        } else {
                            return 'Sorry, that username is reserved.';
                        }
                    } else {
                        return 'The username must only contain alphanumeric characters.';
                    }
                } else {
                    return 'That email format is not valid.';
                }
            } else {
                return 'Please fill up the missing fields.';
            }
        } else {
            return 'Please fill up the missing fields.';
        }
    }

    public static function login(array $loginInfo): string|true
    {
        // Inspección de que los nombres de campo del formulario HTML no han sido modificados en las herramientas de navegador.
        $fields = ['username', 'password', 'login'];
        foreach ($_POST as $key => $value) {
            if (!in_array($key, $fields)) {
                return 'Please fill up the missing fields.';
            }
        }

        // Inspección de los datos introducidos.
        if (isset($loginInfo['username'], $loginInfo['password'])) {
            if (!(empty($loginInfo['username']) || empty($loginInfo['password']))) {
                if (preg_match('/^[a-zA-Z0-9]+$/', $loginInfo['username']) === 1) {
                    if (strlen($loginInfo['username']) > 3 && strlen($loginInfo['username']) < 16) {
                        // Comprobación del nombre de usuario. Si coincide se comprobará la contraseña.
                        $result = DB::query('SELECT `user_id` FROM user WHERE username = ?', [$loginInfo['username']]);
                        if ($result -> num_rows === 1) {
                            $user_id = $result -> fetch_column();
                            $result = DB::query('SELECT username FROM user WHERE user_id = ?', [$user_id]);
                            $username = $result -> fetch_column();
                            // Comprobación de la contraseña. Si coincide se autenticará al usuario.
                            $result = DB::query('SELECT `password` FROM user WHERE username = ?', [$loginInfo['username']]);
                            $password = $result -> fetch_column();
                            if (password_verify($loginInfo['password'], $password)) {
                                // Todas las verificaciones han sido exitosas, por lo que se inicia una sesión al usuario autenticado.
                                setcookie('username', $username, strtotime('NOW+60DAYS'));
                                setcookie('user_id', $user_id, strtotime('NOW+60DAYS'));
                                setcookie('passwd', $password, strtotime('NOW+60DAYS'));
                                setcookie('session', "Yes", strtotime('NOW+60DAYS'));
                                setcookie('home_timeline', 'default', strtotime('NOW+60DAYS'));
                                return true;
                            } else {
                                return 'Incorrect username or password';
                            }
                        } else {
                            return 'Incorrect username or password.';
                        }
                    } else {
                        return 'Incorrect username or password.';
                    }
                } else {
                    return 'Incorrect username or password.';
                }
            } else {
                return 'Please fill up the missing fields.';
            }
        } else {
            return 'Please fill up the missing fields.';
        }
    }

    // Este método añade seguridad al sistema de autenticación de usuario. Se compara la información actual de una cookie con la de la base de datos.
    // Si coincide, indicaría que el usuario no ha alterado la información de sus cookies y que, efectivamente, conserva la información que se generó en User::login() o User::register()).
    public static function validateSession(): bool
    {
        if (isset($_COOKIE['username'], $_COOKIE['passwd'], $_COOKIE['user_id'])) {
            $result = DB::query('SELECT `user_id` FROM `user` WHERE username = ?', [$_COOKIE['username']]);
            if ($result -> num_rows === 1) {
                $id = $result -> fetch_column();
                if ($id == $_COOKIE['user_id']) {
                    $passwd = DB::query('SELECT `password` FROM `user` WHERE `user_id` = ?', [$_COOKIE['user_id']]) -> fetch_column();
                    if ($passwd === $_COOKIE['passwd']) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function exists(int $userId): bool
    {
        if (DB::query('SELECT user_id FROM `user` WHERE user_id = ?', [$userId])) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUserID(string $username): int|null
    {
        $result = DB::query('SELECT `user_id` FROM `user` WHERE username = ?', [$username]);
        if ($result -> num_rows === 1) {
            return $user_id = $result -> fetch_column();
        } else {
            return null;
        }
    }

    public static function getUsername(int $user_id): string|null
    {
        $result = DB::query('SELECT `username` FROM `user` WHERE user_id = ?', [$user_id]);
        if ($result -> num_rows === 1) {
            return $result -> fetch_column();
        } else {
            return null;
        }
    }

    public static function getInfo(int $user_id): array
    {
        return DB::query('SELECT `user_id`, `username`, `joined_at`, `pfp`, `header`, `biography`, `born`, `country`, `twitter`, `github`, `discord`, `website` FROM user WHERE user_id = ?', [$user_id]) -> fetch_assoc();
    }

    public static function getInfoLess(int $user_id): array
    {
        return DB::query('SELECT `user_id`,`username`,`pfp` FROM user WHERE user_id = ?', [$user_id]) -> fetch_assoc();
    }

    public static function getList(string $medium, int $user_id): array|null
    {
        $result = DB::query('SELECT * FROM `'.$medium.'list` WHERE `user_id` = ?', [$user_id]);
        for ($i = 0; $i < $result -> num_rows; $i++) {
            foreach($result -> fetch_assoc() as $key => $value) {
                if ($key === 'score') {
                    // Ya que quiero mostrar 4.5, 4.2... pero no 4.0, esta condición convierte 4.0 en 4.
                    if ($value !== null && fmod($value, 1) === 0.0) {
                        $list[$i][$key] = floor($value);
                    } else {
                        $list[$i][$key] = $value;
                    }
                } else {
                    $list[$i][$key] = $value;
                }
            }
        }
        return $list ?? null;
    }

    /**
     * @param $userId
     * @return array|null
     * Returns number of completed|watching|stalled|planned|dropped animes/mangas registered in a user list.
     */
    public static function getStatusCounter($userId): array|null
    {
        $mediums = ['anime', 'manga'];

        foreach ($mediums as $medium) {
            $result = DB::query('SELECT `status`, count(`'.$medium.'_id`) as count FROM `'.$medium.'list` WHERE `user_id` = ? GROUP BY `status`', [$userId]);
            while ($row = $result -> fetch_assoc()) {
                $statusCounter[$medium][$row['status']] = $row['count'];
            }
        }

        return $statusCounter ?? null;
    }

    public static function getListEntry(string $medium, int $medium_id, int $user_id): array
    {
        $result = DB::query('SELECT * FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]);
        if ($result -> num_rows === 1) {
            $row = $result -> fetch_assoc();
            foreach ($row as $key => $value) {
                if ($key === 'score') {
                    // Ya que quiero mostrar 4.5, 4.2... pero no 4.0, esta condición convierte 4.0 en 4.
                    if ($value !== null && fmod($value, 1) === 0.0) {
                        $listEntry[$key] = floor($value);
                    } else {
                        $listEntry[$key] = $value;
                    }
                } else {
                    $listEntry[$key] = $value;
                }
            }
            return $listEntry;
        } else {
            return $listEntry = [];
        }
    }

    // Añadir o borrar un anime o manga a la base de datos.
    public static function addToList(string $medium, int|string $mediumf_id, int $user_id, string $entry)
    {
        $result = DB::query('SELECT `user_id` FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]) -> num_rows;
        if ($result === 0) {
            DB::query('INSERT INTO `'.$medium.'list` (`user_id`, `'.$medium.'_id`, `progress`) VALUES (?, ?, default)', [$user_id, $medium_id]);
        }
        header('Location: /'.$medium.'/' . $entry);
    }

    public static function deleteFromList(string $medium, int $medium_id, int $user_id, string $entry)
    {
        $result = DB::query('SELECT `user_id` FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]) -> num_rows;
        if ($result === 1) {
            DB::query('DELETE FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]);
        }
        header('Location: /'.$medium.'/' . $entry);
    }

    public static function favourite(string $medium, int $medium_id, int $user_id, string $entry)
    {

        $result = DB::query('SELECT count(`user_id`) FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ? AND favorite = true', [$user_id, $medium_id]);
        $column = $result -> fetch_column();
        if ($column === 0) {
            DB::query('UPDATE '.$medium.'list SET `favorite` = true WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]);
        }
        header('Location: /'.$medium.'/' . $entry);
    }

    public static function unfavourite(string $medium, int $medium_id, int $user_id, string $entry)
    {
        $result = DB::query('SELECT count(`user_id`) FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ? AND favorite = false', [$user_id, $medium_id]) -> fetch_column();
        if ($column === 0) {
            DB::query('UPDATE '.$medium.'list SET `favorite` = false WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]);
        }
        header('Location: /'.$medium.'/' . $entry);
    }

    // $counter is the number of episodes|chapters.
    public static function editListEntry(string $medium, int $medium_id, int $user_id, string $entry, int $counter)
    {
        $medium === 'anime' ? $current = 'watching' : $current = 'reading';

        // Confirmación de que el usuario no alterado el nombre de campo en el formulario HTML de mediumpage.view.php.
        $fields = ['status', 'score', 'progress', 'start-date', 'end-date', 'rewatches', 'notes', 'save'];
        $statusValues = [$current, 'completed', 'planned', 'stalled', 'dropped'];
        foreach ($_POST as $key => $value) {
            if (!in_array($key, $fields)) {
                exit(header('Location: /'.$medium.'/' . $entry));
            }
        }

        foreach($_POST as $key => $value) {
            if ($key !== 'save') {
                switch($key) {
                    case 'status':
                        if (in_array($value, $statusValues)) {
                            $entryInfo[$key] = $value ?? null;
                        } else {
                            exit(header('Location: /'.$medium.'/' . $entry));
                        }
                        break;
                    case 'score':
                        if ($value >= 1 && $value <= 10) {
                            $entryInfo[$key] = $value ?? null;
                        } else {
                            $entryInfo[$key] = null;
                        }
                        break;
                    case 'progress':
                        is_numeric($value) ? $value = intval(floor($value)) : $value = false;
                        if (($value < 0 || $value > $counter) && $value !== false) {
                            exit(header('Location: /'.$medium.'/' . $entry));
                        } else {
                            $entryInfo[$key] = $value ?? null;
                        }
                        break;
                    case 'start-date':
                    case 'end-date':
                        $date = date_parse($value);
                        if (checkdate($date['month'], $date['day'], $date['year'])) {
                            $entryInfo[$key] = $value;
                        } else {
                            $entryInfo[$key] = null;
                        }
                        break;
                    case 'rewatches':
                        if ($value < 0) {
                            $entryInfo[$key] = 0;
                        } else {
                            $entryInfo[$key] = $value ?? null;
                        }
                        break;
                    default:
                        $entryInfo[$key] = $value ?? null;
                }
            }
        }

        if (empty($entryInfo['start-date'])) {
            $entryInfo['start-date'] = null;
        }
        if (empty($entryInfo['end-date'])) {
            $entryInfo['end-date'] = null;
        }
        if ($entryInfo['status'] === 'completed') {
            $entryInfo['progress'] = $counter;
        }

        DB::query('UPDATE '.$medium.'list SET status = ?, score = ?, progress = ?, start_date = ?, end_date = ?, rewatches = ?, notes = ? WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [
            $entryInfo['status'],
            $entryInfo['score'],
            $entryInfo['progress'],
            $entryInfo['start-date'],
            $entryInfo['end-date'],
            $entryInfo['rewatches'],
            $entryInfo['notes'],
            $user_id,
            $medium_id
        ]);


        header('Location: /'.$medium.'/' . $entry);
    }

        public static function setListStatus(string $medium, int $medium_id, string $status, int $user_id): bool
    {
        if (DB::query('UPDATE '.$medium.'list SET status = ? WHERE '.$medium.'_id = ? AND user_id = ?', [$status, $medium_id, $user_id])) {
            return true;
        } else {
            return false;
        }
    }

    public static function getEpisodesOrChapters(string $medium, int $medium_id, int $user_id): int|false
    {
        $medium === 'anime' ? $current = 'episodes' : $current = 'chapters';
        $result = DB::query('SELECT progress FROM '.$medium.'list WHERE '.$medium.'_id = ? AND user_id = ?', [$medium_id, $user_id]) -> fetch_column();
        if (filter_var($result, FILTER_VALIDATE_INT)) {
            return $result;
        } else {
            return false;
        }
    }

    public static function sumOne(array $data): bool
    {
        if (isset($data['user_id']) && isset($data['medium']) && isset($data['medium_id'])) {
            if (Listing::existsWithId($data['medium'], $data['medium_id'])) {
                if (DB::query('UPDATE '.$data['medium'].'list SET progress = (progress + 1) WHERE user_id = ? and '.$data['medium'].'_id = ?', [$data['user_id'], $data['medium_id']])) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    /**
     * @param int $user_id
     * @return bool
     * Manages if a user wants to automatically create a post once updating an entry of their lists (e.g. "I have watched episode X from X.")
     */
    public static function shares(int $user_id): bool
    {
        $result = DB::query('SELECT user_id FROM user WHERE user_id = ? AND shares = 1', [$user_id]);
        if ($result -> num_rows === 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAnimes(array $animelist): array|null
    {
        if (count($animelist) > 0) {
            for ($i=0; $i<count($animelist); $i++) {

                $anime = [
                    'info' => DB::query('SELECT `anime_id`, `title`, `episodes`, `type`,  `cover` FROM `anime` WHERE `anime_id` = ?', [$animelist[$i]['anime_id']]) -> fetch_assoc(),
                    'score' => $animelist[$i]['score'],
                    'progress' => $animelist[$i]['progress'],
                    'start_date' => $animelist[$i]['start_date'],
                    'end_date' => $animelist[$i]['end_date'],
                    'notes' => $animelist[$i]['notes'],
                    'rewatches' => $animelist[$i]['rewatches'],
                    'favorite' => $animelist[$i]['favorite']
                ];

                // Will be used to divide the lists in sections at /{user}/animelist
                switch($animelist[$i]['status']) {
                    case 'watching':
                        $animes['watching'][] = $anime;
                        break;
                    case 'completed':
                        $animes['completed'][] = $anime;
                        break;
                    case 'planned':
                        $animes['planned'][] = $anime;
                        break;
                    case 'stalled':
                        $animes['stalled'][] = $anime;
                        break;
                    case 'dropped':
                        $animes['dropped'][] = $anime;
                        break;
                }
            }
            return $animes;
        } else {
            return null;
        }
    }

    public static function getMangas(array $mangalist): array|null
    {
        if (count($mangalist) > 0) {
            for ($i=0; $i<count($mangalist); $i++) {

                $manga = [
                    'info' => DB::query('SELECT `manga_id`, `title`, `chapters`, `format`,  `cover` FROM `manga` WHERE `manga_id` = ?', [$mangalist[$i]['manga_id']]) -> fetch_assoc(),
                    'score' => $mangalist[$i]['score'],
                    'progress' => $mangalist[$i]['progress'],
                    'start_date' => $mangalist[$i]['start_date'],
                    'end_date' => $mangalist[$i]['end_date'],
                    'notes' => $mangalist[$i]['notes'],
                    'rewatches' => $mangalist[$i]['rewatches'],
                    'favorite' => $mangalist[$i]['favorite']
                ];

                // Will be used to divide the lists in sections at /{user}/mangalist
                switch($mangalist[$i]['status']) {
                    case 'reading':
                        $mangas['reading'][] = $manga;
                        break;
                    case 'completed':
                        $mangas['completed'][] = $manga;
                        break;
                    case 'planned':
                        $mangas['planned'][] = $manga;
                        break;
                    case 'stalled':
                        $mangas['stalled'][] = $manga;
                        break;
                    case 'dropped':
                        $mangas['dropped'][] = $manga;
                        break;
                }
            }
            return $mangas;
        } else {
            return null;
        }
    }

    /**
     * Devuelve las estadísticas en un array asociativo de 5 campos: completed, watching|reading, planned, stalled, dropped.
     * El segundo campo es variable según el array aportado sea $animelist(en este caso, watching) o mangalist(en este caso, reading).
     */
    public static function getStats(array $list, string $medium): array|null
    {
        switch($medium) {
            case 'anime':
                $currently = 'watching';
                break;
            case 'manga':
                $currently = 'reading';
                break;
            default:
                return null;
        }

        $userStats['completed'] = 0;
        $userStats[$currently] = 0;
        $userStats['planned'] = 0;
        $userStats['stalled'] = 0;
        $userStats['dropped'] = 0;

        if (!empty($list)) {
            for ($i=0; $i<count($list); $i++) {
                switch($list[$i]['status']) {
                    case 'completed':
                        $userStats['completed']++;
                        break;
                    case $currently:
                        $userStats[$currently]++;
                        break;
                    case 'planned':
                        $userStats['planned']++;
                        break;
                    case 'stalled':
                        $userStats['stalled']++;
                        break;
                    case 'dropped':
                        $userStats['dropped']++;
                        break;
                }
            }
        }
        return $userStats ?? null;
    }

    public static function getScoreAvg(array $list): float
    {
        // Cálculo de la media de puntuaciones que el usuario ha dado a los elementos de su lista
        $sum = 0;
        $total = 0;
        foreach ($list as $listEntry) {
            $sum += $listEntry['score'];
            // Las puntuaciones pueden no ser asignadas, por lo que no count($animelist|mangalist) puede no ser correcto para una media.
            if (isset($listEntry['score'])) {
                $total++;
            }
        }

        return $sum === 0 ? 0 : round(($sum / $total), 2);
    }

    /**
     * @param int $user_id
     * @return array|null
     * Devuelve la información necesaria para mostrar en /usuario/reviews (/resources/views/user/_reviewsprofile.view.php).
     */
    public static function getReviews(int $user_id): array|null
    {
        $result = DB::query('SELECT * FROM `review` WHERE user_id = ? ORDER BY `date` DESC', [$user_id]);
        if ($result -> num_rows > 0) {
            for ($i = 0; $i < $result -> num_rows; $i++) {

                $row = $result -> fetch_assoc();

                // Asignación de las columnas de `review` al array $userReviews.
                $userReviews[$i]['review_id'] = $row['review_id'];
                $userReviews[$i]['title'] = $row['title'];
                $userReviews[$i]['user_id'] = $row['user_id'];

                // Si la review actual pertenece a un anime, $entryAnime devolverá un valor, si no, lo hará $entryManga.
                // Se devuelve el medio (anime|manga) y el ID, lo cual necesito para crear los siguientes links: /anime|manga/Nombre-De-Entrada.
                $entryAnime = DB::query('SELECT `anime_id` FROM `review_anime` WHERE review_id = ?', [$userReviews[$i]['review_id']]);
                if ($entryAnime -> num_rows === 0) {
                    $medium = 'anime';
                    $medium_id = $entryAnime -> fetch_column();
                } else {
                    $entryManga = DB::query('SELECT `manga_id` FROM `review_manga` WHERE review_id = ?', [$userReviews[$i]['review_id']]);
                    if ($entryManga -> num_rows === 0) {
                        $medium = 'manga';
                        $medium_id = $entryManga -> fetch_column();
                    }
                }

                // Recojo el título de la entrada correspondiente $medium_id y asigno los valores que necesito dentro de $userReviews.
                $mediumEntry = DB::query('SELECT title FROM '.$medium.' WHERE '.$medium.'_id = ?', [$medium_id]);
                if ($mediumEntry -> num_rows === 1) {
                    $userReviews[$i]['entry'] = $mediumEntry -> fetch_assoc()['title'];
                    $userReviews[$i]['medium'] = $medium;
                }

            }
            return $userReviews;
        } else {
            return null;
        }
    }

    public static function getFavorites(int $user_id, string $medium): object|null
    {
        $result = DB::query('select '.$medium.'.'.$medium.'_id, '.$medium.'.title, '.$medium.'.cover from '.$medium.','.$medium.'list
        where '.$medium.'.'.$medium.'_id='.$medium.'list.'.$medium.'_id
        and '.$medium.'list.favorite=true and user_id= ?', [$user_id]);

        if ($result -> num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    }

    /**
     * @return array|null
     * @param int $user_id
     * Devuelve los posts a mostrar en la página de perfil, por lo que solo devuelve los posts de un único usuario (así como su nombre de usuario y foto de perfil).
     */
    public static function getPosts(int $user_id): array|null
    {
        $result = DB::query('SELECT * FROM post WHERE user_id = ? ORDER BY `date` DESC', [$user_id]);
        if ($result -> num_rows > 0) {
            for($i = 0; $i < $result -> num_rows; $i++) {
                $row = $result -> fetch_assoc();
                foreach($row as $key => $value) {
                    if ($key === 'date') {
                        // Recogida de las fechas para crear el tiempo que ha pasado desde la creación de cada post mediante mi función timeAgo().
                        $current = date('Y-m-d H:i:s');
                        $reference = $value;
                        $timeAgo = timeAgo($current, $reference);
                        $posts[$i]['time_ago'] = $timeAgo;
                        $posts[$i]['date'] = $value;
                    } else {
                        $posts[$i][$key] = $value;
                    }
                }

                // Cálculo del número de respuestas y likes asociados a un post.
                $posts[$i]['reply_count'] = DB::query('SELECT count(reply_id) FROM `post_reply` WHERE post_id = ?;', [$posts[$i]['post_id']]) -> fetch_column();
                $posts[$i]['like_count'] = DB::query('SELECT count(user_id) FROM `post_like` WHERE post_id = ?;', [$posts[$i]['post_id']]) -> fetch_column();
                $posts[$i]['bookmark_count'] = DB::query('SELECT count(user_id) FROM `bookmark` WHERE post_id = ?;', [$posts[$i]['post_id']]) -> fetch_column();

                $animeId = DB::query('SELECT anime_id FROM `post_anime` WHERE post_id = ?', [$posts[$i]['post_id']]);
                if ($animeId -> num_rows === 1) {
                    $posts[$i]['medium'] = 'anime';
                    $posts[$i]['medium_id'] = $animeId -> fetch_column();
                    $posts[$i]['medium_title'] = DB::query('SELECT title FROM anime WHERE anime_id = ?', [$posts[$i]['medium_id']]) -> fetch_column();
                } else {
                    $mangaId = DB::query('SELECT manga_id FROM `post_manga` WHERE post_id = ?', [$posts[$i]['post_id']]);
                    if ($mangaId -> num_rows === 1) {
                        $posts[$i]['medium'] = 'manga';
                        $posts[$i]['medium_id'] = $mangaId -> fetch_column();
                        $posts[$i]['medium_title'] = DB::query('SELECT title FROM manga WHERE manga_id = ?', [$posts[$i]['medium_id']]) -> fetch_column();
                    }
                }

                $original = DB::query('SELECT post_id FROM `post_reply` WHERE reply_id = ?', [$posts[$i]['post_id']]);
                if ($original -> num_rows === 1) {
                    $mainPost = $original -> fetch_column();
                    $userId = DB::query('select user_id from post where post_id = ?', [$mainPost]) -> fetch_column();
                    $posts[$i]['replying_to'] = self::getUsername($userId);
                }

                if (DB::query('SELECT user_id FROM post_like WHERE post_id = ? AND user_id = ?', [$posts[$i]['post_id'], $_COOKIE['user_id']]) -> num_rows === 1) {
                    $posts[$i]['liked'] = true;
                } else {
                    $posts[$i]['liked'] = false;
                }

                if (DB::query('SELECT user_id FROM bookmark WHERE post_id = ? AND user_id = ?', [$posts[$i]['post_id'], $_COOKIE['user_id']]) -> num_rows === 1) {
                    $posts[$i]['bookmarked'] = true;
                } else {
                    $posts[$i]['bookmarked'] = false;
                }

            }

            $postsInfo['posts'] = $posts;

            if ($userInfo = self::getInfoLess($user_id)) {
                foreach ($userInfo as $key => $value) {
                    $postsInfo['user'][$key] = $value;
                }
            }

            return $postsInfo;
        } else {
            return null;
        }
    }

    public static function getPostCount(int $userId): int|null
    {
        return DB::query('SELECT count(post_id) FROM post WHERE user_id = ?', [$userId]) -> fetch_column();
    }

    public static function getFollowCount(int $userId): array|null
    {
        $followCount['followers'] = DB::query('SELECT count(followed_user) FROM follow WHERE followed_user = ?', [$userId]) -> fetch_column();
        $followCount['following'] = DB::query('SELECT count(following_user) FROM follow WHERE following_user = ?', [$userId]) -> fetch_column();

        return $followCount;
    }

    /**
     * @return bool
     * @param string $type
     * @param int $userId
     * Este método comprueba que la ruta de un usuario en la DB corresponde a un archivo existente en el sistema de archivos.
     * Si esto ocurre lo elimina para, automáticamente, reemplazarlo mediante editProfile(). Esto sirve para no almacenar archivos no utilizados.
     */
    public static function deleteImg(string $type, int $userId) {
        $currentImg = DB::query('SELECT '.$type.' FROM user WHERE user_id = ?', [$userId]) -> fetch_column();
        if (isset($currentImg) && is_writable(DIR  . $currentImg)) {
            if ($currentImg !== '/storage/sys/default.webp') {
                if (unlink(DIR . $currentImg)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else if (is_null($currentImg)) {
            return true;
        } else {
            return true;
        }
    }

    public static function editProfile(array $data, int $userId): bool
    {
        $data['user_id'] = $userId;

        if (isset($data['pfp'])) {
            if (User::deleteImg('pfp', $data['user_id'])) {
                if (!DB::query('UPDATE user SET pfp = ? WHERE `user_id` = ?', [$data['pfp'], $data['user_id']])) {
                    return false;
                }
            } else {
                return false;
            }
        }

        if (isset($data['header'])) {
            if (User::deleteImg('header', $data['user_id'])) {
                if (!DB::query('UPDATE user SET header = ? WHERE `user_id` = ?', [$data['header'], $data['user_id']])) {
                    return false;
                }
            } else {
                return false;
            }
        }

        if (DB::query('UPDATE user SET 
            `biography` = ?,
            `country` = ?,
            `born` = ?,
            `twitter` = ?,
            `github` = ?,
            `discord` = ?,
            `website` = ? WHERE user_id = ?', [$data['biography'], $data['country'], $data['birthday'], $data['twitter'], $data['github'], $data['discord'], $data['website'], $data['user_id']])) {
            
            return true;
        } else {
            return false;
        }
    }

}