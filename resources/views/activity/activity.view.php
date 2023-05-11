<div class="activity_single-page_wrapper">
<?php 
    
    if (isset($repliedPost)) {
        ?>

    <section class="posts-wrapper box-wrapper">
        <a href="/activity/<?=$repliedPost['post']['post_id']?>">
            <div class="post-entry box-wrapper box-body">
                <div class="top">
                    <img src="<?=$repliedPost['user']['pfp']?>" alt="">
                    <div class="post-info">
                        <div class="post-info_user">
                            <div class="username">
                                <div><span><?=$repliedPost['user']['username']?></span><span class="post_time-ago">&nbsp;&nbsp;·&nbsp;&nbsp;<?=$repliedPost['post']['time_ago']?></span></div>
                                <div><span class="material-icons dots">more_horiz</span></div>
                            </div>
                        </div>
                        <div class="post-info_relation">
                            <?php

                            if (isset($post['post']['medium_id'])) {
                                ?><span class="low-opacity">replying to <?=$post['user']['username']?> on <?=$post['post']['medium_title']?></span><?php
                            } else {
                                ?><span class="low-opacity">replying to <?=$post['user']['username']?></span><?php
                            }
                            

                            ?>
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="content"><?=htmlspecialchars($repliedPost['post']['content'])?></div>
                    <div class="social">
                        <div class="social-icon">
                            <span class="material-icons-outlined">chat_bubble_outline</span>
                            <p><?=$repliedPost['post']['reply_count']?></p>
                        </div>
                        <div class="social-icon">
                        <span class="material-icons-outlined">
                            <?php if ($repliedPost['user']['liked']) {echo "favorite";} else {echo "favorite_border";} ?>
                        </span>
                            <p><?=$repliedPost['post']['like_count']?></p>
                        </div>
                        
                        <div class="social-icon">
                            <span class="material-icons-outlined">
                                <?php if ($repliedPost['user']['bookmarked']) {echo "bookmark";} else {echo "bookmark_border";} ?>
                            </span>
                            <p><?=$repliedPost['post']['bookmark_count']?></p>
                        </div>
                    </div>
                    </div>
                
                </div>
            </a>

    </section>
    <hr class="activity_replied-reply_separator">
    <?php
    }
    ?>

    <section class="posts-wrapper box-wrapper">
        <div class="post-entry single-page box-wrapper box-body">
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
                <div class="date low-opacity">
                    <?=timeFormat(substr($post['post']['date'], 10, 6))?>&nbsp;&nbsp;·&nbsp;&nbsp;<?=ucfirst(dateFormat(substr($post['post']['date'], 0, 10)))?>
                </div>
                
                <?php 
                
                if (isset($_COOKIE['session']) && $_COOKIE['session'] === "Yes") {
                    ?>
                    <hr id="edit-list_fields-separator">
                    <div class="social">
                        <div class="social-icon activity-page_icon" id="display-reply">
                            <span class="material-icons-outlined" id="reply-icon">chat_bubble_outline</span>
                            <p><?=$post['post']['reply_count']?></p>
                        </div>
                        <a href="/like?id=<?=$post['post']['post_id']?>">
                            <div class="social-icon activity-page_icon">
                            <span class="material-icons-outlined">
                                <?php if ($post['user']['liked']) {echo "favorite";} else {echo "favorite_border";} ?>
                            </span>
                                <p><?=$post['post']['like_count']?></p>
                            </div>
                        </a>
                        
                        <a href="/bookmark?id=<?=$post['post']['post_id']?>">
                            <div class="social-icon activity-page_icon">
                                <span class="material-icons-outlined">
                                    <?php if ($post['user']['bookmarked']) {echo "bookmark";} else {echo "bookmark_border";} ?>
                                </span>
                                <p><?=$post['post']['bookmark_count']?></p>
                            </div>
                        </a>
                        
                    </div>

                    <?php
                }
                
                ?>
                
            </div>

        </div>
    </section>

    <section class="post-reply_wrapper box-wrapper" id="post-reply_wrapper">
        <form method="POST" action="<?=$page?>">
            <div class="top">
                <img src="<?=$loggedUser['pfp']?>" alt="">
                <textarea name="post-reply" id="post-reply" placeholder="Post your reply"></textarea>
            </div>
            <div class="bottom">
                <button type="button" id="cancel-reply" class="box submit-button__colorful">Cancel</button>
                <input class="box submit-button__colorful" type="submit" name="submit-reply" value="Reply">
            </div>
        </form>
    </section>

    <?php 
    
    if (isset($replies)) {
        ?>

    <section class="posts-wrapper box-wrapper">
        <?php

        foreach ($replies as $reply) {
            ?>

            <a href="/activity/<?=$reply['post']['post_id']?>">
                <div class="post-entry box-wrapper box-body">
                    <div class="top">
                        <img src="<?=$reply['user']['pfp']?>" alt="">
                        <div class="post-info">
                            <div class="post-info_user">
                                <div class="username">
                                    <div><span><?=$reply['user']['username']?></span><span class="post_time-ago">&nbsp;&nbsp;·&nbsp;&nbsp;<?=$reply['post']['time_ago']?></span></div>
                                    <div><span class="material-icons dots">more_horiz</span></div>
                                </div>
                            </div>
                            <div class="post-info_relation">
                                <?php

                                if (isset($post['post']['medium_id'])) {
                                    ?><span class="low-opacity">replying to <?=$post['user']['username']?> on <?=$post['post']['medium_title']?></span><?php
                                } else {
                                    ?><span class="low-opacity">replying to <?=$post['user']['username']?></span><?php
                                }
                                

                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="content"><?=htmlspecialchars($reply['post']['content'])?></div>
                        <div class="social">
                            <div class="social-icon">
                                <span class="material-icons-outlined" id="display-reply">chat_bubble_outline</span>
                                <p><?=$reply['post']['reply_count']?></p>
                            </div>
                            <div class="social-icon">
                            <span class="material-icons-outlined">
                                <?php if ($reply['user']['liked']) {echo "favorite";} else {echo "favorite_border";} ?>
                            </span>
                                <p><?=$reply['post']['like_count']?></p>
                            </div>
                            
                            <div class="social-icon">
                                <span class="material-icons-outlined">
                                    <?php if ($reply['user']['bookmarked']) {echo "bookmark";} else {echo "bookmark_border";} ?>
                                </span>
                                <p><?=$reply['post']['bookmark_count']?></p>
                            </div>
                        </div>
                        </div>
                    
                    </div>
                </a>

                <?php
            }
        ?>
    </section>
        <?php
        }
    ?>           

</div>

<script !src="">
    let wrapper = document.getElementById('post-reply_wrapper');
    let btn = document.getElementById('display-reply');
    let icon = document.getElementById('reply-icon');
    let cancelBtn = document.getElementById('cancel-reply');

    btn.addEventListener('click', function() {
        wrapper.style.display = "block";
        document.getElementById("post-reply").focus();
        icon.style.opacity = "1";
    });

    cancelBtn.addEventListener('click', function() {
        wrapper.style.display = "none";
        icon.style.opacity = "var(--font_low-opacity)";
    });

</script>