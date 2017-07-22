<h2><?=$title?></h2>

<?php foreach($news as $news_item): ?>
    <h3><?=$news_item['title']?></h3>
    <div class="main">
        <?=$news_item['text']?>
    </div>
    <p><a href="<?=site_url('news/' . $news_item['slug'])?>">view article</a></p>
<?php endforeach; ?>
