<section class="profile_user-animelist">
    <?php
    if (!empty($animelist) && !empty($animes)) {
        ?>

        <section class="profile_user-animelist">
            <div class="profile_user-animelist_header box-wrapper">
                <div class="box-title">
                    <h3>Anime List</h3>
                </div>
                <div class="box-body">
                    <ul class="profile_user-animelist_content-labels animelist-grid">
                        <li>cover</li>
                        <li>title</li>
                        <li>score</li>
                        <li>type</li>
                        <li>progress</li>
                        <li>favorite</li>
                    </ul>
                </div>
            </div>
            <div class="profile_user-animelist_entry-wrapper box-wrapper">
                <div class="box-body">
                    <?php

                    for ($i=0; $i<count($animelist); $i++) {
                        ?>
                        <div class="profile_user-animelist_entry animelist-grid">
                            <div class="profile_user-animelist_entry-cover">
                                <img src="/<?=$animes[0]['cover']?>">
                            </div>
                            <div class="profile_user-animelist_entry-title animelist-grid">
                                <a href="/anime?id=<?=$animes[$i]['anime_id']?>"><?=$animes[$i]['title']?></a>
                            </div>
                            <div class="profile_user-animelist_entry-score animelist-grid">
                                <?=$animelist[$i]['score']?>
                            </div>
                            <div class="profile_user-animelist_entry-type animelist-grid">
                                <?=$animes[$i]['type']?>
                            </div>
                            <div class="profile_user-animelist_entry-progress animelist-grid">
                                <?=$animelist[$i]['progress']?>/<?=$animes[0]['episodes']?>
                            </div>
                            <div class="profile_user-animelist_entry-favorite animelist-grid">
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

                    ?>
                </div>
            </div>
        </section>

        <?php
    } else {
        print '<i>This seems empty...</i>';
    }
    ?>
</section>