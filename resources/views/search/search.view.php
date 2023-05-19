<div class="search-page_wrapper box-wrapper">
    <section class="search-page_header box-wrapper">
        <div class="box-title">
            <h3>Search</h3>
        </div>
        <div class="box-body">
            <form action="/search" method="GET" class="search-page_form">
                <?php

                if (isset($postResults)) {
                    $inputPlaceholder = $postResults['title'];
                } else if (isset($keyword)) {
                    $inputPlaceholder = $keyword;
                }

                ?>
                <input type="text" name="keyword" id="search-query" autocomplete="off" placeholder="Type a keyword..." value="<?php if (isset($inputPlaceholder)) {echo $inputPlaceholder;} ?>">
                <input type="submit" value="Search">
            </form>
        </div>
    </section>

    <?php

    if (isset($postResults)) {
        ?>

        <section class="search-page_results">
            <section class="posts-wrapper box-wrapper">
                <div class="box-title box-title_two-column">
                    <h3>Showing last posts about <?=$postResults['title']?> </h3>
                    <p class="low-opacity">Showing <?=count($postResults) - 2?> posts</p> <!-- Resto 2 por los valores de $postResults['title'] y $postResults['medium'] -->
                </div>
                <div class="box-body">
                <?php

                for ($i = 0; $i < count($postResults) - 2; $i++) {
                    ?>

                    <div class="post-entry box-wrapper box-body" onclick="window.location='/activity/<?=$postResults[$i]['post']['post_id']?>'">

                        <div class="top">
                            <a href="/<?=$postResults[$i]['user']['username']?>"><img src="<?=$postResults[$i]['user']['pfp']?>" alt=""></a>
                            <div class="post-info">
                                <div class="post-info_user">
                                    <div class="username">
                                        <div><span><?=$postResults[$i]['user']['username']?></span><span class="post_time-ago">&nbsp;&nbsp;·&nbsp;&nbsp;<?=$postResults[$i]['post']['time_ago']?></span></div>
                                        <div><span class="material-icons dots">more_horiz</span></div>
                                    </div>
                                </div>
                                <div class="post-info_relation">
                                    <?php

                                    if (isset($postResults[$i]['post']['replying_to']) && isset($postResults[$i]['post']['medium_id'])) {
                                        ?><span class="low-opacity">replying to <?=$postResults[$i]['post']['replying_to']?> on <?=$postResults[$i]['post']['medium_title']?></span><?php
                                    } else if (isset($postResults[$i]['post']['replying_to'])) {
                                        ?><span class="low-opacity">replying to <?=$postResults[$i]['post']['replying_to']?></span><?php
                                    } else if (isset($postResults[$i]['post']['medium_id'])) {
                                        ?><span class="low-opacity">on <?=$postResults[$i]['post']['medium_title']?></span><?php
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="bottom">
                            <div class="content"><?=htmlspecialchars($postResults[$i]['post']['content'])?></div>
                            <div class="social">
                                <div class="social-icon">
                                    <span class="material-icons-outlined" id="display-reply">chat_bubble_outline</span>
                                    <p><?=$postResults[$i]['post']['reply_count']?></p>
                                </div>
                                <a href="/like?id=<?=$postResults[$i]['post']['post_id']?>">
                                    <div class="social-icon">
                                        <span class="material-icons-outlined">
                                            <?= $postResults[$i]['user']['liked'] ? "favorite" : "favorite_border" ?>
                                        </span>
                                        <p><?=$postResults[$i]['post']['like_count']?></p>
                                    </div>
                                </a>

                                <div class="social-icon">
                                    <span class="material-icons-outlined">
                                        <?= $postResults[$i]['user']['bookmarked'] ? "bookmark" : "bookmark_border" ?>
                                    </span>
                                    <p><?=$postResults[$i]['post']['bookmark_count']?></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php
                }

                ?>
                </div>
            </section>
        </section>

        <?php
    } else if (isset($searchResults)) {
        ?>

        <section class="search-page_keyword-results box-wrapper">

        <?php

        if (isset($searchResults['anime'])) {
            ?>
            <div class="box-wrapper">
            <div class="box-title">
                <h3><?=count($searchResults['anime'])?> search <?=count($searchResults['anime']) === 1 ? 'result' : 'results' ?> on posts about "<?=$keyword?>"</h3>
            </div>
            <div class="box-body">

            <?php
            foreach ($searchResults['anime'] as $animeResult) {
                ?>

                <a href="/search?medium=anime&id=<?=$animeResult['anime_id']?>">
                    <div class="result">
                        <h4><?=$animeResult['title']?></h4>
                        <p class="low-opacity"><?=$animeResult['post_count']?> <?=$animeResult['post_count'] === 1 ? 'post' : 'posts'?></p>
                    </div>
                </a>

                <?php
            }
            ?>
                </div>
                </div>
            <?php
        }

        if (isset($searchResults['manga'])) {
            ?>
            <div class="box-wrapper">
            <div class="box-title">
                <h3><?=count($searchResults['manga'])?> search <?=count($searchResults['manga']) === 1 ? 'result' : 'results' ?> on posts about "<?=$keyword?>"</h3>
            </div>
            <div class="box-body">

            <?php
            foreach ($searchResults['manga'] as $mangaResult) {
                ?>

                <a href="/search?medium=manga&id=<?=$mangaResult['manga_id']?>">
                    <div class="result">
                        <h4><?=$mangaResult['title']?></h4>
                        <p class="low-opacity"><?=$mangaResult['post_count']?> <?=$mangaResult['post_count'] === 1 ? 'post' : 'posts'?></p>
                    </div>
                </a>

                <?php
            }
            ?>
                </div>
                </div>
            <?php
        }

        ?>

        </section>
         <?php
    } else if (isset($keyword)) {
        ?><div class="box-wrapper box-body">
            <p>There doesn't seem to be an entry for that in the database...</p>
        </div>
        <?php
    }

    ?>

</div>