<header>
    <div class="inner-header">
        <p id="header-logo">ikanaide</p>
        <ul class="header-links">
            <li>home</li>
            <li>anime</li>
            <li>manga</li>
            <li>rankings</li>
            <li>community</li>
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