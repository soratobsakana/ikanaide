<div class="querypage_left-column">
    <img src="<?=$mediumInfo['cover']?>" alt="<?=$mediumInfo['title']?>"/>
    <!-- Compruebo si el usuario tiene anime correspondiente a $id en su lista. Si no lo tiene, muestro un botón de añadir; si lo tiene, muestro uno de borrar. -->
    <?php

    if (isset($user_id)) {
        ?>
        <div class="querypage_left-column_user">
        <div class="querypage_left-column_user-list">
        <form action="/add" method="post">
        
        <?php

        if (!empty($listEntry)) {
            ?>

            <input class="list-submit box submit-button__colorful" type="submit" value="Delete from list" name="delete">
            <button type="button" id="edit-list_button" class="list-submit submit-button__colorful box">Edit your entry</button>


            <?php
            if (isset($listEntry['favorite']) && $listEntry['favorite'] === 0) {
                ?><input class="list-submit box submit-button__colorful bg-orange" type="submit" value="Favourite" name="favourite"><?php
            } else if (isset($listEntry['favorite']) && $listEntry['favorite'] === 1) {
                ?><input class="list-submit box submit-button__colorful bg-orange" type="submit" value="Unfavourite" name="unfavourite"><?php
            }
        } else {
            ?><input class="list-submit box submit-button__colorful" type="submit" value="Add to list" name="add"><?php
        }

        ?>
        
        </form>
        </div>
        </div>
        
        <?php
    }

    ?>

    <div class="write-a-review list-submit box submit-button__colorful bg-orange center-text less-bold">
        <a href="/review/new/<?=$medium?>/<?=str_replace(' ', '-', $mediumInfo['title'])?>">Write a review</a>
    </div>

    <section class="querypage_rank">
        <div class="score box-wrapper">
            <div class="box-title">
                <h3>Score</h3>
            </div>
            <div class="box-body">
                <?php
                // $score is a string value, so I use '' instead of 0.
                if (isset($score) && $score !== '') {
                    echo $score;
                } else {
                    echo 'N/A';
                }
                ?>

            </div>
        </div>
        <div class="rank box-wrapper">
            <div class="box-title">
                <h3>Rank</h3>
            </div>
            <div class="box-body">
                <?php

                if (isset($rank) && $rank !== 0) {
                    ?><span>#<?=$rank?></span><?php
                } else {
                    ?><span>N/A</span><?php
                }

                ?>
            </div>
        </div>
    </section>
    <section class="querypage_info box-wrapper">
        <div class="box-title">
            <h3>Information</h3>
        </div>
        <div class="box-body">
            <ul class="two-column-list">
                <?php

                switch($medium) {
                    case 'anime':
                        $columns = ['type', 'episodes', 'status', 'start_date', 'end_date'];
                        break;
                    case 'manga':
                        $columns = ['format', 'volumes', 'chapters', 'status', 'start_date', 'end_date'];
                        break;
                    case 'vn':
                        $columns = ['duration', 'released'];
                        break;
                }
                foreach ($columns as $column){
                    ?><li><span class="ul_first-column"><?=str_replace('_', ' ', $column);?></span><span><?=dateFormat($mediumInfo[$column])?></span></li><?php
                }

                ?></ul>
        </div>
    </section>
    <section class="querypage_people two-column-list box-wrapper">
        <div class="box-title">
            <h3>Community</h3>
        </div>
        <div class="box-body">
            <ul class="two-column-list">
                <li><span class="ul_first-column">members</span><span><?=$members?></span></li>
                <li><span class="ul_first-column">favourited</span><span><?=$favourited?></span></li>
                <li><span class="ul_first-column">ranked</span>
                <?php
                if (isset($rank) && $rank !== 0) {
                    ?><span>#<?=$rank?></span><?php
                } else {
                    ?><span>N/A</span><?php
                }
                ?>
                </li>
                <li><span class="ul_first-column">popularity</span>
                <?php
                if (isset($popularity) && $popularity !== 0) {
                    ?><span>#<?=$popularity?></span><?php
                } else {
                    ?><span>N/A</span><?php
                }
                ?>
                </li>
            </ul>
        </div>
    </section>
    <section class="querypage_edit box-wrapper box-body">
        <!-- broken -->
        <a href="../edit"><p>Edit this page </p></a>
    </section>
</div>

