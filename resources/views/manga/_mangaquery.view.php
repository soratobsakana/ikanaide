<div class="querypage_left-column">
    <img src="<?=$mangaInfo['cover']?>" alt="<?=$mangaInfo['title']?>"/>
    <section class="querypage_info two-column-list box">
        <?php
        $info = [];
        foreach ($mangaInfo as $key => $value) {
            $info = replaceUnderscore($mangaInfo);
        }
        ?>

        <ul>
            <li><span class="ul_first-column">format</span><span><?=$mangaInfo['format']?></span></li>
            <li><span class="ul_first-column">volumes</span><span><?=$mangaInfo['volumes']?></span></li>
            <li><span class="ul_first-column">chapters</span><span><?=$mangaInfo['chapters']?></span></li>
            <li><span class="ul_first-column">status</span><span><?=$mangaInfo['status']?></span></li>
            <li><span class="ul_first-column">start date</span><span><?=$formattedStartDate?></span></li>
            <li><span class="ul_first-column">end date</span><span><?=$formattedEndDate?></span></li>
        </ul>
    </section>
    <section class="querypage_people two-column-list box">
        <ul>
            <li><span class="ul_first-column">members</span><span><?=$mangaInfo['members']?></span></li>
            <li><span class="ul_first-column">loved</span><span><?=$mangaInfo['favorited']?></span></li>
            <li><span class="ul_first-column">ranked</span><span></span></li>
            <li><span class="ul_first-column">popularity</span><span></span></li>
        </ul>
    </section>
    <section class="querypage_edit box">
        <a href="../edit?aid=<?=$mangaInfo['manga_id']?>"><p>Edit this page </p></a>
    </section>
</div>

<div class="querypage_right-column">
    <?php
    if ($mangaInfo['header'] !== null) {
        print "<img src=".$mangaInfo['header']." alt=".$mangaInfo['title'].">";
    }
    ?>
    <section class="querypage_title"><h1><?=$mangaInfo['title']?></h1></section>
    <section class="querypage_desc box"><?=$mangaInfo['description']?></section>
    <section class="querypage_char">
        <div class="header"><h3>Characters</h3><span class="view-all">view all</span></div>
        <div class="querypage_char-entry_wrapper">
            <?php
            if (isset($characters)) {
                for ($i=0; $i<count($characters); $i++) {
                    ?>

                    <div class="querypage_char-entry">
                        <div class="querypage_char-entry_pic">
                            <img src="<?=$characters[$i]['picture']?>" alt="<?=$characters[$i]['family_name'] . ' ' . $characters[$i]['given_name']?>">
                        </div>
                        <div class="querypage_char-entry_info">
                            <div class="querypage_char-entry_info-name">
                                <?=$characters[$i]['family_name'] . ', ' . $characters[$i]['given_name']?>
                            </div>
                            <div class="querypage_char-entry_info-role">
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
    </section>
    <section class="querypage_staff">
        <div class="header"><h3>Staff</h3><span class="view-all">view all</span></div>
        <div class="querypage_staff-entry_wrapper">
            <?php
            if (isset($staff)) {
                for ($i=0; $i<count($staff); $i++) {
                    ?>

                    <div class="querypage_staff-entry">
                        <div class="querypage_staff-entry_pic">
                            <img src="<?=$staff[$i]['picture']?>" alt="<?=$staff[$i]['family_name'] . ' ' . $staff[$i]['given_name']?>">
                        </div>
                        <div class="querypage_staff-entry_info">
                            <div class="querypage_staff-entry_info-name">
                                <?=$staff[$i]['family_name'] . ', ' . $staff[$i]['given_name']?>
                            </div>
                            <div class="querypage_staff-entry_info-role">
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
    </section>
    <section class="querypage_review">
        <div class="header"><h3>Reviews</h3><span class="view-all">view all</span></div>
        <div class="querypage_review-entry_wrapper">
            <?php
            if (isset($reviews)) {
                for ($i=0; $i<count($reviews); $i++) {
                    ?>

                    <div class="querypage_review-entry">
                        <div class="querypage_review-entry_pic">
                            <img src="<?=$mangaInfo['cover']?>" alt="<?=$mangaInfo['title']?>">
                        </div>
                        <div class="querypage_review-entry_info">
                            <div class="querypage_review-entry_info-name">
                                <i><?=$reviews[$i]['title']?></i>
                            </div>
                            <div class="querypage_review-entry_info-role">
                                <span>by <a href="user">nagisa</a>.</span>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                print "<i style='opacity: var(--font_low-opacity)'>No reviews yet...</i>";
            }
            ?>
        </div>
    </section>
</div>