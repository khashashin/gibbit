<article class="hreview open special">
    <?php if (empty($posts)): ?>
        <div class="dhd">
            <h2 class="item title">Hoopla! Keine Posts gefunden.</h2>
        </div>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <ul>
                <li><a href="/post/details?id=<?= $post->id?>"><?= $post->title; ?></a></li>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</article>
