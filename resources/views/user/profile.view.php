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
                            <button type="button" id="user_edit-profile_btn" class="list-submit submit-button__colorful box">Edit profile</button>
                        </form>
                     </section>
                    <?php
                } else if ($_COOKIE['session'] === 'Yes' && $_COOKIE['username'] !== $userInfo['username']) {
                    ?>
                    <section class="profile_left-column_buttons">
                        <form action="/follow?id=<?=$userInfo['user_id']?>" method="post">
                        <?php

                        if (\App\Following::isFollowing($_COOKIE['user_id'], $userId)) {
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
                    <li><span class="ul_first-column">posts</span><span><?=is_null($postCount) ? $userPostsCount = 0 : $userPostsCount = $postCount;?></span></li>
                    <li><span class="ul_first-column">submissions</span><span>0</span></li>
                    <li><span class="ul_first-column">threads</span><span>0</span></li>
                    <li><span class="ul_first-column">following</span><span><?=is_null($followCount['following']) ? 0 : $followCount['following'];?><span></li>
                    <li><span class="ul_first-column">followers</span><span><?=is_null($followCount['followers']) ? 0 : $followCount['followers'];?><span></li>
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
                        $value = $statusCounter['anime'][$row] ?? 0;
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
                        $value = $statusCounter['manga'][$row] ?? 0;
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

        if (isset($userInfo['user_id'], $_COOKIE['user_id']) && ($userInfo['user_id'] != $_COOKIE['user_id'])) {
            ?><span id="user-report_btn" class="user-report material-icons dots center-text low-opacity">more_horiz</span><?php
        }

        ?>

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
                require('../resources/views/user/_overviewprofile.view.php');
                break;
            case '/'.$username.'/animelist':
            case '/'.$username.'/mangalist':
                require('../resources/views/user/_listsprofile.view.php');
                break;
            case '/'.$username.'/reviews':
                require('../resources/views/user/_reviewsprofile.view.php');
                break;
            case '/'.$username.'/favorites':
                require('../resources/views/user/_favoritesprofile.view.php');
                break;
        }
        
        ?>
    </div>
</div>

<section class="modal" id="user_post-wrapper">
    <div class="box-wrapper">
        <div class="box-title"><h3>Make a post</h3></div>
        <div class="box-body">
            <form action="/post" method="post">
                <label for="post-content">This post will appear in your profile and your followers time line.</label>
                <textarea name="post-content" id="post-content" autocomplete="off" required></textarea>
                <p class="label">Is this post about any anime or manga?</p>
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

<section id="user_edit-profile" class="modal">
    <div class="box-wrapper">
        <div class="box-title">
            <h3>Edit profile</h3>
        </div>
        <div class="box-body">
            <form action="/ep" method="post" enctype="multipart/form-data">
                <div class="edit-profile_files">
                    <div>
                        <label for="edit-profile_pfp" class="pfp">Change your avatar</label>
                        <input type="file" name="edit-profile_pfp" id="edit-profile_pfp">
                    </div>
                    <div>
                        <label for="edit-profile_header" class="header">Change your header</label>
                        <input type="file" name="edit-profile_header" id="edit-profile_header">
                    </div>
                </div>
                <label for="edit-profile_bio">About me</label>
                <textarea name="edit-profile_bio" id="edit-profile_bio" autocomplete="off"><?=$userInfo['biography']?></textarea>
                <div class="two-column">
                    <div>
                        <label for="edit-profile_country">Country</label>
                        <input value="<?=$userInfo['country']?>" type="text" name="edit-profile_country" id="edit-profile_country" autocomplete="off">
                    </div>
                    <div>
                        <label for="edit-profile_birthday">Birthday</label>
                        <input value="<?=$userInfo['born']?>" type="date" name="edit-profile_birthday" id="edit-profile_birthday" autocomplete="off">
                    </div>
                    <div>
                        <label for="edit-profile_twitter">Twitter</label>
                        <input value="<?=$userInfo['twitter']?>" type="text" name="edit-profile_twitter" placeholder="Twitter username" id="edit-profile_twitter" autocomplete="off">
                    </div>
                    <div>
                        <label for="edit-profile_github">GitHub</label>
                        <input value="<?=$userInfo['github']?>" type="text" name="edit-profile_github" placeholder="GitHub username"id="edit-profile_github" autocomplete="off">
                    </div>
                    <div>
                        <label for="edit-profile_discord">Discord</label>
                        <input value="<?=$userInfo['discord']?>" type="text" name="edit-profile_discord" placeholder="example#9999" id="edit-profile_discord" autocomplete="off">
                    </div>
                    <div>
                        <label for="edit-profile_website">Website</label>
                        <input value="<?=$userInfo['website']?>" type="text" name="edit-profile_website" placeholder="Complete URL" id="edit-profile_website" autocomplete="off">
                    </div>
                </div>
                
                <hr id="edit-profile_fields-separator">
                <div class="edit_profile-fields_buttons">
                    <button type="button" id="user_edit-profile_cancel" class="submit-button__colorful box">Cancel</button>
                    <input class="submit-button__colorful box" type="submit" name='edit-profile_submit' value="Submit">
                </div>
            </form>
        </div>
    </div>
</section>

<?php

if (isset($userInfo['user_id'], $_COOKIE['user_id']) && ($userInfo['user_id'] != $_COOKIE['user_id'])) {
    ?>
    <section id="user-report_modal" class="modal">
    <div class="box-wrapper">
        <div class="box-title">
            <h3>Report user</h3>
        </div>
        <div class="box-body">
            <form action="/report?id=<?=$userInfo['user_id']?>" method="post">
                <label for="user-report_reason">Reason</label>
                <textarea name="reason" id="user-report_reason" autocomplete="off"></textarea>
                <hr id="edit-profile_fields-separator">
                <div class="buttons">
                    <button type="button" id="user-report_cancel" class="submit-button__colorful box">Cancel</button>
                    <input type="submit" class="submit-button__colorful box" value="Submit">
                </div>
            </form>
        </div>
    </div>
</section>
<?php
}

?>


<script !src="">
    let editBtn = document.getElementById('user_edit-profile_btn');
    let editModal = document.getElementById('user_edit-profile');
    let editCancelBtn = document.getElementById('user_edit-profile_cancel');

    editBtn.addEventListener('click', function() {
        editModal.style.display = "block";
        document.getElementById("edit-profile_bio").focus();
    })

    editCancelBtn.addEventListener('click', function() {
        editModal.style.display = "none";
    })
</script>

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

<script !src="">
    let reportBtn = document.getElementById('user-report_btn');
    let reportModal = document.getElementById('user-report_modal');
    let reportCancelBtn = document.getElementById('user-report_cancel');

    reportBtn.addEventListener('click', function() {
        reportModal.style.display = "block";
        document.getElementById("user-report_reason").focus();
    })

    reportCancelBtn.addEventListener('click', function() {
        reportModal.style.display = "none";
    })
</script>