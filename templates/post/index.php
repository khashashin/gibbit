<article class="container">
    <div class="row">
    <?php if (empty($posts)): ?>
        <div class="dhd col-12">
            <h2 class="item title">Leider wurden bisher keine Posts erstellt.</h2>
        </div>
    <?php else: ?>
        <div class="col-8 px-4">
            <div class="row">
        <?php
        foreach ($posts as $post): ?>
            <?php
            // Random integer generieren um random Image zu ladaen
            $randomizer = rand(100, 300);

            // Zeitformat umwandeln
            $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $post->created_at);
            $created_at = date_format($created_at, 'd.m.Y H:i');

            // Autor Name evaluieren
            $user_id = $post->user_id;
            $userRepository = new \App\Repository\UserRepository();
            $user_name = $userRepository->readById($user_id)->username;
            ?>
            <div class="card my-2 w-100">
                <img class="card-img-top" src="https://picsum.photos/id/<?= $randomizer ?>/330/70" alt="<?= $post->text; ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= $post->title; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Author: <?= $user_name?></h6>
                    <a href="/post/details?id=<?= $post->id?>" class="card-link mt-auto">Meh lesen</a>
                </div>
            </div>
        <?php endforeach; ?>
            </div>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-12">
                    <a href="/post/create" class="btn btn-primary btn-lg btn-block">Post erstellen</a>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card w-100 bg-light">
                        <div class="card-header">
                            Neuste Posts
                        </div>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($posts as $post): ?>
                                <li class="list-group-item"><a href="/post/details?id=<?= $post->id?>"><?= $post->title; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    </div>
</article>
