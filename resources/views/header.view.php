<header>
    <div class="inner-header">
        <a href="/"><p id="header-logo">ikanaide</p></a>
        <ul class="header-links">
            <a href="/"><li>home</li></a>
            <a href="/anime"><li>anime</li></a>
            <a href="/manga"><li>manga</li></a>
            <a href="/rankings"><li>rankings</li></a>
            <a href="/community"><li>community</li></a>
        </ul>
        <div class="header-user">
            <?php
            if (isset($_SESSION['loggedin'])) {
                ?>
                <img src="/storage/testing/1.png" alt="">
                <?php
            } else {
                ?>
                <ul class="header-user-ul">
                    <li>Sign in</li>
                    <li>Sign up</li>
                </ul>
                <?php
            }
            ?>
        </div>
    </div>
</header>