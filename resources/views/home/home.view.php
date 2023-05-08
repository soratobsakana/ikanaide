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
        <a href="anime">go to anime page</a><br>
        <a href="manga">go to manga page</a><br>
        <a href="rankings">go to rankings page</a><br>
        <?php

        if (isset($_COOKIE['username'])) {
            ?><a href="<?=$_COOKIE['username']?>">go to profile page</a><br><?php
        }

        ?>
        <a href="submit">go to submit</a><br>
        <a href="reviews">go to reviews</a>
    </section>
</div>