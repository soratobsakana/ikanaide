<div class="rankings-page_wrapper">
    <nav class="rankings-page_menu">
        <ul class="box-wrapper box-body">
            <?php

            $menuFields = ['anime', 'manga'];
            foreach($menuFields as $field) {
                if ($page === '/rankings/' . $field) {
                    echo '<a href="/rankings/'.$field.'"><li class="current-ranking">top ' . $field .'</li></a>';
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
        case '/rankings':
        case '/rankings/anime':
            require 'resources/views/rankings/_animeranking.view.php';
            break;
        case '/rankings/manga':
            require 'resources/views/rankings/_mangaranking.view.php';
            break;
        default:
            header('Location: /404');
    }

    ?>
</div>