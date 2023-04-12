<section class="review_entry-wrapper">
    <div class="review_entry-medium">A review of <a href="/<?=$review['medium']?>/<?=str_replace(' ', '-', $review['entry'])?>"><?=$review['entry']?></a>.</div>
    <div class="review_entry-title"><?=$review['title']?></div>
    <div class="review_entry-content"><?=$review['text']?></div>
    <div class="review_entry-user">by <a href="/<?=$review['username']?>"><?=$review['username']?></a> on <?=$review['date']?>.</div>
</section>