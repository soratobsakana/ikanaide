<div class="home_timeline">
    <?php

    if (isset($followingTimeline)) {
    ?>
    <section class="posts-wrapper box-wrapper">
        <div class="box-title">
            <h3>Your timeline</h3>
        </div>
        <div class="box-body">

            <?php
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
            ?>
        </div>
</div>
</section>
<?php
} else {
    print 'aa';
}

?>
</div>

<div class="home_user-info">

</div>