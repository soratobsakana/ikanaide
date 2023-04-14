<section class="review_new-wrapper">
    <div class="reviews_new-header box-wrapper">
        <div class="box-title"><h3>
            <?php
            
            if (isset($entryToReview)) {
                echo '<h3>Write a new '.$entryToReview.' review</h3>';
            } else {
                ?>Write a new <?=$reviewGuide[3]?> review<?php
            }
            
            ?>
            
        </h3></div>
        <div class="box-body">
            <span class="low-opacity">This review will be displayed in your profile and in the listing pages.</span>
            <span class="link">
                <?php 
                
                if (!isset($entryToReview)) {
                    if ($reviewGuide[3] === 'anime') {
                        ?><a href="/review/new/manga">Write a manga review instead.</a><?php
                    } else if ($reviewGuide[3] === 'manga') {
                        ?><a href="/review/new/anime">Write an anime review instead.</a><?php
                    }
                }

                ?>
            </span>
        </div>
    </div>
    <form action="<?=$page?>" method="POST">

    <?php

    if (isset($titles)) {
        ?>
        <section class="choose-entry">
            <label for="title">Choose a title: </label>
            <select name="title" id="title">
            <?php
        
            for ($i = 0; $i < count($titles); $i++) {
                ?><option value="<?=$titles[$i]?>"><?=$titles[$i]?></option><?php
            }

            ?>
            </select>
        </section>
        <?php
    }
    
    ?>

    <section class="review_new-fields">
        
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