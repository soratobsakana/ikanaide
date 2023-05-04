<div class="profile-wrapper">
    <div class="profile_left-column">
        <img src="<?=$userInfo['pfp']?>" alt="<?=$userInfo['username']?>">

            <?php

            if (isset($_COOKIE["session"], $_COOKIE["username"])) {
                if ($_COOKIE['session'] === 'Yes' && $_COOKIE['username'] === $userInfo['username']) {
                    ?>
                     <section class="profile_left-column_buttons">
                        <form action="" method="post">
                            <button type="button" id="user-post_button" class="list-submit submit-button__colorful box">Make a post</button>
                            <input class="list-submit box submit-button__colorful" type="submit" value="Edit profile">
                        </form>
                     </section>
                    <?php
                } else if ($_COOKIE['session'] === 'Yes' && $_COOKIE['username'] !== $userInfo['username']) {
                    ?>
                    <section class="profile_left-column_buttons">
                        <form action="/follow?id=<?=$userInfo['user_id']?>" method="post">
                        <?php

                        if ($Following -> isFollowing($followingUser, $followedUser)) {
                            ?><input class="list-submit box submit-button__colorful" name="unfollow" type="submit" value="Unfollow"><?php
                        } else {
                            ?><input class="list-submit box submit-button__colorful" name="follow" type="submit" value="Follow"><?php
                        }

                        ?>
                            
                            
                        </form>
                    </section>
                    <?php
                }
            }

            ?>


        <section class="profile_user-info box-wrapper">
            <div class="box-title">
                <h3><?=$userInfo['username']?></h3>
            </div>
            <div class="box-body">
                <ul class="two-column-list">
                    <li><span class="ul_first-column">posts</span><span><?=is_null($userPosts) ? $userPostsCount = 0 : $userPostsCount = count($userPosts['posts']);?></span></li>
                    <li><span class="ul_first-column">submissions</span><span>0</span></li>
                    <li><span class="ul_first-column">threads</span><span>0</span></li>
                    <li><span class="ul_first-column">following</span><span>0</span></li>
                    <li><span class="ul_first-column">followers</span><span>0</span></li>
                </ul>
            </div>
        </section>

        <section class="profile_user-medium_stats box-wrapper">
            <div class="box-title">
                <h3>Anime Stats</h3>
            </div>
            <div class="box-body">
                <ul class="two-column-list">
                    <?php

                    $statsRows = ['watching', 'completed', 'planned', 'stalled', 'dropped'];
                    foreach ($statsRows as $row) {
                        isset($animes[$row]) ? $value = count($animes[$row]) : $value = 0;
                        ?><li><span class="ul_first-column"><?=$row?></span><span><?=$value?></span></li><?php
                    }

                    ?>
                </ul>
            </div>
        </section>

        <section class="profile_user-medium_stats box-wrapper">
            <div class="box-title">
                <h3>Manga Stats</h3>
            </div>
            <div class="box-body">
                <ul class="two-column-list">
                    <?php

                    $statsRows = ['reading', 'completed', 'planned', 'stalled', 'dropped'];
                    foreach ($statsRows as $row) {
                        isset($mangas[$row]) ? $value = count($mangas[$row]) : $value = 0;
                        ?><li><span class="ul_first-column"><?=$row?></span><span><?=$value?></span></li><?php
                    }

                    ?>
                </ul>
            </div>
        </section>

        <?php
        // Comprobación de los campos que contienen información sobre fechas. Si existe al menos uno, se creará la sección con las fechas  que han sido asignadas por el usuario.
        if (!empty($userInfo['country']) || !empty($userInfo['born']) || !empty($userInfo['joined_at'])) {
        ?>
        <section class="profile_user-data two-column-list box-wrapper">
            <div class="box-title">
                <h3>Information</h3>
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

        <span class="user-report material-icons dots center-text low-opacity">more_horiz</span>

    </div>
    <div class="profile_right-column">
        <?php
        if (isset($userInfo['header'])) {
            ?><img src="<?=$userInfo['header']?>" alt="<?=$userInfo['username']?>"><?php
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
            case '/'.$username.'/mangalist':
                require('resources/views/user/_listsprofile.view.php');
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

<section id="user_post-wrapper">
    <div class="box-wrapper">
        <div class="box-title"><h3>Make a post</h3></div>
        <div class="box-body">
            <form action="/post" method="post">
                <label for="post-content">This post will appear in your profile and your followers time line.</label>
                <textarea name="post-content" id="post-content" autocomplete="off" required></textarea>
                <label for="on-medium">Is this post about any anime or manga?</label>
                <select name="on-medium" id="on-medium">
                    <option disabled selected>Select an anime or manga</option>
                    <?php

                    foreach ($select as $option) {
                        ?><option value="<?=$option?>"><?=$option?></option><?php
                    }

                    ?>
                </select>
                <hr id="user_post_fields-separator">
                <div class="user_post_fields-buttons">
                    <button type="button" id="user-post_cancel" class="submit-button__colorful box">Cancel</button>
                    <input class="submit-button__colorful box" type="submit" name='post' value="Post">
                </div>
            </form>
        </div>
    </div>
</section>

<script !src="">
    let modal = document.getElementById('user_post-wrapper');
    let btn = document.getElementById('user-post_button');
    let cancelBtn = document.getElementById('user-post_cancel');

    btn.addEventListener('click', function() {
        modal.style.display = "block";
        document.getElementById("post-content").focus();
    })

    cancelBtn.addEventListener('click', function() {
        modal.style.display = "none";
    })

</script>