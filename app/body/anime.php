<?php
    include "database/con.php";

    $query = "select * from animes;";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_array($result);

    if (mysqli_num_rows($result) > 0) {

            $title = $row['title'];
            $type = $row['type'];
            $episodes = $row['episodes'];
            $status = $row['status'];
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];
            $season = $row['season'];
            $producers = $row['producers'];
            $score = $row['score'];

    } else {
        echo "We couldn't retrieve any information from this query";
    }

    $query = 'select path from images';
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_array($result);
    $path = $row['path'];

    $anime_info = $mysqli -> prepare('SELECT ? FROM ?;');
    $anime_info -> bind_param('ss', '*', 'animes');
    
?>


<section class="ikanaide-body-left-column">
        <img src="<?=$path?>" alt="">
</section>
<section class="ikanaide-body-right-column box">

</section>