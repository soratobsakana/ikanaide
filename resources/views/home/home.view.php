<div class="home">
    <section class="home_timeline">
        <?php

        if (isset($followingTimeline) || isset($globalTimeline)) {
        ?>
        <section class="posts-wrapper box-wrapper">
            <div class="box-title">
                
                <h3><?= isset($followingTimeline) ? 'Your timeline' : 'Global timeline' ?></h3>
                <a href="/timeline?tl=<?= isset($followingTimeline) ? 'global' : 'default' ?>" class="low_opacity link"><?= isset($followingTimeline) ? 'Show global timeline' : 'Show your timeline' ?></a>
            </div>
            <div class="box-body">

                <?php

                if (isset($followingTimeline)) {
                    foreach ($followingTimeline as $post) {
                        ?>
    
                            <div class="post-entry box-wrapper box-body" onclick="window.location='/activity/<?=$post['post']['post_id']?>'">
                                <div class="top">
                                <a href="/<?=$post['user']['username']?>"><img src="<?=$post['user']['pfp']?>" alt=""></a>
                                    <div class="post-info">
                                        <div class="post-info_user">
                                            <div class="username">
                                                <div><span><?=$post['user']['username']?></span><span class="post_time-ago">&nbsp;&nbsp;·&nbsp;&nbsp;<?=$post['post']['time_ago']?></span></div>
                                                <div><span class="material-icons dots">more_horiz</span></div>
                                            </div>
                                        </div>
                                        <div class="post-info_relation">
                                            <?php
    
                                            if (isset($post['post']['replying_to']) && isset($post['post']['medium_id'])) {
                                                ?><span class="low-opacity">replying to <?=$post['post']['replying_to']?> on <?=$post['post']['medium_title']?></span><?php
                                            } else if (isset($post['post']['replying_to'])) {
                                                ?><span class="low-opacity">replying to <?=$post['post']['replying_to']?></span><?php
                                            } else if (isset($post['post']['medium_id'])) {
                                                ?><span class="low-opacity">on <?=$post['post']['medium_title']?></span><?php
                                            }
    
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <div class="content"><?=htmlspecialchars($post['post']['content'])?></div>
                                    <div class="social">
                                    <div class="social-icon">
                                        <span class="material-icons-outlined" id="display-reply">chat_bubble_outline</span>
                                        <p><?=$post['post']['reply_count']?></p>
                                    </div>
                                    <a href="/like?id=<?=$post['post']['post_id']?>">
                                    <div class="social-icon">
                                    <span class="material-icons-outlined">
                                        <?php if ($post['user']['liked']) {echo "favorite";} else {echo "favorite_border";} ?>
                                    </span>
                                        <p><?=$post['post']['like_count']?></p>
                                    </div>
                                    </a>
    
                                    <div class="social-icon">
                                        <span class="material-icons-outlined">
                                            <?php if ($post['user']['bookmarked']) {echo "bookmark";} else {echo "bookmark_border";} ?>
                                        </span>
                                        <p><?=$post['post']['bookmark_count']?></p>
                                    </div>
                                </div>
                                </div>
    
                            </div>
    
                        <?php
                    }
                    
                } else if (isset($globalTimeline)) {
                    foreach ($globalTimeline as $post) {
                        ?>
    
                            <div class="post-entry box-wrapper box-body" onclick="window.location='/activity/<?=$post['post']['post_id']?>'">
                                <div class="top">
                                    <a href="/<?=$post['user']['username']?>"><img src="<?=$post['user']['pfp']?>" alt=""></a>
                                    <div class="post-info">
                                        <div class="post-info_user">
                                            <div class="username">
                                                <div><span><?=$post['user']['username']?></span><span class="post_time-ago">&nbsp;&nbsp;·&nbsp;&nbsp;<?=$post['post']['time_ago']?></span></div>
                                                <div><span class="material-icons dots">more_horiz</span></div>
                                            </div>
                                        </div>
                                        <div class="post-info_relation">
                                            <?php
    
                                            if (isset($post['post']['replying_to']) && isset($post['post']['medium_id'])) {
                                                ?><span class="low-opacity">replying to <?=$post['post']['replying_to']?> on <?=$post['post']['medium_title']?></span><?php
                                            } else if (isset($post['post']['replying_to'])) {
                                                ?><span class="low-opacity">replying to <?=$post['post']['replying_to']?></span><?php
                                            } else if (isset($post['post']['medium_id'])) {
                                                ?><span class="low-opacity">on <?=$post['post']['medium_title']?></span><?php
                                            }
    
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <div class="content"><?=htmlspecialchars($post['post']['content'])?></div>
                                    <div class="social">
                                    <div class="social-icon">
                                        <span class="material-icons-outlined" id="display-reply">chat_bubble_outline</span>
                                        <p><?=$post['post']['reply_count']?></p>
                                    </div>
                                    <div class="social-icon">
                                    <span class="material-icons-outlined">
                                        <?php if (isset($post['user']['liked']) && $post['user']['liked']) {echo "favorite";} else {echo "favorite_border";} ?>
                                    </span>
                                        <p><?=$post['post']['like_count']?></p>
                                    </div>
    
                                    <div class="social-icon">
                                        <span class="material-icons-outlined">
                                            <?php if (isset($post['user']['bookmarked']) && $post['user']['bookmarked']) {echo "bookmark";} else {echo "bookmark_border";} ?>
                                        </span>
                                        <p><?=$post['post']['bookmark_count']?></p>
                                    </div>
                                </div>
                                </div>
    
                            </div>
    
                        <?php
                    }
                }
                ?>
            </div>
    </section>
    <?php
    } else {
        print 'You need to follow someone to see posts in this timeline.'. "<br>";
        ?><a href="/timeline?tl=global" class="low_opacity link">Show global timeline instead</a><?php
    }

    ?>
    </section>

    <section class="home_user-info">
        <section class="progress-wrapper box-wrapper">
            <div class="box-title">
                <h3>Watching Anime</h3>
            </div>
            <div class="box-body">
            <?php

            if (isset($watchingAnimes)) {
                foreach($watchingAnimes as $watchingAnime) {
                    ?>
                    
                        <div style="background-image: url('<?=$watchingAnime['anime']['cover']?>')" class="entry" onclick="window.location='/anime/<?=str_replace(' ', '-', $watchingAnime['anime']['title'])?>'">
                            <a href="/sum?medium=anime&id=<?=$watchingAnime['anime']['anime_id']?>"><span><?=$watchingAnime['user_progress']?> / <?=$watchingAnime['anime']['episodes']?></span></a>
                        </div>
                    
                    <?php
                }
            } else {
                print '<i>Currently not watching any anime...</i>';
            }

            ?>
            </div>
        </section>

        <section class="progress-wrapper box-wrapper">
            <div class="box-title">
                <h3>Reading Manga</h3>
            </div>
            <div class="box-body">
            <?php

            if (isset($readingMangas)) {
                foreach($readingMangas as $readingManga) {
                    ?>
                    
                        <div style="background-image: url('<?=$readingManga['manga']['cover']?>')" class="entry" onclick="window.location='/manga/<?=str_replace(' ', '-', $readingManga['manga']['title'])?>'">
                            <a href="/sum?medium=manga&id=<?=$readingManga['manga']['manga_id']?>"><span><?=$readingManga['user_progress']?> / <?=$readingManga['manga']['chapters']?></span></a>
                        </div>
                    
                    <?php
                }
            } else {
                print '<i>Currently not reading any manga...</i>';
            }

            ?>
            </div>
        </section>

        <?php

        if (isset($mostPosted)) {
            ?>
            <section class="most-posted_wrapper">
            <?php

            if (isset($mostPosted['anime'])) {
                ?>
                <div class="anime box-wrapper">
                <div class="box-title"><h3>Most posted about anime</h3></div>
                <div class="box-body">
                <?php

                foreach($mostPosted['anime'] as $entry) {
                    ?><div class="entry">
                        <h4><?=$entry['title']?></h4>
                        <p class="low-opacity"><?=$entry['posts']?> posts</p>
                    </div><?php
                }

                print '</div>';
                print '</div>';
            }

            if (isset($mostPosted['manga'])) {
                ?>
                <div class="manga box-wrapper">
                <div class="box-title"><h3>Most posted about manga</h3></div>
                <div class="box-body">
                <?php

                foreach($mostPosted['manga'] as $entry) {
                    ?><div class="entry">
                        <h4><?=$entry['title']?></h4>
                        <p class="low-opacity"><?=$entry['posts']?> posts</p>
                    </div><?php
                }

                print '</div>';
                print '</div>';
            }

            ?>
            </section>
            <?php
        }

        ?>

        <section class="latest-reviews_wrapper box-wrapper">
            <div class="box-title">
                <h3>Latest Reviews</h3>
                <span class="link"><a href="/reviews">view all</a></span>
            </div>
            <div class="box-body">
                <?php

                if (isset($latestReviews)) {
                    foreach($latestReviews as $latestReview) {
                    ?>
                    
                    <a href="/review/<?=$latestReview['review_id']?>">
                    <div class="entry">
                        <div class="header">
                            <img src="<?=$latestReview['header']?>" alt="">
                        </div>
                        <div class="info">
                            <div class="user">
                                <p>A review of <?=$latestReview['entry']?> by <?=$latestReview['username']?>.</p>
                            </div>
                            <div class="title">"<?=$latestReview['title']?>"</div>
                            
                        </div>
                    </div>
                    </a>

                    <?php
                    }
                } else {
                    print '<i>No reviews yet</i>';
                }

                ?>
            </div>
        </section>
    </section>
</div>