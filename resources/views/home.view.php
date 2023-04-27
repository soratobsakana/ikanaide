<div class="">
    <a href="anime">go to anime page</a><br>
    <a href="manga">go to manga page</a><br>
    <a href="rankings">go to rankings page</a><br>
    <?php

    if (isset($_COOKIE['username'])) {
        ?><a href="<?=$_COOKIE['username']?>">go to profile page</a><br><?php
    }

    ?>
    <a href="submit">go to submit</a><br>
    <a href="reviews">go to reviews</a>
</div>