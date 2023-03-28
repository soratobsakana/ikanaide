<div class="profile-wrapper">
    <div class="profile_left-column">
        <img src="/<?=$userInfo['pfp']?>" alt="<?=$userInfo['username']?>">
        <section class="profile_user-info box-wrapper">
            <div class="box-title">
                <h3>Information</h3>
            </div>
            <div class="box-body">
                <ul class="two-column-list">
                    <li><span class="ul_first-column">name</span><span><?=$userInfo['username']?></span></li>
                    <li><span class="ul_first-column">anime</span><span><?=count($animelist)?></span></li>
                    <li><span class="ul_first-column">manga</span><span><?=count($mangalist)?></span></li>
                    <li><span class="ul_first-column">reviews</span><span>0</span></li>
                    <li><span class="ul_first-column">posts</span><span>0</span></li>
                </ul>
            </div>
        </section>

        <section class="profile_user-following box-wrapper">
            <div class="box-title">
                <h3>Social</h3>
            </div>
            <div class="box-body">
                <ul class="two-column-list">
                    <li><span class="ul_first-column">following</span><span>0</span></li>
                    <li><span class="ul_first-column">followers</span><span>0</span></li>
                </ul>
            </div>
        </section>
        <?php

        // Comprobación de los campos que contienen un link. Si existe al menos uno, se creará la sección con los links que han sido asignados por el usuario.
        if (!empty($userInfo['twitter']) || !empty($userInfo['github']) || !empty($userInfo['discord']) || !empty($userInfo['website'])) {
            ?>
            <section class="profile_user-links two-column-list box-wrapper">
                <div class="box-title">
                    <h3>Links</h3>
                </div>
                <div class="box-body">
                    <ul class="two-column-list">
                        <?php

                        $possibleLinks = ['twitter', 'github', 'discord', 'website'];
                        foreach ($possibleLinks as $link) {
                            if (!empty($userInfo[$link])) {
                                ?><li><span class="ul_first-column"><?=$link?></span><span><?=$userInfo[$link]?></span></li><?php
                            }
                        }

                        ?>

                    </ul>
                </div>
            </section>
            <?php
        }

        // Comprobación de los campos que contienen información sobre fechas. Si existe al menos uno, se creará la sección con las fechas  que han sido asignadas por el usuario.
        if (!empty($userInfo['country']) || !empty($userInfo['born']) || !empty($userInfo['joined_at'])) {
            ?>
            <section class="profile_user-data two-column-list box-wrapper">
                <div class="box-title">
                    <h3>Data</h3>
                </div>
                <div class="box-body">
                    <ul class="two-column-list">
                        <?php

                        if (!empty($userInfo['country'])) {
                            ?><li><span class="ul_first-column">from</span><span><?=$userInfo['country']?></span></li><?php
                        }
                        if (!empty($userInfo['born'])) {
                            ?><li><span class="ul_first-column">born</span><span><?=lcfirst(dateFormat(substr($userInfo['born'], 0, 10)))?></span></li><?php
                        }
                        if (!empty($userInfo['joined_at'])) {
                            ?><li><span class="ul_first-column">joined</span><span><?=lcfirst(dateFormat(substr($userInfo['joined_at'], 0, 10)))?></span></li><?php
                        }

                        ?>

                    </ul>
                </div>
            </section>
            <?php
        }

        ?>

    </div>
    <div class="profile_right-column">
        <?php
        if (isset($userInfo['header'])) {
            ?><img src="/<?=$userInfo['header']?>" alt="<?=$userInfo['username']?>"><?php
        }

        ?>

        <nav class="profile_user-nav box-wrapper box-title">
            <ul class="profile_user-nav_ul">
                <?php

                // Este bloque de código muestra un menú de navegación que dinamiza la clase .current en torno a la URI actual.
                // He añadido dos condiciones específicas para 'overview' ya que pretendo mostrar esa pestaña por defecto en la URI '/profile' y no '/profile/overview' (lo cual se generaría sin estas dos condiciones).
                $nav = ['overview', 'animelist', 'mangalist', 'reviews', 'favorites'];
                for ($i=0; $i < count($nav); $i++) {

                    if ($nav[$i] === 'overview' && $page === '/'.$username) {
                        print "<a href='/".$username."'><li class='current'>$nav[$i]</li></a>";
                    } else if ($page === '/'.$username.'/'.$nav[$i]) {
                        print "<a href='/".$username."/".$nav[$i]."'><li class='current'>$nav[$i]</li></a>";
                    } else if ($nav[$i] === 'overview' && $page !== '/'.$username) {
                        print "<a href='/".$username."'><li>$nav[$i]</li></a>";
                    } else {
                        print "<a href='/".$username."/" . $nav[$i] . "'><li>$nav[$i]</li></a>";
                    }

                }
                
                ?>
            </ul>
        </nav>
        <?php

        switch($uri) {
            case '/'.$username:
                require('resources/views/user/_overviewprofile.view.php');
                break;
            case '/'.$username.'/animelist':
                require('resources/views/user/_animelistprofile.view.php');
                break;
            case '/'.$username.'/mangalist':
                require('resources/views/user/_mangalistprofile.view.php');
                break;
            case '/'.$username.'/reviews':
                require('resources/views/user/_reviewsprofile.view.php');
                break;
            case '/'.$username.'/favorites':
                require('resources/views/user/_favoritesprofile.view.php');
                break;
        }
        
        ?>
    </div>
</div>
