<section class="profile_user-favorites">
    <?php

    if (isset($favoriteAnimes)){
        ?>
        
        <section class="profile_user-favorites_medium box-wrapper">
            <div class="box-title"><h3>Favourite anime</h3></div>
            <div class="profile_user-favorites_wrapper querypage_bg">
        
            <?php
            if ($favoriteAnimes -> num_rows > 0) {
                while ($row = $favoriteAnimes -> fetch_assoc()) {
                    ?><a href="/anime?id=<?=$row['anime_id']?>"><img src="<?=$row['cover']?>" alt=""></a><?php
                }
            }

            ?>
        
            </div>
        </section>
        
        <?php
    }

    if (isset($favoriteMangas)){
        ?>
        
        <section class="profile_user-favorites_medium box-wrapper">
            <div class="box-title"><h3>Favourite manga</h3></div>
            <div class="profile_user-favorites_wrapper querypage_bg">
        
            <?php

                if (isset($favoriteMangas)){
                    if ($favoriteMangas -> num_rows > 0) {
                        while ($row = $favoriteMangas -> fetch_assoc()) {
                            ?><a href="/manga?id=<?=$row['manga_id']?>"><img src="<?=$row['cover']?>" alt=""></a><?php
                        }
                    }
                }
                
                ?>
        
            </div>
        </section>
        
        <?php
    }

    ?>
    
</section>