<div class="querypage_right-column">
    <?php
    if ($mediumInfo['header'] !== null) {
        print "<img src=".$mediumInfo['header']." alt=".$mediumInfo['title'].">";
    }
    ?>
    <section class="querypage_title box-wrapper">
        <h1 style="font-family: Inter!important; font-weight: 900!important"><?=$mediumInfo['title']?></h1>
    </section>
    <section class="querypage_desc box-wrapper">
        <div class="box-title">
            <h3>Description</h3>
        </div>
        <div class="box-body">
            <?=$mediumInfo['description']?>
        </div>
    </section>
    <section class="querypage_char box-wrapper">
        <div class="querypage_title box-title">
            <h3>Characters</h3><span class="view-all">view all</span>
        </div>
        <div class="querypage_char-entry_wrapper querypage_bg">
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
                                <?=$characters[$i]['family_name'] . ' ' . $characters[$i]['given_name']?>
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
    <section class="querypage_staff box-wrapper">
        <div class="box-title">
            <div class="querypage_title"><h3>Staff</h3><span class="view-all">view all</span></div>
        </div>
        <div class="querypage_staff-entry_wrapper querypage_bg">
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
                                <?=$staff[$i]['family_name'] . ' ' . $staff[$i]['given_name']?>
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
    <section class="querypage_review box-wrapper">
        <div class="querypage_title box-title"><h3>Reviews</h3><span class="view-all">view all</span></div>
        <div class="querypage_review-entry_wrapper querypage_bg">
            <?php
            if (isset($reviews)) {
                for ($i=0; $i<count($reviews); $i++) {
                    ?>

                    <div class="querypage_review-entry">
                        
                        <div class="querypage_review-entry_content">
                            <a href="/<?=$reviews[$i]['username']?>">
                                <div class="querypage_review-entry_pic">
                                    <img src="<?=$reviews[$i]['pfp']?>" alt="<?=$mediumInfo['title']?>">
                                </div>
                            </a>
                            <a class="querypage_review-entry_title box-body" href="/review/<?=$reviews[$i]['review_id']?>">
                                <i><?=$reviews[$i]['title']?></i>
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
</div>

<section id="querypage_list-edit">
    <div class="querypage_list-edit_wrapper box-wrapper">
        <div class="querypage_list-edit_form">
            <form action="/add" method="POST">
                <div class="box-title">
                    <h3><?=$mediumInfo['title']?></h3>
                </div>
                <div class="edit-list_fields box-body">
                    <div class="edit-list_fields-inputs">
                        <div class="input-wrapper">
                            <label for="status">status</label>
                            <select name="status" id="status">
                                <?php $medium === 'anime' ? $current = 'watching' : $current = 'reading'; ?>
                                <option <?php if ($listEntry['status'] === 'watching')  { echo 'selected ';} ?>value="<?=$current?>"><?=$current?></option>
                                <option <?php if ($listEntry['status'] === 'completed') { echo 'selected ';} ?>value="completed">completed</option>
                                <option <?php if ($listEntry['status'] === 'planned')   { echo 'selected ';} ?>value="planned">planned</option>
                                <option <?php if ($listEntry['status'] === 'dropped')   { echo 'selected ';} ?>value="dropped">dropped</option>
                                <option <?php if ($listEntry['status'] === 'stalled')   { echo 'selected ';} ?>value="stalled">stalled</option>
                            </select>
                        </div>
                        <div class="input-wrapper">
                            <label for="score">score</label>
                            <!-- If score is null I want to show 0 instead of nothing (which I actually prefer on /user/animelist) -->
                            <?php $listEntry['score'] === null ? $entryScore = 0 : $entryScore = $listEntry['score']; ?>
                            <input min='0' max='10' value='<?=$entryScore?>' type="number" name="score" id="score">
                        </div>
                        <div class="input-wrapper">
                            <label for="progress">progress</label>
                            <?php $medium === 'anime' ? $counter = 'episodes' : $counter = 'chapters'; ?>
                            <input min='0' max='<?=$mediumInfo[$counter]?>' value='<?=$listEntry['progress']?>' type="number" name="progress" id="progress">
                        </div>
                        <div class="input-wrapper">
                            <label for="start-date">start date</label>
                            <input type="date" value="<?=$listEntry['start_date']?>" name="start-date" id="start-date">
                        </div>
                        <div class="input-wrapper">
                            <label for="end-date">end date</label>
                            <input type="date" value="<?=$listEntry['end_date']?>" name="end-date" id="end-date">
                        </div>
                        <div class="input-wrapper">
                            <label for="rewatches">rewatches</label>
                            <input min='0' value='<?=$listEntry['rewatches']?>' type="number" name="rewatches" id="rewatches">
                        </div>
                    </div>
                    <div class="edit-list_fields-textarea">
                        <div class="input-wrapper">
                            <label for="notes">notes</label>
                            <textarea name="notes" id="notes"><?=$listEntry['notes']?></textarea>
                        </div>
                    </div>
                    <hr id="edit-list_fields-separator">
                    <div class="edit-list_fields-buttons">
                        <button type="button" id="edit-list_cancel" class="submit-button__colorful box">Cancel</button>
                        <input class="submit-button__colorful box" type="submit" name='save' value="Save">
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script !src="">
    let modal = document.getElementById('querypage_list-edit');
    let btn = document.getElementById('edit-list_button');
    let cancelBtn = document.getElementById('edit-list_cancel');

    btn.addEventListener('click', function() {
        modal.style.display = "block";
    })

    cancelBtn.addEventListener('click', function() {
        modal.style.display = "none";
    })

</script>