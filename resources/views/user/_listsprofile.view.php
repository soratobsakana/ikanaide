<section class="profile_user-list">
    <?php $medium = substr(explode("/", $page)[2], 0, -4); // retorna 'anime' o 'manga'. ?>
    <div class="profile_user-list_header box-wrapper">
        <div class="box-title">
            <h3><?=ucfirst($medium)?> List</h3>
        </div>
        <div class="box-body">
            <ul class="profile_user-list_content-labels list-grid">
                <li>cover</li>
                <li>title</li>
                <li class="center-text">score</li>
                <li class="center-text">progress</li>
                <?php $medium === 'anime' ? $type = 'type' : $type = 'format' ?>
                <li class="center-text"><?=$type?></li>
            </ul>
        </div>
    </div>
    <?php
    if ((!empty($animelist) && !empty($animes)) || (!empty($mangalist) && !empty($mangas))) {
        ?>
            <div class="profile_user-list_entry-wrapper">
                <?php

                $medium === 'anime' ? $current = 'watching' : $current = 'reading';
                $groups = [$current, 'completed', 'planned', 'stalled', 'dropped'];
                foreach ($groups as $group) {
                    if (isset($animes[$group]) && $medium === 'anime') {

                        ?>
                        <div class="box-wrapper">
                        <div class="box-title"><h3><?=ucfirst($group)?></h3></div>
                        <div class="box-body">
                        <?php

                        for ($i=0; $i<count($animes[$group]); $i++) {
                            ?>
                            <div class="profile_user-list_entry list-grid">
                                <div class="profile_user-list_entry-cover">
                                    <img src="<?=$animes[$group][$i]['cover']?>">
                                </div>
                                <div class="profile_user-list_entry-title">
                                    <a href="/anime/<?=str_replace(' ', '-', $animes[$group][$i]['title'])?>"><?=$animes[$group][$i]['title']?></a>
                                </div>
                                <div class="profile_user-list_entry-score center-text">
                                    <?=$animes[$group][$i]['score']?>
                                </div>
                                <div class="profile_user-list_entry-progress center-text">
                                    <?=$animes[$group][$i]['progress']?>/<?=$animes[$group][$i]['episodes']?>
                                </div>
                                <div class="profile_user-list_entry-type center-text">
                                    <?=$animes[$group][$i]['type']?>
                                </div>
                            </div>
                            <?php
                        }
                        echo '</div>';
                        echo '</div>';
                    } else if (isset($mangas[$group]) && count($mangas) > 0 && $medium === 'manga') {
                        ?>
                        <div class="box-wrapper">
                        <div class="box-title"><h3><?=ucfirst($group)?></h3></div>
                        <div class="box-body">
                        <?php

                        for ($i=0; $i<count($mangas[$group]); $i++) {
                            ?>
                            <div class="profile_user-list_entry list-grid">
                                <div class="profile_user-list_entry-cover">
                                    <img src="<?=$mangas[$group][$i]['cover']?>">
                                </div>
                                <div class="profile_user-list_entry-title">
                                    <a href="/manga/<?=str_replace(' ', '-', $mangas[$group][$i]['title'])?>"><?=$mangas[$group][$i]['title']?></a>
                                </div>
                                <div class="profile_user-list_entry-score center-text">
                                    <?=$mangas[$group][$i]['score']?>
                                </div>
                                <div class="profile_user-list_entry-progress center-text">
                                    <?=$mangas[$group][$i]['progress']?>/<?=$mangas[$group][$i]['chapters']?>
                                </div>
                                <div class="profile_user-list_entry-type center-text">
                                    <?=$mangas[$group][$i]['format']?>
                                </div>
                            </div>
                            <?php
                        }
                        echo '</div>';
                        echo '</div>';
                    }

                }
                    ?>
                </div>

        <?php
    } else {
        print '<i>This seems empty...</i>';
    }
    ?>
</section>

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