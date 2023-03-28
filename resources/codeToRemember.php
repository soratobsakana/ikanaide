<?php

// SELECT through parameters.
$animeTitle = "Gintama"; // This would be $_POST[]

$stmt = $db -> prepare("SELECT * FROM animes_test WHERE title = ?");
$stmt -> bind_param('ss', $animeTitle);
$stmt -> execute();
// get_result() no funciona con $stmt porque pertenece a la clase mysqli_result y no a mysqli_stmt.
$result = $stmt -> get_result();

if ($result -> num_rows > 0) {
    while ($row = $result -> fetch_assoc()) {
        $animeTitle = $row['title'];
    }
}


// Shorten an if statement
if ($something === 'something') {
    echo 'first';
} else {
    echo 'second';
}
// is the same as...
echo $something === 'something' ? 'first' : 'second';

// This will print HTML or JS just plain text, and not format anything or display alerts, etc.
// htmlspecialchars($string);

// unset cookies https://stackoverflow.com/questions/2310558/how-to-delete-all-cookies-of-my-website-in-php
if (isset($_COOKIES)) {
    foreach ($_COOKIES as $key => $value) {
        setcookie($key, '', time()-1000);
        setcookie($key, '', time()-1000, '/');
    }
}

// Returns the number of columns from a SQL table
// SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = 'submit_manga';

// Calculates and prints execute time of a script.
$time_start = microtime(true);
$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo '<b>Total Execution Time:</b> '.$execution_time.' seconds';


switch ($username) {
    case $username:
    case $username.'/overview':
        require('resources/views/user/profile.view.php');
        break;
    case $username.'/animelist':
        require('resources/views/user/_animelistprofile.view.php');
        break;
    case $username.'/mangalist':
        require('resources/views/user/_mangalistprofile.view.php');
        break;
    case $username.'/reviews':
        require('resources/views/user/_reviewsprofile.view.php');
        break;
    case $username.'/favorites':
        require('resources/views/user/_favoritesprofile.view.php');
        break;
    default:
        exit(header("Location: /404"));
    }

    $profileRoutes = [
        '/'.$username => 'resources/views/user/profile.view.php',
        '/'.$username.'/animelist' => 'resources/views/user/_animelistprofile.php',
        '/'.$username.'/mangalist' => 'resources/views/user/_mangalistprofile.php',
        '/'.$username.'/reviews' => 'resources/views/user/_reviewsprofile.php',
        '/'.$username.'/favorites' => 'resources/views/user/_favoritesprofile.php'
    ];

    if (array_key_exists($uri, $profileRoutes)) {
        require $profileRoutes[$uri];
    } else {
        exit(header('Location: /404'));
    }