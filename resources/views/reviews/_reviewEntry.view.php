<div class="review_entry-wrapper">
    <div class="review_header-wrapper box-wrapper">
        <div class="review_entry-medium box-title"><h3><?=htmlspecialchars($review['title'])?></h3></div>
        <div class="review_entry-user_info box-body"><p>A review of <a class="" href="/<?=$review['medium']?>/<?=str_replace(' ', '-', $review['entry'])?>"><?=$review['entry']?></a>, written by <a class="link" href="/<?=$review['username']?>"><?=$review['username']?></a> on <?=ucfirst(dateFormat(substr($review['date'], 0, 10)))?></p></div>  
    </div>
    <div class="review_entry-content box-wrapper box-body"><?=htmlspecialchars($review['text'])?></div>
</div>