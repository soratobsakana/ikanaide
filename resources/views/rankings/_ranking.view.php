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
                        <a href="">
                            <button type="button" class="ranking-button">delete</button>
                        </a>
                    </div>
                    <div class="fav">
                        <a href="">
                            <button type="button" class="ranking-button">
                               unfavourite
                            </button>
                        </a>
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