<div class="animehome">
    <div class="animehome_all-anime">
        <div class="animehome_all-anime_content">
            <?php

            if ($result -> num_rows > 0) {
                while ($row = $result -> fetch_assoc()) {
                    ?>
                    <a href="/anime?id=<?=$row['anime_id']?>"><img src="<?=$row['cover']?>" alt="<?=$row['title']?>"></a>
                    <?php
                }
            }

            ?>
        </div>
    </div>
</div>