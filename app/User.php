<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'Database.php';
require_once 'Listing.php';

class User
{

    private object $con;
    private object $listing;

    public function __construct()
    {
        $this -> con = new Database;
        $this -> listing = new Listing;
    }

    public function register(array $registerInfo): string
    {
        // Inspección de que los nombres de campo del formulario HTML no han sido modificados en las herramientas de navegador.
        $fields = ['username', 'email', 'password', 'confirm', 'register'];
        foreach ($_POST as $key => $value) {
            if (!in_array($key, $fields)) {
                return 'Please fill up the missing fields.';
            }
        }

        // Inspección de los datos introducidos.
        if (isset($registerInfo['username'], $registerInfo['email'], $registerInfo['password'], $registerInfo['confirm'])) {
            if (!(empty($registerInfo['username']) || empty($registerInfo['email']) || empty($registerInfo['password']) || empty($registerInfo['confirm']))) {
                if (filter_var($registerInfo['email'], FILTER_VALIDATE_EMAIL)) {
                    if (preg_match('/^[a-zA-Z0-9]+$/', $registerInfo['username']) === 1) {
                        if (strlen($registerInfo['username']) >= 3 && strlen($registerInfo['username']) <= 16) {
                            if ($registerInfo['password'] === $registerInfo['confirm']) {
                                $result = $this -> con -> db -> execute_query('SELECT user_id FROM user WHERE username = ?', [$registerInfo['username']]);
                                if ($result -> num_rows === 0) {
                                    $result = $this -> con -> db -> execute_query('SELECT user_id FROM user WHERE email = ?', [$registerInfo['email']]);
                                    if ($result -> num_rows === 0) {
                                        $password = password_hash($registerInfo['password'], PASSWORD_DEFAULT);
                                        $this -> con -> db -> execute_query('INSERT INTO `user` (`username`, `password`, `email`) VALUES (?, ?, ?)', [
                                            $registerInfo['username'],
                                            $password,
                                            $registerInfo['email'],
                                        ]);
                                        $result = $this -> con -> db -> execute_query('SELECT user_id FROM user WHERE username = ?', [$registerInfo['username']]);
                                        $user_id = $result -> fetch_column();
                                        setcookie('username', $registerInfo['username'], strtotime('NOW+60DAYS'));
                                        setcookie('user_id', $user_id, strtotime('NOW+60DAYS'));
                                        setcookie('passwd', $password, strtotime('NOW+60DAYS'));
                                        setcookie('session', "Yes", strtotime('NOW+60DAYS'));
                                        return 'Ok';
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

    public function login(array $loginInfo): string
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
                        $result = $this -> con -> db -> execute_query('SELECT `user_id` FROM user WHERE username = ?', [$loginInfo['username']]);
                        if ($result -> num_rows === 1) {
                            $user_id = $result -> fetch_column();
                            $result = $this -> con -> db -> execute_query('SELECT username FROM user WHERE user_id = ?', [$user_id]);
                            $username = $result -> fetch_column();
                            // Comprobación de la contraseña. Si coincide se autenticará al usuario.
                            $result = $this -> con -> db -> execute_query('SELECT `password` FROM user WHERE username = ?', [$loginInfo['username']]);
                            $password = $result -> fetch_column();
                            if (password_verify($loginInfo['password'], $password)) {
                                // Todas las verificaciones han sido exitosas, por lo que se inicia una sesión al usuario autenticado.
                                setcookie('username', $username, strtotime('NOW+60DAYS'));
                                setcookie('user_id', $user_id, strtotime('NOW+60DAYS'));
                                setcookie('passwd', $password, strtotime('NOW+60DAYS'));
                                setcookie('session', "Yes", strtotime('NOW+60DAYS'));
                                return 'Ok';
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
    public function validateSession(): bool
    {
        if (isset($_COOKIE['username'], $_COOKIE['passwd'], $_COOKIE['user_id'])) {
            $result = $this -> con -> db -> execute_query('SELECT `user_id` FROM `user` WHERE username = ?', [$_COOKIE['username']]);
            if ($result -> num_rows === 1) {
                $id = $result -> fetch_column();
                if ($id == $_COOKIE['user_id']) {
                    $passwd = $this -> con -> db -> execute_query('SELECT `password` FROM `user` WHERE `user_id` = ?', [$_COOKIE['user_id']]) -> fetch_column();
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

    public function getUserID(string $username): int|null
    {
        $result = $this -> con -> db -> execute_query('SELECT `user_id` FROM `user` WHERE username = ?', [$username]);
        if ($result -> num_rows === 1) {
            return $user_id = $result -> fetch_column();
        } else {
            return null;
        }
    }

    public function getUsername(int $user_id): string|null
    {
        $result = $this -> con -> db -> execute_query('SELECT `username` FROM `user` WHERE user_id = ?', [$user_id]);
        if ($result -> num_rows === 1) {
            return $result -> fetch_column();
        } else {
            return null;
        }
    }

    public function getInfo(int $user_id): array
    {
        $result = $this -> con -> db -> execute_query('SELECT `username`, `joined_at`, `country`, `biography`, `pfp`, `header`, `github`, `twitter` FROM user WHERE user_id = ?', [$user_id]);
        return $result -> fetch_assoc();
    }

    public function getInfoLess(int $user_id): array
    {
        $result = $this -> con -> db -> execute_query('SELECT `username`,`pfp` FROM user WHERE user_id = ?', [$user_id]);
        return $result -> fetch_assoc();
    }

    public function getList(string $medium, int $user_id): array
    {
        $result = $this -> con -> db -> execute_query('SELECT * FROM `'.$medium.'list` WHERE `user_id` = ?', [$user_id]);
        if ($result -> num_rows > 0) {
            $i = 0; // Esto es simplemente un contador que uso para no necesitar un for dentro del foreach.
            while ($row = $result -> fetch_assoc()) {
                foreach($row as $key => $value) {
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
                $i++;
            }
            return $list;
        } else {
            return $list = [];
        }
    }

    public function getListEntry(string $medium, int $medium_id, int $user_id): array
    {
        $result = $this -> con -> db -> execute_query('SELECT * FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]);
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
    public function addToList($medium, $medium_id, $user_id, string $entry)
    {
        foreach ($_POST as $key => $value) {
            if ($key !== 'add') {
                exit(header('Location: /'.$medium.'/' . $entry));
            }
        }

        if (isset($_POST['add'])) {
            $result = $this -> con -> db -> execute_query('SELECT count(`user_id`) FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]);
            $column = $result -> fetch_column();
            if ($column === 0) {
                $this -> con -> db -> execute_query('INSERT INTO `'.$medium.'list` (`user_id`, `'.$medium.'_id`, `progress`) VALUES (?, ?, default)', [$user_id, $medium_id]);
            }
            header('Location: /'.$medium.'/' . $entry);
        }
    }

    public function deleteFromList(string $medium, int $medium_id, int $user_id, string $entry)
    {
        foreach ($_POST as $key => $value) {
            if ($key !== 'delete') {
                exit(header('Location: /'.$medium.'/' . $entry));
            }
        }

        if (isset($_POST['delete'])) {
            $result = $this -> con -> db -> execute_query('SELECT count(`user_id`) FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]);
            $column = $result -> fetch_column();
            if ($column === 1) {
                $this -> con -> db -> execute_query('DELETE FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]);
            }
            header('Location: /'.$medium.'/' . $entry);
        }
    }

    public function favourite(string $medium, int $medium_id, int $user_id, string $entry)
    {
        foreach ($_POST as $key => $value) {
            if ($key !== 'favourite') {
                exit(header('Location: /'.$medium.'/' . $entry));
            }
        }

        if (isset($_POST['favourite'])) {
            $result = $this -> con -> db -> execute_query('SELECT count(`user_id`) FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ? AND favorite = true', [$user_id, $medium_id]);
            $column = $result -> fetch_column();
            if ($column === 0) {
                $this -> con -> db -> execute_query('UPDATE '.$medium.'list SET `favorite` = true WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]);
            }
            header('Location: /'.$medium.'/' . $entry);
        }
    }

    public function unfavourite(string $medium, int $medium_id, int $user_id, string $entry)
    {
        foreach ($_POST as $key => $value) {
            if ($key !== 'unfavourite') {
                exit(header('Location: /'.$medium.'/' . $entry));
            }
        }

        if (isset($_POST['unfavourite'])) {
            $result = $this -> con -> db -> execute_query('SELECT count(`user_id`) FROM `'.$medium.'list` WHERE `user_id` = ? AND `'.$medium.'_id` = ? AND favorite = false', [$user_id, $medium_id]);
            $column = $result -> fetch_column();
            if ($column === 0) {
                $this -> con -> db -> execute_query('UPDATE '.$medium.'list SET `favorite` = false WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [$user_id, $medium_id]);
            }
            header('Location: /'.$medium.'/' . $entry);
        }
    }

    // $counter is the number of episodes|chapters.
    public function editListEntry(string $medium, int $medium_id, int $user_id, string $entry, int $counter)
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

        $this -> con -> db -> execute_query('UPDATE '.$medium.'list SET status = ?, score = ?, progress = ?, start_date = ?, end_date = ?, rewatches = ?, notes = ? WHERE `user_id` = ? AND `'.$medium.'_id` = ?', [
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

    public function getEpisodesOrChapters(string $medium, int $medium_id, int $user_id): int|false
    {
        $medium === 'anime' ? $current = 'episodes' : $current = 'chapters';
        $result = $this -> con -> db -> execute_query('SELECT progress FROM '.$medium.'list WHERE '.$medium.'_id = ? AND user_id = ?', [$medium_id, $user_id]) -> fetch_column();
        if (is_numeric($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function sumOne(array $data): bool
    {
        if (isset($data['user_id']) && isset($data['medium']) && isset($data['medium_id'])) {
            if ($this -> listing -> existsWithId($data['medium'], $data['medium_id'])) {
                if ($this -> con -> db -> execute_query('UPDATE '.$data['medium'].'list SET progress = (progress + 1) WHERE user_id = ? and '.$data['medium'].'_id = ?', [$data['user_id'], $data['medium_id']])) {
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

    public function shares(int $user_id): bool
    {
        $result = $this -> con -> db -> execute_query('SELECT user_id FROM user WHERE user_id = ? AND shares = 1', [$user_id]);
        if ($result -> num_rows === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getAnimes(array $animelist): array
    {
        if (count($animelist) > 0) {
            for ($i=0; $i<count($animelist); $i++) {
                $anime = $this -> con -> db -> execute_query('SELECT `anime_id`, `title`, `episodes`, `type`,  `cover` FROM `anime` WHERE `anime_id` = ?', [$animelist[$i]['anime_id']]) -> fetch_assoc();
                $anime['score'] = $animelist[$i]['score'];
                $anime['status'] = $animelist[$i]['status'];
                $anime['progress'] = $animelist[$i]['progress'];
                $anime['start_date'] = $animelist[$i]['start_date'];
                $anime['end_date'] = $animelist[$i]['end_date'];
                $anime['notes'] = $animelist[$i]['notes'];
                $anime['rewatches'] = $animelist[$i]['rewatches'];
                $anime['favorite'] = $animelist[$i]['favorite'];
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
            return $animes = [];
        }
    }

    public function getMangas(array $mangalist): array
    {
        if (count($mangalist) > 0) {
            for ($i=0; $i<count($mangalist); $i++) {
                $manga = $this -> con -> db -> execute_query('SELECT `manga_id`, `title`, `chapters`, `format`,  `cover` FROM `manga` WHERE `manga_id` = ?', [$mangalist[$i]['manga_id']]) -> fetch_assoc();
                $manga['score'] = $mangalist[$i]['score'];
                $manga['progress'] = $mangalist[$i]['progress'];
                $manga['notes'] = $mangalist[$i]['notes'];
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
            return $mangas = [];
        }
    }

    /**
     * Devuelve las estadísticas en un array asociativo de 5 campos: completed, watching|reading, planned, stalled, dropped.
     * El segundo campo es variable según el array aportado sea $animelist(en este caso, watching) o mangalist(en este caso, reading).
     */
    public function getStats(array $list, string $medium): array|null
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
        return $userStats;
    }

    public function getScoreAvg(array $list): float
    {
        // Cálculo de la media de puntuaciones que el usuario ha dado a los elementos de su lista
        $sum = 0;
        $total = 0;
        foreach ($list as $listEntry) {
            $sum += $listEntry['score'];
            // Las puntuaciones pueden no ser asignadas, por lo que no count($animelist|mangalist) puede no ser correcto para una media.
            if ($listEntry['score'] !== null) {
                $total++;
            }
        }
        
        if ($sum === 0) {
            return $scoreAvg = 0;
        } else {
            return $scoreAvg = round(($sum / $total), 2);
        } 
    }

    /**
     * @param int $user_id
     * @return array|null
     * Devuelve la información necesaria para mostrar en /usuario/reviews (/resources/views/user/_reviewsprofile.view.php).
     */
    public function getReviews(int $user_id): array|null
    {
        $result = $this -> con -> db -> execute_query('SELECT * FROM `review` WHERE user_id = ? ORDER BY `date` DESC', [$user_id]);
        if ($result -> num_rows > 0) {
            for ($i = 0; $i < $result -> num_rows; $i++) {

                $row = $result -> fetch_assoc();

                // Asignación de las columnas de `review` al array $userReviews.
                $userReviews[$i]['review_id'] = $row['review_id'];
                $userReviews[$i]['title'] = $row['title'];
                $userReviews[$i]['user_id'] = $row['user_id'];

                // Si la review actual pertenece a un anime, $entryAnime devolverá un valor, si no, lo hará $entryManga.
                // Se devuelve el medio (anime|manga) y el ID, lo cual necesito para crear los siguientes links: /anime|manga/Nombre-De-Entrada.
                $entryAnime = $this -> con -> db -> execute_query('SELECT `anime_id` FROM `review_anime` WHERE review_id = ?', [$userReviews[$i]['review_id']]);
                $entryManga = $this -> con -> db -> execute_query('SELECT `manga_id` FROM `review_manga` WHERE review_id = ?', [$userReviews[$i]['review_id']]);
                if ($entryAnime -> num_rows === 0) {
                    $medium = 'anime';
                    $medium_id = $entryAnime -> fetch_column();
                } else if ($entryManga -> num_rows === 0) {
                    $medium = 'manga';
                    $medium_id = $entryManga -> fetch_column();
                }

                // Recojo el título de la entrada correspondiente $medium_id y asigno los valores que necesito dentro de $userReviews.
                $mediumEntry = $this -> con -> db -> execute_query('SELECT title FROM '.$medium.' WHERE '.$medium.'_id = ?', [$medium_id]);
                if ($mediumEntry -> num_rows === 1) {
                    $row = $mediumEntry -> fetch_assoc();
                    $userReviews[$i]['entry'] = $row['title'];
                    $userReviews[$i]['medium'] = $medium;
                }
                
            }
            return $userReviews;
        } else {
            return null;
        }
    }

    public function getFavorites(int $user_id, string $medium): object|null
    {
        $result = $this -> con -> db -> execute_query('select '.$medium.'.'.$medium.'_id, '.$medium.'.title, '.$medium.'.cover from '.$medium.','.$medium.'list
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
    public function getPosts(int $user_id): array|null
    {
        $result = $this -> con -> db -> execute_query('SELECT * FROM post WHERE user_id = ? ORDER BY `date` DESC', [$user_id]);
        if ($result -> num_rows > 0) {
            for($i = 0; $i < $result -> num_rows; $i++) {
                $row = $result -> fetch_assoc();
                foreach($row as $key => $value) {
                    if ($key === 'date') {
                        // Recogida de las fechas para crear el tiempo que ha pasado desde la creación de cada post mediante mi función timeAgo().
                        $posts[$i]['date'] = $value;
                        $current = date('Y-m-d H:i:s');
                        $reference = $posts[$i]['date'];
                        $timeAgo = timeAgo($current, $reference);
                        $posts[$i]['time_ago'] = $timeAgo;
                    } else {
                        $posts[$i][$key] = $value;
                    }
                }

            }

            if ($userInfo = $this -> getInfoLess($user_id)) {
                foreach ($userInfo as $key => $value) {
                    $postsInfo['user'][$key] = $value;
                }
               
            }

            $postsInfo['posts'] = $posts;
            return $postsInfo;
        } else {
            return null;
        }
    }

}