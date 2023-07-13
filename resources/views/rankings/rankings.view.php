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
    <section class="rankings-page_list-labels box-wrapper">
        <div class="box-title">
            <h3><?=ucfirst($medium)?> rankings</h3>
        </div>
        <ul class=" box-body">
            <li class="low-opacity center-text">rank</li>
            <li class="low-opacity"></li>
            <li class="low-opacity">title</li>
            <li class="low-opacity center-text">score</li>
            <li class="low-opacity center-text">members</li>
        </ul>
    </section>
    <?php

    switch($page) {
        case '/rankings':
        case '/rankings/manga':
        case '/rankings/anime':
            require '../resources/views/rankings/_ranking.view.php';
            break;
        default:
            header('Location: /404');
    }

    ?>
</div>