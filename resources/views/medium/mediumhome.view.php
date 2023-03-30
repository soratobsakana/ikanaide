<div class="mediumhome">
    <div class="mediumhome_all-medium">
        <div class="mediumhome_all-medium_content">
            <?php

            if ($homeInfo -> num_rows > 0) {
                while ($row = $homeInfo -> fetch_assoc()) {
                    ?>
                    <a href="/<?=$medium?>/<?=str_replace(' ', '-', $row['title'])?>"><img src="<?=$row['cover']?>" alt="<?=$row['title']?>"></a>
                    <?php
                }
            }

            ?>
        </div>
    </div>
</div>