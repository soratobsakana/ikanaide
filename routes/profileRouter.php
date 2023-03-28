<?php
require_once('app/User.php');
$Session = new User;

$username = substr($uri, 1);

$profileRoutes = [
    '/'.$username => 'controllers/profile.php',
    '/'.$username.'/animelist' => 'controllers/profile.php',
    '/'.$username.'/mangalist' => 'controllers/profile.php',
    '/'.$username.'/reviews' => 'controllers/profile.php',
    '/'.$username.'/favorites' => 'controllers/profile.php'
];

if (array_key_exists($uri, $profileRoutes)) {
    require $profileRoutes[$uri];
} else {
    exit(header('Location: /404'));
}