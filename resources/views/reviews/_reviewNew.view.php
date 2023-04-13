<section class="review_new-wrapper">
    <div class="reviews_new-header box-wrapper">
        <div class="box-title"><h3>Write a new <?=$reviewGuide[3]?> review</h3></div>
        <div class="box-body">
            <span class="low-opacity">This review will be displayed in your profile and in the listing pages.</span>
            <span class="link">
                <?php 
                
                if ($reviewGuide[3] === 'anime') {
                    ?><a href="/review/new/manga">Write a manga review instead.</a><?php
                } else if ($reviewGuide[3] === 'manga') {
                    ?><a href="/review/new/anime">Write an anime review instead.</a><?php
                }

                ?>
            </span>
        </div>
    </div>
    
    <?php

    if (isset($titles)) {
        ?>
        <section class="choose-entry">
        <form action="controllers/review.php" method="post">
            <label for="title">Choose a title: </label>
            <select name="title" id="title">
            <?php
        
            for ($i = 0; $i < count($titles); $i++) {
                ?><option value="<?=$titles[$i]?>"><?=$titles[$i]?></option><?php
            }

            ?>
            </select>
        </form>
        </section>
        <?php
    } else if (isset($entryToReview)) {
        echo '<p class="center-text low-opacity small-font">New review for '.$entryToReview.'</p>';
    }
    
    ?>

    <section class="review_new-fields">
        <form action="/reviews" method="POST">
            <div class="box-wrapper box-body">
                <input type="text" name="reviewTitle" id="reviewTitle" placeholder="Title of the review" required>
            </div>
            <div class="box-wrapper box-body">
                <textarea name="reviewContent" id="reviewContent" placeholder="Content of the review" required></textarea>
            </div>
            <input class="box submit-button__colorful" type="submit" name="submit" value="Submit">
        </form>
    </section>
</section>