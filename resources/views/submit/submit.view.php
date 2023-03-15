<form action="submit_edit" method="POST" class="submit-form">
    <div class="submit-form_title">Edit or add information to the database. A moderator will review it and inform you about any possible changes. Thanks for the effort!</div>
        <?php

        if (isset($animeForm)) {
            require('resources/views/submit/_submit_anime.view.php');
        } else if (isset($mangaForm)) {
            require('resources/views/submit/_submit_manga.view.php');
        } else if (isset($vnForm)) {
            require('resources/views/submit/_submit_vn.view.php');
        } else {
            print 'Information will be here soon...';
        }

        ?>
    <input class="box" type="submit" value="Submit the entry" name="submit">
</form>
