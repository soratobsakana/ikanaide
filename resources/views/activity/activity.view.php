<section class="posts-wrapper box-wrapper">
    <div class="post-entry single-page box-wrapper box-body">
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

                    if (isset($post['post']['medium_id'])) {
                        ?><span class="low-opacity">on <?=$post['post']['medium_title']?></span><?php
                    }

                    ?>
                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="content"><?=htmlspecialchars($post['post']['content'])?></div>
            <div class="date low-opacity">
                <?=timeFormat(substr($post['post']['date'], 10, 6))?>&nbsp;&nbsp;·&nbsp;&nbsp;<?=ucfirst(dateFormat(substr($post['post']['date'], 0, 10)))?>
            </div>
            <hr id="edit-list_fields-separator">
            <div class="social">
                <span class="material-icons-outlined">chat_bubble_outline</span>
                <span class="material-icons-outlined">favorite_border</span>
                <span class="material-icons-outlined">bookmark_border</span>
            </div>
        </div>

    </div>
</section>