<article class="hreview open special">
    <?php if (empty($posts)): ?>
        <div class="dhd">
            <h2 class="item title">Leider wurden bisher keine Posts erstellt.</h2>
        </div>
    <?php else: ?>
    <h1>Neuste Posts</h1>
        <?php foreach ($posts as $post): ?>
        <?php
            // Zeitformat umwandeln
            $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $post->created_at);
            $created_at = date_format($created_at, 'd.m.Y H:i');

            // Autor Name evaluieren
            $user_id = $post->user_id;
            $userRepository = new \App\Repository\UserRepository();
            $user_name = $userRepository->readById($user_id)->username;

            // Text kürzen
            $text = $post->text;
            if(strlen($text) > 100) {
                // Text kürzen, da er über 120 Zeichen lang ist
                $text = substr($text, 0, 120);
                $text .= '...';
            }
        ?>

        <div class="post">
            <a href="/post/details?id=<?= $post->id?>" class="post-title-link"><h3 class="post-title"><?= $post->title; ?></h3></a>
            <p class="post-content"><?= $text ?></p>
            <p class="created_at">veröffentlicht am <?= $created_at ?></p>
            <p class="author">Autor: <?= $user_name ?></p>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</article>
