<section class="profile_user-overview">
    <?php
        if (!empty($userInfo['biography'])) {
            ?>

            <section class="profile_user-overview_bio box">
                <p><?=$userInfo['biography']?></p>
            </section>

            <?php
        }
    ?>

</section>