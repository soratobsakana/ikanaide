<section class="rankings-page_anime_wrapper box-wrapper box-body">
    <section class="rankings-page_anime_content">
        <?php
        
        if (!is_null($ranking)) {
            for($i=0; $i<count($ranking); $i++) {
                ?>
    
                <div class="rankings-page_anime_content-entry">
                    <div class="center-text"><h3>#<?=$ranking[$i]['rank']?></h3></div>
                    <div><a href="/<?=$medium?>/<?=str_replace(' ', '-', $ranking[$i]['title'])?>"><img src="<?=$ranking[$i]['cover']?>" alt=""></a></div>
                    <div class="low-opacity"><a href="/<?=$medium?>/<?=str_replace(' ', '-', $ranking[$i]['title'])?>"><?=$ranking[$i]['title']?></a></div>
                    <div class="center-text"><?=$ranking[$i]['score']?></div>
                    <div class="center-text"><?=$ranking[$i]['members']?></div>
                    <div class="add">
                        <?php

                        if (isset($_COOKIE['session'])) {
                            if ($ranking[$i]['userList'] === TRUE) {
                                ?><a class="ranking-list_button" href="/rankingList?medium=<?=$medium?>&id=<?=$ranking[$i][$medium.'_id']?>&action=delete">delete from list</a><?php
                            } else {
                                ?><a class="ranking-list_button" href="/rankingList?medium=<?=$medium?>&id=<?=$ranking[$i][$medium.'_id']?>&action=add">add to list</a><?php
                            }
                        }

                        ?>
                        
                    </div>
                    <div class="fav">
                        <?php

                        if (isset($_COOKIE['session'])) {
                            if ($ranking[$i]['userList'] === TRUE && $ranking[$i]['userFav'] === TRUE) {
                                ?><a class="ranking-list_button" href="/rankingList?medium=<?=$medium?>&id=<?=$ranking[$i][$medium.'_id']?>&action=unfav"><span class="material-icons-outlined">favorite</span></a><?php
                            } else if ($ranking[$i]['userList'] === TRUE && $ranking[$i]['userFav'] === FALSE) {
                                ?><a class="ranking-list_button" href="/rankingList?medium=<?=$medium?>&id=<?=$ranking[$i][$medium.'_id']?>&action=fav"><span class="material-icons-outlined">favorite_border</span></a><?php
                            }
                        }

                        ?>
                    </div>
                    <div class="options low-opacity link">
                        <span class="material-icons-outlined">
                            more_vert
                        </span>

                    </div>
                </div>
            
                <?php
            }
        } else {
            print '<i class="center-text">This seems empty...</i>';
        }

        ?>
        
    </section>
</section>