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
                    ?><a href="/anime/<?=str_replace(' ', '-', $row['title'])?>"><div style="background-image: url(<?=$row['cover']?>)"></div></a><?php
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

            if ($favoriteMangas -> num_rows > 0) {
                while ($row = $favoriteMangas -> fetch_assoc()) {
                    ?><a href="/manga/<?=str_replace(' ', '-', $row['title'])?>?>"><div style="background-image: url(<?=$row['cover']?>)"></div></a><?php
                }
            }

                ?>
        
            </div>
        </section>
        
        <?php
    }

    ?>
    
</section>