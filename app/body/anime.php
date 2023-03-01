<?php
require_once('database/conn.php');
require('resources/php/functions.php');

// Queried anime's general information.
$animeTitle = "Gintama";
$user_id = 1;

$stmt = $db -> prepare("SELECT * FROM anime WHERE title = ?");
$stmt -> bind_param('s', $animeTitle);
$stmt -> execute();
// get_result() no funciona con $stmt porque pertenece a la clase mysqli_result y no a mysqli_stmt.
$result = $stmt -> get_result();

if ($result -> num_rows == 1) {
    while ($row = $result -> fetch_assoc()) {
        $anime_id = $row['anime_id'];
        $title = $row['title'];
        $type = $row['type'];
        $episodes = $row['episodes'];
        $status = $row['status'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $season = $row['season'];
        $description = $row['description'];
        $members = $row['members'];
        $favorited = $row['favorited'];
        $cover = $row['cover'];
        $header = $row ['header'];
    }
}

$formattedStartDate = strtolower(dateFormat($start_date));
$formattedEndDate = strtolower(dateFormat($end_date));

$infoBox = array(
        'type' => $type,
        'episodes' => $episodes,
        'status' => $status,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'season' => $season,
        'studios' => "Sunrise"
);

$peopleBox = array(
        'members' => $members,
        'favorited' => $favorited,
);



?>


<section class="left_column">
    <img src="<?=$cover?>" alt="<?=$title?>">
    <!--
    <div class="box animepage_user-list">
        <form action="anime.php" method="POST">
            <select name="userListMgmt" id="userListMgmt">
                <option value="add">add to list</option>
                <option value="planning">planning</option>
                <option value="watching">watching</option>
                <option value="completed">completed</option>
                <option value="watching">watching</option>
            </select>
        </form>
    </div>
    -->
    <div class="animepage_info two-column-list box">
        <ul>
            <li><span class="ul_first-column">type</span><span><?=$infoBox['type']?></span></li>
            <li><span class="ul_first-column">episodes</span><span><?=$infoBox['episodes']?></span></li>
            <li><span class="ul_first-column">status</span><span><?=$infoBox['status']?></span></li>
            <li><span class="ul_first-column">start date</span><span><?=$formattedStartDate?></span></li>
            <li><span class="ul_first-column">end date</span><span><?=$formattedEndDate?></span></li>
            <li><span class="ul_first-column">season</span><span><?=$infoBox['season']?></span></li>
            <li><span class="ul_first-column">studios</span><span><?=$infoBox['studios']?></span></li>
        </ul>
    </div>
    <div class="animepage_people two-column-list box">
        <ul>
            <li><span class="ul_first-column">members</span><span><?=$peopleBox['members']?></span></li>
            <li><span class="ul_first-column">loved</span><span><?=$peopleBox['favorited']?></span></li>
            <li><span class="ul_first-column">ranked</span><span></span></li>
            <li><span class="ul_first-column">popularity</span><span></span></li>
        </ul>
    </div>
    <!-- friend status list -->
    <div class="animepage_edit box">
        <p>edit this website</p>
    </div>
</section>
<section class="right_column">
    <img src="<?=$header?>" alt="<?=$title?>">
    <div class="animepage_title">
        <h1><?=$title?></h1>
    </div>
    <div class="animepage_desc box">
        <?=$description?>
    </div>
    <div class="animepage_char">
        <div class="header">
            <h3>Characters</h3><span class="view-all">view all</span>
        </div>
        <div class="animepage_char-entry_wrapper">
            <?php
            // Información de personajes y asociación.
            $stmt = $db -> prepare("SELECT `character`.*, `character_anime`.role FROM `character`, `character_anime` WHERE `character_anime`.`anime_id` = ? AND `character`.`character_id`=`character_anime`.character_id");
            $stmt -> bind_param('i', $anime_id);
            $stmt -> execute();
            $result = $stmt -> get_result();

            if ($result -> num_rows > 0) {
                while ($row = $result -> fetch_assoc()) {
                    $character_id = $row['character_id'];
                    $family_name = $row['family_name'];
                    $given_name = $row['given_name'];
                    $alias = $row['alias'];
                    $japanese_name = $row['japanese_name'];
                    $role = $row['role'];
                    $picture = $row['picture'];

                    ?>

                    <div class="animepage_char-entry">
                        <div class="animepage_char-entry_pic">
                            <img src="<?=$picture?>" alt="<?=$family_name . ' ' . $given_name?>">
                        </div>
                        <div class="animepage_char-entry_info">
                            <div class="animepage_char-entry_info-name">
                                <?=$family_name . ', ' . $given_name?>
                            </div>
                            <div class="animepage_char-entry_info-role">
                                <?=strtolower($role) . " character"?>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                print "<i style='opacity: var(--font_low-opacity)'>Looks like there are no character entries for this anime...</i>";
            }
            ?>
        </div>
    </div>
    <div class="animepage_staff">
        <div class="header">
            <h3>Staff</h3><span class="view-all">view all</span>
        </div>
        <div class="animepage_staff-entry_wrapper">
            <?php
            // Información de staff y asociación.
            $stmt = $db -> prepare("SELECT `staff`.*, `staff_anime`.`role` FROM `staff`, `staff_anime` WHERE `staff_anime`.`anime_id` = ? AND `staff`.`staff_id`=`staff_anime`.staff_id");
            $stmt -> bind_param('i', $anime_id);
            $stmt -> execute();
            $result = $stmt -> get_result();

            if ($result -> num_rows > 0) {
                while ($row = $result -> fetch_assoc()) {
                    $staff_id = $row['staff_id'];
                    $family_name = $row['family_name'];
                    $given_name = $row['given_name'];
                    $alias = $row['alias'];
                    $japanese_name = $row['japanese_name'];
                    $role = $row['role'];
                    $picture = $row['picture'];

                    ?>

                    <div class="animepage_staff-entry">
                        <div class="animepage_staff-entry_pic">
                            <img src="<?=$picture?>" alt="<?=$family_name . ' ' . $given_name?>">
                        </div>
                        <div class="animepage_staff-entry_info">
                            <div class="animepage_staff-entry_info-name">
                                <?=$family_name . ', ' . $given_name?>
                            </div>
                            <div class="animepage_staff-entry_info-role">
                                <?=strtolower($role)?>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                print "<i style='opacity: var(--font_low-opacity)'>Looks like there are no staff entries for this anime...</i>";
            }
            ?>
        </div>
    </div>
    <div class="animepage_review">
        <div class="header">
            <h3>Reviews</h3><span class="view-all">view all</span>
        </div>
        <div class="animepage_review-entry_wrapper">
            <?php
                // Información de reviews y asociación.
                $stmt = $db -> prepare("SELECT `review`.* FROM `review`, `review_anime` WHERE `review_anime`.`anime_id` = ? AND `review`.review_id = `review_anime`.`review_id`");
                $stmt -> bind_param('i', $anime_id);
                $stmt -> execute();
                $result = $stmt -> get_result();

                if ($result -> num_rows > 0) {
                    while($row = $result -> fetch_assoc()) {
                        $review_id = $row['review_id'];
                        $title = $row['title'];
                        $text = $row['text'];
                        $user_id = $row['user_id'];

                        $stmt = $db -> prepare("SELECT `username` FROM user WHERE user_id = ?");
                        $stmt -> bind_param('i', $user_id);
                        $stmt -> execute();
                        $result = $stmt -> get_result();

                        if ($result -> num_rows == 1) {
                            $row = $result -> fetch_assoc();
                            $username = $row['username'];
                        }

                        ?>

                        <div class="animepage_review-entry">
                            <div class="animepage_review-entry_pic">
                                <img src="<?=$cover?>" alt="<?=$title?>">
                            </div>
                            <div class="animepage_review-entry_info">
                                <div class="animepage_review-entry_info-name">
                                    <?=$title?>
                                </div>
                                <div class="animepage_review-entry_info-role">
                                    <?=strtolower($username)?>
                                </div>
                            </div>
                        </div>

                        <?php

                    }
                } else {
                    print "<i style='opacity: var(--font_low-opacity)'>Looks like there are no review entries for this anime...</i>";
                }

                $db -> close();
            ?>
        </div>
    </div>
</section>