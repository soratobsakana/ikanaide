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
    
                        <a href="/activity/<?=$post['post']['post_id']?>">
                            <div class="post-entry box-wrapper box-body">
                                <div class="top">
                                    <img src="<?=$post['user']['pfp']?>" alt="">
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
                                    <!--<div class="social">
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
                                        <span class="material-icons-outlined">bookmark_border</span>
                                        <p>0</p>
                                    </div>
                                </div>-->
                                </div>
    
                            </div>
                        </a>
    
                        <?php
                    }
                    
                } else if (isset($globalTimeline)) {
                    foreach ($globalTimeline as $post) {
                        ?>
    
                        <a href="/activity/<?=$post['post']['post_id']?>">
                            <div class="post-entry box-wrapper box-body">
                                <div class="top">
                                    <img src="<?=$post['user']['pfp']?>" alt="">
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
                                        <?php if ($post['user']['liked']) {echo "favorite";} else {echo "favorite_border";} ?>
                                    </span>
                                        <p><?=$post['post']['like_count']?></p>
                                    </div>
    
                                    <div class="social-icon">
                                        <span class="material-icons-outlined">bookmark_border</span>
                                        <p><?=$post['post']['bookmark_count']?></p>
                                    </div>
                                </div>
                                </div>
    
                            </div>
                        </a>
    
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
                    <a href="/sum?medium=anime&id=<?=$watchingAnime['anime']['anime_id']?>">
                        <div style="background-image: url('<?=$watchingAnime['anime']['cover']?>')" class="entry">
                            <span><?=$watchingAnime['user_progress']?> / <?=$watchingAnime['anime']['episodes']?></span>
                        </div>
                    </a>
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
                    <a href="/sum?medium=manga&id=<?=$readingManga['manga']['manga_id']?>">
                        <div style="background-image: url('<?=$readingManga['manga']['cover']?>')" class="entry">
                            <span><?=$readingManga['user_progress']?> / <?=$readingManga['manga']['chapters']?></span>
                        </div>
                    </a>
                    <?php
                }
            } else {
                print '<i>Currently not reading any manga...</i>';
            }

            ?>
            </div>
        </section>

        <section class="latest-reviews_wrapper box-wrapper">
            <div class="box-title">
                <h3>Latest Reviews</h3>
                <span class="link"><a href="/reviews">view all</a></span>
            </div>
            <div class="box-body">
                <?php

                if (isset($latestReviews)) {
                    $i = 0;
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
                        $i++;
                        if ($i > 3) {
                            break;
                        }
                    }
                } else {
                    print '<i>No reviews yet</i>';
                }

                ?>
            </div>
        </section>
    </section>
</div>