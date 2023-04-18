<section class="profile_user-overview">
    <section class="profile_user-overview_stats">
        <div class="profile_user-overview_stats-medium box-wrapper">
            <div class="box-title">
                <h3>Anime</h3>
            </div>
            <div class="box-body">
                <div class="completed"><div><?=$animeStats['completed']?></div><div class="low-opacity">completed</div></div>
                <div class="watching"><div><?=$animeStats['watching']?></div><div class="low-opacity">watching</div></div>
                <div class="score"><div><?=$animeScoreAvg?></div><div class="low-opacity">score</div></div>
            </div>
        </div>
        <div class="profile_user-overview_stats-medium box-wrapper">
            <div class="box-title">
                <h3>Manga</h3>
            </div>
            <div class="box-body">
                <div class="completed"><div><?=$mangaStats['completed']?></div><div class="low-opacity">completed</div></div>
                <div class="reading"><div><?=$mangaStats['reading']?></div><div class="low-opacity">reading</div></div>
                <div class="score"><div><?=$mangaScoreAvg?></div><div class="low-opacity">score</div></div>
            </div>
        </div>
    </section>

    <?php

    if (!empty($userInfo['biography'])) {
        ?>

        <section class="profile_user-overview_bio box-wrapper">
            <div class="box-title">
                <h3>About me</h3>
            </div>
            <div class="box-body">
                <p><?=$userInfo['biography']?></p>
            </div>
        </section>

        <?php
    }

    ?>
    <section class="profile_user-overview_posts-wrapper box-wrapper">
        <div class="box-title">
            <h3>Activity</h3>
        </div>
        <div class="box-body">
            <?php

            if (isset($userPosts)) {
                for($i= 0; $i < count($userPosts['posts']); $i++) {

                    // Recogida de las fechas para crear el tiempo que ha pasado desde la creación de cada post mediante mi función timeAgo().
                    $current = date('Y-m-d h:i:s');
                    $reference = $userPosts['posts'][$i]['date'];
                    $timeAgo = timeAgo($current, $reference);

                    ?>

                    <div class="post-entry box-wrapper box-body">
                        <div class="top">
                            <img src="<?=$userPosts['user']['pfp']?>" alt="">
                            <div class="username">
                                <div><span><?=$userPosts['user']['username']?></span><span class="post_time-ago">&nbsp;&nbsp;·&nbsp;&nbsp;<?=$timeAgo?></span></div>
                                <div><span class="material-icons dots">more_horiz</span></div>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="content"><?=htmlspecialchars($userPosts['posts'][$i]['content'])?></div>
                        </div>
                    </div>
                    <?php

                }
            }

            ?>
        </div>
    </section>

    


</section>