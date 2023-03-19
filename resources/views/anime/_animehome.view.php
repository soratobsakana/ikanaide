<div class="animehome">
    <div class="animehome_all-anime">
        <div class="animehome_all-anime_content">
            <?php

            if ($result -> num_rows > 0) {
                while ($row = $result -> fetch_assoc()) {
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