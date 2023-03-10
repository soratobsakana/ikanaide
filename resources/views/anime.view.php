<?php require 'app/controllers/anime.php' ?>

<section class="left_column">
    <img src="<?=$animeInfo['cover']?>" alt="<?=$animeInfo['title']?>"/>
    <div class="animepage_info two-column-list box">
        <ul>
            <li><span class="ul_first-column">type</span><span><?=$animeInfo['type']?></span></li>
            <li><span class="ul_first-column">episodes</span><span><?=$animeInfo['episodes']?></span></li>
            <li><span class="ul_first-column">status</span><span><?=$animeInfo['status']?></span></li>
            <li><span class="ul_first-column">start date</span><span><?=$formattedStartDate?></span></li>
            <li><span class="ul_first-column">end date</span><span><?=$formattedEndDate?></span></li>
            <li><span class="ul_first-column">season</span><span><?=$animeInfo['season']?></span></li>
            <li><span class="ul_first-column">studios</span><span><?=$animeInfo['studios']?></span></li>
        </ul>
    </div>
    <div class="animepage_people two-column-list box">
        <ul>
            <li><span class="ul_first-column">members</span><span><?=$animeInfo['members']?></span></li>
            <li><span class="ul_first-column">loved</span><span><?=$animeInfo['favorited']?></span></li>
            <li><span class="ul_first-column">ranked</span><span></span></li>
            <li><span class="ul_first-column">popularity</span><span></span></li>
        </ul>
    </div>
    <div class="animepage_edit box">
        <a href="submit"><p>edit this page</p></a>
    </div>
</section>

<section class="right_column">
    <?php
    if ($animeInfo['header'] !== null) {
        print "<img src=".$animeInfo['header']." alt=".$animeInfo['title'].">";
    }
    ?>
    <div class="animepage_title"><h1><?=$animeInfo['title']?></h1></div>
    <div class="animepage_desc box"><?=$animeInfo['description']?></div>
    <div class="animepage_char">
        <div class="header"><h3>Characters</h3><span class="view-all">view all</span></div>
        <div class="animepage_char-entry_wrapper">
            <?php
            if (isset($characters)) {
                for ($i=0; $i<count($characters); $i++) {
                    ?>

                    <div class="animepage_char-entry">
                        <div class="animepage_char-entry_pic">
                            <img src="<?=$characters[$i]['picture']?>" alt="<?=$characters[$i]['family_name'] . ' ' . $characters[$i]['given_name']?>">
                        </div>
                        <div class="animepage_char-entry_info">
                            <div class="animepage_char-entry_info-name">
                                <?=$characters[$i]['family_name'] . ', ' . $characters[$i]['given_name']?>
                            </div>
                            <div class="animepage_char-entry_info-role">
                                <?=strtolower($characters[$i]['role']) . " character"?>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                print "<i style='opacity: var(--font_low-opacity)'>No characters yet...</i>";
            }
            ?>
        </div>
    </div>
    <div class="animepage_staff">
        <div class="header"><h3>Staff</h3><span class="view-all">view all</span></div>
        <div class="animepage_staff-entry_wrapper">
            <?php
            if (isset($staff)) {
                for ($i=0; $i<count($staff); $i++) {
                    ?>

                    <div class="animepage_staff-entry">
                        <div class="animepage_staff-entry_pic">
                            <img src="<?=$staff[$i]['picture']?>" alt="<?=$staff[$i]['family_name'] . ' ' . $staff[$i]['given_name']?>">
                        </div>
                        <div class="animepage_staff-entry_info">
                            <div class="animepage_staff-entry_info-name">
                                <?=$staff[$i]['family_name'] . ', ' . $staff[$i]['given_name']?>
                            </div>
                            <div class="animepage_staff-entry_info-role">
                                <?=strtolower($staff[$i]['role'])?>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                print "<i style='opacity: var(--font_low-opacity)'>No staff yet...</i>";
            }
            ?>
        </div>
    </div>
    <div class="animepage_review">
        <div class="header"><h3>Reviews</h3><span class="view-all">view all</span></div>
        <div class="animepage_review-entry_wrapper">
            <?php
            if (isset($reviews)) {
                for ($i=0; $i<count($reviews); $i++) {
                    ?>

                    <div class="animepage_review-entry">
                        <div class="animepage_review-entry_pic">
                            <img src="<?=$animeInfo['cover']?>" alt="<?=$animeInfo['title']?>">
                        </div>
                        <div class="animepage_review-entry_info">
                            <div class="animepage_review-entry_info-name">
                                <i><?=$reviews[$i]['title']?></i>
                            </div>
                            <div class="animepage_review-entry_info-role">
                                <span>written by <a href="user">nagisa</a>.</span>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                print "<i style='opacity: var(--font_low-opacity)'>No reviews yet...</i>";
            }
            $db -> close();
            ?>
        </div>
    </div>
</section>