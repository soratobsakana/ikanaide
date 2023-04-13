<section class="reviews_home-wrapper">
    <div class="reviews_home-header box-wrapper">
        <div class="box-title"><h3>All reviews</h3></div>
        <div class="box-body"><span class="low-opacity">This reviews are showing in a chronological order.</span><span class="link"><a href="/review/new/anime">Write a new review.</a></span></div>
    </div>
    
    <div class="reviews_home-content">

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
                            <p>written by <a class="link" href="/<?=$reviewsHome[$i]['username']?>"><?=$reviewsHome[$i]['username']?></a> on <a class="link" href="/<?=$reviewsHome[$i]['medium']?>/<?=str_replace(' ', '-', $reviewsHome[$i]['entry'])?>"><?=$reviewsHome[$i]['entry']?></a>.</p>
                        </div>
                    </div>

                <?php
            }
        } else if (isset($review)) {
            pre($review);
        }
        
        ?>
    </div>
</section>