<div class="rankings-page_wrapper">
    <nav class="rankings-page_menu">
        <ul class="box-wrapper box-body">
            <?php

            $menuFields = ['anime', 'manga', 'vn', 'soundtracks', 'openings', 'endings'];
            foreach($menuFields as $field) {
                if ($page === '/rankings/' . $field) {
                    echo '<a href="/rankings/'.$field.'"><li style="opacity: 1">top ' . $field .'</li></a>';
                } else {
                    echo '<a href="/rankings/'.$field.'"><li class="low-opacity">top ' . $field .'</li></a>';
                }
            }

            ?>
        </ul>
    </nav>
    <section class="rankings-page_list-labels">
        <ul class="box-wrapper box-body">
            <li class="low-opacity">rank</li>
            <li class="low-opacity">title</li>
            <li class="low-opacity">score</li>
            <li class="low-opacity">members</li>
        </ul>
    </section>
    <?php

    switch($page) {
        case '/rankings/anime':
            require 'resources/views/rankings/_animeranking.php';
            break;
        case '/rankings/manga':
            require 'resources/views/rankings/_mangaranking.php';
            break;
        case '/rankings/vn':
            require 'resources/views/rankings/_vnranking.php';
            break;
        case '/rankings/soundtracks':
            require 'resources/views/rankings/_ostranking.php';
            break;
        case '/rankings/openings':
            require 'resources/views/rankings/_openingranking.php';
            break;
        case '/rankings/endings':
            require 'resources/views/rankings/_endingranking.php';
            break;
        default:
            header('Location: /404');
    }

    ?>
</div>