<section class="reviews_home-wrapper">
    <?php
    
    if (isset($reviewsHome)) {
        for ($i = 0; $i < count($reviewsHome); $i++) {
            ?>

                <div class="review">
                <a href="/review/<?=$reviewsHome[$i]['review_id']?>">
                    <div class="first-row">
                    <img class="review_home_user-pfp" src="<?=$reviewsHome[$i]['pfp']?>" alt="<?=$reviewsHome[$i]['username']?>">    
                    <div class="review_home_user-body box-wrapper box-body">
                        <i><?=$reviewsHome[$i]['title']?>.</i>
                    </div>
                    </div>
                </a>
                    <div class="second-row">
                        <p>Written by <a href="/<?=$reviewsHome[$i]['username']?>"><?=$reviewsHome[$i]['username']?></a> on <a href="/<?=$reviewsHome[$i]['medium']?>/<?=str_replace(' ', '-', $reviewsHome[$i]['entry'])?>"><?=$reviewsHome[$i]['entry']?></a></p>
                    </div>
                </div>

            <?php
        }
    } else if (isset($review)) {
        pre($review);
    }
    
    ?>
</section>