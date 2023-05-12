<div class="mediumhome">
    <section class="mediumhome_all-medium box-wrapper">
        <div class="box-wrapper box-title">
            <h3>All <?=ucfirst($medium)?></h3>
        </div>
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
        </section>
</div>