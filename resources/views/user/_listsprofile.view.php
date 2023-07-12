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
                                    <img src="<?=$animes[$group][$i]['info']['cover']?>">
                                </div>
                                <div class="profile_user-list_entry-title">
                                    <a href="/anime/<?=str_replace(' ', '-', $animes[$group][$i]['info']['title'])?>"><?=$animes[$group][$i]['info']['title']?></a>
                                </div>
                                <div class="profile_user-list_entry-score center-text">
                                    <?=$animes[$group][$i]['score']?>
                                </div>
                                <div class="profile_user-list_entry-progress center-text">
                                    <?php
                                    if (isset($_COOKIE['session']) && $_COOKIE['username'] === $userInfo['username']) {
                                        ?><a href="/sum?medium=<?=$medium?>&id=<?=$animes[$group][$i]['info']['anime_id']?>"><?=$animes[$group][$i]['progress']?>/<?=$animes[$group][$i]['info']['episodes']?></a><?php
                                    } else {
                                        print $animes[$group][$i]['progress'].'/'.$animes[$group][$i]['info']['episodes'];
                                    }
                                    ?>

                                </div>
                                <div class="profile_user-list_entry-type center-text">
                                    <?=$animes[$group][$i]['info']['type']?>
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
                                    <img src="<?=$mangas[$group][$i]['info']['cover']?>">
                                </div>
                                <div class="profile_user-list_entry-title">
                                    <a href="/manga/<?=str_replace(' ', '-', $mangas[$group][$i]['info']['title'])?>"><?=$mangas[$group][$i]['info']['title']?></a>
                                </div>
                                <div class="profile_user-list_entry-score center-text">
                                    <?=$mangas[$group][$i]['score']?>
                                </div>
                                <div class="profile_user-list_entry-progress center-text">
                                <a href="/sum?medium=<?=$medium?>&id=<?=$mangas[$group][$i]['info']['manga_id']?>"><?=$mangas[$group][$i]['progress']?>/<?=$mangas[$group][$i]['info']['chapters']?></a>
                                </div>
                                <div class="profile_user-list_entry-type center-text">
                                    <?=$mangas[$group][$i]['info']['format']?>
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