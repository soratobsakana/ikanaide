<div class="mediumhome">
    <div class="mediumhome_all-medium">
        <div class="mediumhome_all-medium_content">
            <?php

            if ($homeInfo -> num_rows > 0) {
                while ($row = $homeInfo -> fetch_assoc()) {
                    ?>
                    <a href="/<?=$medium?>/<?=str_replace(' ', '-', $row['title'])?>"><div style="background-image: url('<?=$row['cover']?>')"></div></a>
                    <?php
                }
            }

            ?>
        </div>
    </div>
</div>