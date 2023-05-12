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

                ?>

                <section class="profile_user-overview_favorites_medium box-wrapper">
                    <div class="box-title"><h3>Favourite anime</h3></div>
                    <div class="profile_user-overview_favorites_wrapper querypage_bg">

                        <?php
                        
                        if (isset($favoriteAnimes)) {
                            if ($favoriteAnimes -> num_rows > 0) {
                                while ($row = $favoriteAnimes -> fetch_assoc()) {
                                    ?><a href="/anime/<?=str_replace(' ', '-', $row['title'])?>"><div style="background-image: url(<?=$row['cover']?>)"></div></a><?php
                                }
                            }
                        }

                        ?>

                    </div>
                </section>

                <section class="profile_user-overview_favorites_medium box-wrapper">
                    <div class="box-title"><h3>Favourite manga</h3></div>
                    <div class="profile_user-overview_favorites_wrapper querypage_bg">

                        <?php
                        if (isset($favoriteMangas)) {

                            if ($favoriteMangas -> num_rows > 0) {
                                while ($row = $favoriteMangas -> fetch_assoc()) {
                                    ?><a href="/manga/<?=str_replace(' ', '-', $row['title'])?>?>"><div style="background-image: url(<?=$row['cover']?>)"></div></a><?php
                                }
                            }

                        }

                        ?>

                    </div>
                </section>

                <?php


            ?>

        </section>

        <?php
    }

    if (isset($userPosts)) {
    ?>
    <section class="posts-wrapper box-wrapper">
        <div class="box-title">
            <h3>Activity</h3>
        </div>
        <div class="box-body">
            <?php

            for($i= 0; $i < count($userPosts['posts']); $i++) {
                
                ?>
                
                <div class="post-entry box-wrapper box-body" onclick="window.location='/activity/<?=$userPosts['posts'][$i]['post_id']?>'">
                    <div class="top">
                        <img src="<?=$userPosts['user']['pfp']?>" alt="">
                        <div class="post-info">
                            <div class="post-info_user">
                                <div class="username">
                                    <div><span><?=$userPosts['user']['username']?></span><span class="post_time-ago">&nbsp;&nbsp;·&nbsp;&nbsp;<?=$userPosts['posts'][$i]['time_ago']?></span></div>
                                    <div class="display-settings">
                                        <div class="post-settings" id="post_settings">
                                            <ul>
                                                <a href="/delete?id=<?=$userPosts['posts'][$i]['post_id']?>"><li>Delete</li></a>
                                            </ul>
                                        </div>
                                        <span class="material-icons dots" id="display_settings">more_horiz</span>
                                    </div>
                                </div>
                            </div>
                            <div class="post-info_relation">
                                <?php
                                
                                if (isset($userPosts['posts'][$i]['replying_to']) && isset($userPosts['posts'][$i]['medium_id'])) {
                                    ?><span class="low-opacity">replying to <?=$userPosts['posts'][$i]['replying_to']?> on <?=$userPosts['posts'][$i]['medium_title']?></span><?php
                                } else if (isset($userPosts['posts'][$i]['replying_to'])) {
                                ?><span class="low-opacity">replying to <?=$userPosts['posts'][$i]['replying_to']?></span><?php
                                } else if (isset($userPosts['posts'][$i]['medium_id'])) {
                                    ?><span class="low-opacity">on <?=$userPosts['posts'][$i]['medium_title']?></span><?php
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="content"><?=htmlspecialchars($userPosts['posts'][$i]['content'])?></div>
                        <div class="social">
                            <div class="social-icon">
                                <span class="material-icons-outlined" id="display-reply">chat_bubble_outline</span>
                                <p><?=$userPosts['posts'][$i]['reply_count']?></p>
                            </div>
                            <div class="social-icon">
                            <span class="material-icons-outlined">
                                <?php if (isset($userPosts['posts'][$i]['liked']) && $userPosts['posts'][$i]['liked']) {echo "favorite";} else {echo "favorite_border";} ?>
                            </span>
                                <p><?=$userPosts['posts'][$i]['like_count']?></p>
                            </div>
                            
                            <div class="social-icon">
                                <span class="material-icons-outlined">
                                    <?php if (isset($userPosts['posts'][$i]['bookmarked']) && $userPosts['posts'][$i]['bookmarked']) {echo "bookmark";} else {echo "bookmark_border";} ?>
                                </span>
                                <p><?=$userPosts['posts'][$i]['bookmark_count']?></p>
                            </div>
                        </div>
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