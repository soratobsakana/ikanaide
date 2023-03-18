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