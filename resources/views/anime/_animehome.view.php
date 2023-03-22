<div class="mediumhome">
    <div class="mediumhome_all-medium">
        <div class="mediumhome_all-medium_content">
            <?php

            if ($homeInfo -> num_rows > 0) {
                while ($row = $homeInfo -> fetch_assoc()) {
                    switch ($page) {
                        case '/anime':
                            ?>
                            <a href="/anime?id=<?=$row['anime_id']?>"><img src="<?=$row['cover']?>" alt="<?=$row['title']?>"></a>
                            <?php
                            break;
                        case '/manga':
                            ?>
                            <a href="/manga?id=<?=$row['manga_id']?>"><img src="<?=$row['cover']?>" alt="<?=$row['title']?>"></a>
                            <?php
                            break;
                        case '/vn':
                            ?>
                            <a href="/vn?id=<?=$row['vn_id']?>"><img src="<?=$row['cover']?>" alt="<?=$row['title']?>"></a>
                            <?php
                            break;
                    }
                }
            }

            ?>
        </div>
    </div>
</div>