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


</section>