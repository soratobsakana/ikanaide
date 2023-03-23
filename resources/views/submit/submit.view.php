<?php $page = parse_url($_SERVER['REQUEST_URI'])['path']; ?>
<form action="/submit?<?=substr($page, 8, strlen($page))?>" method="POST" class="submit-form">
    <div class="submit-form_title">Submit information to the database. A moderator will review it and inform you about any possible changes. Thanks for the effort!</div>
    <nav class="submit-form_selector">
        <ul class="box">
            <?php
                $nav = ['anime', 'manga', 'vn', 'character', 'staff'];
                highlightNav($nav, 8);
            ?>
        </ul>
    </nav>
    <?php
    switch ($page) {
        case '/submit/anime':
            readfile('resources/views/submit/_submit_anime.view.html');
            break;
        case '/submit/manga':
            readfile('resources/views/submit/_submit_manga.view.html');
            break;
        case '/submit/vn':
            readfile('resources/views/submit/_submit_vn.view.html');
            break;
        case '/submit/character':
            readfile('resources/views/submit/_submit_character.view.html');
            break;
        case '/submit/staff':
            readfile('resources/views/submit/_submit_staff.view.html');
            break;
        default:
            header('Location: /submit/anime');
    }
    ?>
    <input class="box" id="submit-button__colorful" type="submit" value="Submit" name="submit">
</form>
