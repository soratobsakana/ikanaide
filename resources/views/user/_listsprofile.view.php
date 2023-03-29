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
                        <li>score</li>
                        <?php $medium === 'anime' ? $type = 'type' : $type = 'format' ?>
                        <li><?=$type?></li>
                        <li>progress</li>
                        <li>favorite</li>
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
                                    <img src="<?=$animes[0]['cover']?>">
                                </div>
                                <div class="profile_user-list_entry-title list-grid">
                                    <a href="/anime?id=<?=$animes[$i]['anime_id']?>"><?=$animes[$i]['title']?></a>
                                </div>
                                <div class="profile_user-list_entry-score list-grid">
                                    <?=$animelist[$i]['score']?>
                                </div>
                                <div class="profile_user-list_entry-type list-grid">
                                    <?=$animes[$i]['type']?>
                                </div>
                                <div class="profile_user-list_entry-progress list-grid">
                                    <?=$animelist[$i]['progress']?>/<?=$animes[0]['episodes']?>
                                </div>
                                <div class="profile_user-list_entry-favorite list-grid">
                                    <?php

                                    if ($animelist[$i]['favorite'] === 1) {
                                        print 'Yes';
                                    } else {
                                        print 'No';

                                    }

                                    ?>
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
                                <div class="profile_user-list_entry-title list-grid">
                                    <a href="/manga?id=<?=$mangas[$i]['manga_id']?>"><?=$mangas[$i]['title']?></a>
                                </div>
                                <div class="profile_user-list_entry-score list-grid">
                                    <?=$mangalist[$i]['score']?>
                                </div>
                                <div class="profile_user-list_entry-type list-grid">
                                    <?=$mangas[$i]['format']?>
                                </div>
                                <div class="profile_user-list_entry-progress list-grid">
                                    <?=$mangalist[$i]['progress']?>/<?=$mangas[0]['chapters']?>
                                </div>
                                <div class="profile_user-list_entry-favorite list-grid">
                                    <?php

                                    if ($mangalist[$i]['favorite'] === 1) {
                                        print 'Yes';
                                    } else {
                                        print 'No';

                                    }

                                    ?>
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