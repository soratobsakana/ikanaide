<form action="edit?<?=$medium . '=' . $id?>" method="POST" class="edit-form">
    <div class="edit-form_title">Edit or add information to the database. A moderator will review it and inform you about any possible changes. Thanks for the effort!</div>
        <?php

        if (isset($animeForm)) {
            require('resources/views/edit/_edit_anime.view.php');
        } else if (isset($mangaForm)) {
            require('resources/views/edit/_edit_manga.view.php');
        } else if (isset($vnForm)) {
            require('resources/views/edit/_edit_vn.view.php');
        } else {
            header('Location: /404');
        }

        ?>
    <input class="box" type="submit" value="Submit the entry" name="submit">
</form>
