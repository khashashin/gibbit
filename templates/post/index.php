<article class="hreview open special">
    <?php if (empty($posts)): ?>
        <div class="dhd">
            <h2 class="item title">Hoopla! Keine User gefunden.</h2>
        </div>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <ul>
                <li><a href=""></a><?= $post->title; ?></li>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</article>