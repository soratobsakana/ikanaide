<div class="querypage_left-column">
    <img src="<?=$mediumInfo['cover']?>" alt="<?=$mediumInfo['title']?>"/>
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
                    ?><li><span class="ul_first-column"><?=removeUnderscore($column)?></span><span><?=$mediumInfo[$column]?></span></li><?php
                }

                ?>
            </ul>
        </div>
    </section>