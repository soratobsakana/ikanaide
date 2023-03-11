<?php
    
?>

<form action="app/controllers/submit.php" method="POST" class="submit-form">
    <div class="submit-form_title">Edit or add information to the database. A moderator will review it and inform you about any possible changes. Thanks for the effort!</div>

    <?php
    if (isset($anime_id) || isset($manga_id) || isset($vn_id)) {
        if (isset($anime_id)) {
            foreach ($animeInfo as $key => $value) {
                if (!($key === 'members' || $key === 'favorited' || $key === 'anime_id')) {
                    $animeForm[$key] = $value;
                }
            }
            require('_submit_anime.view.php');
        } else if (isset($manga_id)) {
            print "manga";
        } else if (isset($vn_id)) {
            print "vn";
        }
    } else {
        print "submit new entry";
    }

    ?>

    <input class="box" type="submit" value="Submit the entry" name="submit">
</form>