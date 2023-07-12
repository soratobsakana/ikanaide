<header>
    <div class="inner-header">
        <a href="/"><img class="header-logo" src="/brand/logo_white.png" alt="ikanaide"></a>
        <ul class="header-links">
            <?php
            $headerGuide = explode('/', $page);
                $nav = ['home', 'anime', 'manga', 'rankings', 'search'];
                for ($i=0; $i < count($nav); $i++) {
                    // $page comes from /index.php (it stores the current URI).
                    if ($nav[$i] === $headerGuide[1]) {
                        print "<a href='/".$nav[$i]."'><li class='current'>$nav[$i]</li></a>";
                    } else {
                        print "<a href='/".$nav[$i]."'><li>$nav[$i]</li></a>";
                    }
                }
            ?>
        </ul>
        <div class="header-user">
            <?php

            // La cookie 'session' es generada en User::login() o User::register().
            if (!isset($_COOKIE['session'])) {
                ?>
                <ul class="header-user-ul">
                    <a href="/login"><li>Sign in</li></a>
                    <a href="/register"><li>Sign up</li></a>
                </ul>
                <?php
            } else {
                if ($_COOKIE['session'] === "Yes") {
                    ?>
                    <ul class="header-user-ul">
                        <a href="/<?=$_COOKIE['username']?>"><li><?=$_COOKIE['username']?></li></a>
                    </ul>
                    <?php
                }
            }

            ?>
        </div>
    </div>
</header>