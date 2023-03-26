<section class="profile_user-overview">
    <?php
        if (!empty($userInfo['biography'])) {
            ?>

            <section class="profile_user-overview_bio box-wrapper">
                <div class="box-title">
                    <h3>About me</h3>
                </div>
                <div class="box-body">
                    <p><?=$userInfo['biography']?></p>
                </div>
            </section>

            <?php
        }
    ?>
</section>