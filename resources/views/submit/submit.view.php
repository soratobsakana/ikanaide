<?php $page = parse_url($_SERVER['REQUEST_URI'])['path']; ?>
<form action="/submit?<?=substr($page, 8, strlen($page))?>" method="POST" class="submit-form" enctype="multipart/form-data">
    <div class="submit-form_title">Submit information to the database. A moderator will review it and inform you about any possible changes. Thanks for the effort!</div>
    <nav class="submit-form_selector">
        <ul class="box">
            <?php
                $nav = ['anime', 'manga', 'character', 'staff'];
                highlightNav($nav, 8);
            ?>
        </ul>
    </nav>
    <?php
    switch ($page) {
        case '/submit/anime':
            require('../resources/views/submit/_submit_anime.view.php');
            break;
        case '/submit/manga':
            require('../resources/views/submit/_submit_manga.view.php');
            break;
        case '/submit/character':
            require('../resources/views/submit/_submit_character.view.php');
            break;
        case '/submit/staff':
            require('../resources/views/submit/_submit_staff.view.php');
            break;
        default:
            header('Location: /submit/anime');
    }
    ?>
    <input class="submit-button__colorful box" id="submit" type="submit" value="Submit" name="submit">
</form>