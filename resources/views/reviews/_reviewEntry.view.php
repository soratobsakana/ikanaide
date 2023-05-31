<div class="review_entry-wrapper">
    <div class="review_header-wrapper box-wrapper">
        <div class="review_entry-medium box-title"><h3><?=htmlspecialchars($review['title'])?></h3></div>
        <div class="review_entry-user_info box-body"><p>A review of <a class="link" href="/<?=$review['medium']?>/<?=str_replace(' ', '-', $review['entry'])?>"><?=$review['entry']?></a>, written by <a class="link" href="/<?=$review['username']?>"><?=$review['username']?></a> on <?=ucfirst(dateFormat(substr($review['date'], 0, 10)))?></p></div>
    </div>
    <div class="review_entry-content box-wrapper box-body"><?=htmlspecialchars($review['text'])?></div>
    <div class="review_entry-votes">
        <?=$reviewVotes['upvotes']?>
        <div>
            <a href="/likeReview?id=<?=$review['review_id']?>&action=up">
                <?php
                
                if (isset($_COOKIE['session']) && $userVote === false) {
                    ?><span class="material-icons-outlined">thumb_up</span><?php
                } else if (isset($_COOKIE['session']) && $userVote === true) {
                    ?><span class="material-icons">thumb_up</span><?php
                } else {
                    ?><span class="material-icons-outlined">thumb_up</span><?php
                }
                
                ?>
            </a>
            <a href="/likeReview?id=<?=$review['review_id']?>&action=down">
                <?php

                if (isset($_COOKIE['session']) && $userVote === true) {
                    ?><span class="material-icons-outlined">thumb_down</span><?php
                } else if (isset($_COOKIE['session']) && $userVote === false) {
                    ?><span class="material-icons">thumb_down</span><?php
                } else {
                    ?><span class="material-icons-outlined">thumb_down</span><?php
                }
                
                ?>
            </a>
        </div>
        <?=$reviewVotes['downvotes']?>
    </div>
</div>