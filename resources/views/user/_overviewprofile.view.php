<section class="profile_user-overview">
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

        <section class="profile_user-overview_favorites">
            <?php

            if (isset($favoriteAnimes)){
                ?>

                <section class="profile_user-overview_favorites_medium box-wrapper">
                    <div class="box-title"><h3>Favourite anime</h3></div>
                    <div class="profile_user-overview_favorites_wrapper querypage_bg">

                        <?php
                        if ($favoriteAnimes -> num_rows > 0) {
                            while ($row = $favoriteAnimes -> fetch_assoc()) {
                                ?><a href="/anime/<?=str_replace(' ', '-', $row['title'])?>"><div style="background-image: url(<?=$row['cover']?>)"></div></a><?php
                            }
                        }

                        ?>

                    </div>
                </section>

                <?php
            }

            if (isset($favoriteMangas)){
                ?>

                <section class="profile_user-overview_favorites_medium box-wrapper">
                    <div class="box-title"><h3>Favourite manga</h3></div>
                    <div class="profile_user-overview_favorites_wrapper querypage_bg">

                        <?php

                        if ($favoriteMangas -> num_rows > 0) {
                            while ($row = $favoriteMangas -> fetch_assoc()) {
                                ?><a href="/manga/<?=str_replace(' ', '-', $row['title'])?>?>"><div style="background-image: url(<?=$row['cover']?>)"></div></a><?php
                            }
                        }

                        ?>

                    </div>
                </section>

                <?php
            }

            ?>

        </section>

        <?php
    }

    if (isset($userPosts)) {
    ?>
    <section class="profile_user-overview_posts-wrapper box-wrapper">
        <div class="box-title">
            <h3>Activity</h3>
        </div>
        <div class="box-body">
            <?php

            for($i= 0; $i < count($userPosts['posts']); $i++) {
                ?>

                <div class="post-entry box-wrapper box-body">
                    <div class="top">
                        <img src="<?=$userPosts['user']['pfp']?>" alt="">
                        <div class="username">
                            <div><span><?=$userPosts['user']['username']?></span><span class="post_time-ago">&nbsp;&nbsp;·&nbsp;&nbsp;<?=$userPosts['posts'][$i]['time_ago']?></span></div>
                            <div><span class="material-icons dots">more_horiz</span></div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="content"><?=htmlspecialchars($userPosts['posts'][$i]['content'])?></div>
                    </div>
                </div>

                <?php
            }

            ?>
        </div>
    </section>
    <?php
    }
    ?>

</section>