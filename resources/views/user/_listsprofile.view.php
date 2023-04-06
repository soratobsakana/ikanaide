<section class="profile_user-list">
    <?php
    if ((!empty($animelist) && !empty($animes)) || (!empty($mangalist) && !empty($mangas))) {
        $medium = substr(explode("/", $page)[2], 0, -4); // retorna 'anime' o 'manga'.
        ?>

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
                                    <?=$animelist[$i]['score']?>
                                </div>
                                <div class="profile_user-list_entry-progress center-text">
                                    <?php $animelist[$i]['status'] === 'completed' ? $progress = $animes[$group][$i]['episodes'] : $progress = $animelist[$i]['progress']; ?>
                                    <?=$progress?>/<?=$animes[$group][$i]['episodes']?>
                                </div>
                                <div class="profile_user-list_entry-type center-text">
                                    <?=$animes[$group][$i]['type']?>
                                </div>
                            </div>
                            <?php
                        }
                        echo '</div>';
                        echo '</div>';
                    } else if (isset($mangas[$group]) && $medium === 'manga') {
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
                                    <?=$mangalist[$i]['score']?>
                                </div>
                                <div class="profile_user-list_entry-progress center-text">
                                    <?php $mangalist[$i]['status'] === 'completed' ? $progress = $mangas[$group][$i]['chapters'] : $progress = $mangalist[$i]['progress']; ?>
                                    <?=$progress?>/<?=$mangas[$group][$i]['chapters']?>
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