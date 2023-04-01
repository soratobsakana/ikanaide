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
            <div class="profile_user-list_entry-wrapper box-wrapper">
                <div class="box-body">
                    <?php

                    if ($medium === 'anime') {
                        for ($i=0; $i<count($animelist); $i++) {
                            ?>
                            <div class="profile_user-list_entry list-grid">
                                <div class="profile_user-list_entry-cover">
                                    <img src="<?=$animes[$i]['cover']?>">
                                </div>
                                <div class="profile_user-list_entry-title">
                                    <a href="/anime/<?=str_replace(' ', '-', $animes[$i]['title'])?>"><?=$animes[$i]['title']?></a>
                                </div>
                                <div class="profile_user-list_entry-score center-text">
                                    <?=$animelist[$i]['score']?>
                                </div>
                                <div class="profile_user-list_entry-progress center-text">
                                    <?=$animelist[$i]['progress']?>/<?=$animes[0]['episodes']?>
                                </div>
                                <div class="profile_user-list_entry-type center-text">
                                    <?=$animes[$i]['type']?>
                                </div>
                            </div>
                            <?php
                        }
                    } else if ($medium === 'manga') {
                        for ($i=0; $i<count($mangalist); $i++) {
                            ?>
                            <div class="profile_user-list_entry list-grid">
                                <div class="profile_user-list_entry-cover">
                                    <img src="<?=$mangas[0]['cover']?>">
                                </div>
                                <div class="profile_user-list_entry-title">
                                    <a href="/manga/<?=str_replace(' ', '-', $mangas[$i]['title'])?>"><?=$mangas[$i]['title']?></a>
                                </div>
                                <div class="profile_user-list_entry-score center-text">
                                    <?=$mangalist[$i]['score']?>
                                </div>
                                <div class="profile_user-list_entry-progress center-text">
                                    <?=$mangalist[$i]['progress']?>/<?=$mangas[0]['chapters']?>
                                </div>
                                <div class="profile_user-list_entry-type center-text">
                                    <?=$mangas[$i]['format']?>
                                </div>
                            </div>
                            <?php
                        }
                    }

                    ?>
                </div>
            </div>

        <?php
    } else {
        print '<i>This seems empty...</i>';
    }
    ?>
</section>