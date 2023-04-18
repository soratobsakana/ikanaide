<section class="querypage_review box-wrapper">
        <div class="querypage_title box-title"><h3>Reviews</h3><span class="view-all">view all</span></div>
        <div class="querypage_review-entry_wrapper querypage_bg">
            <?php
            if (isset($userReviews)) {
                for ($i=0; $i<count($userReviews); $i++) {
                    ?>

                    <div class="querypage_review-entry">
                        <div class="querypage_review-entry_content">
                            <div class="querypage_review-entry_pic">
                            <a href="/<?=$userInfo['username']?>">
                                <img src="<?=$userInfo['pfp']?>" alt="<?=htmlspecialchars($userReviews[$i]['title'])?>">
                            </a>
                            </div>
                            <a class="querypage_review-entry_title box-body" href="/review/<?=$userReviews[$i]['review_id']?>">
                                <i><?=htmlspecialchars($userReviews[$i]['title'])?></i>
                            </a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                print "<i style='opacity: var(--font_low-opacity); padding: 10px 0'>No reviews yet...</i>";
            }
            ?>
        </div>
</section>
