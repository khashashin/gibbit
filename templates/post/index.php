<article class="mb-5">
    <div class="row">
        <?php if (empty($posts)): ?>
            <div class="dhd col-12">
                <h2 class="item title">Leider wurden bisher keine Posts erstellt.</h2>
            </div>
        <?php else: ?>
            <!-- Block Alle Posts -->
            <div class="col-12 col-sm-8 px-4">
                <div class="row d-block d-sm-none">
                    <div class="col-12">
                        <a href="/post/create" class="btn btn-primary btn-lg btn-block">Post erstellen</a>
                    </div>
                </div>
                <div class="row my-4 d-block d-sm-none">
                    <div class="col-12">
                        <div class="card w-100 bg-light">
                            <div class="card-header">
                                Neuste Posts
                            </div>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($latest_posts_mobile as $post): ?>
                                    <li class="list-group-item"><a
                                                href="/post/details?id=<?= $post->id ?>"><?= $post->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                    foreach ($posts as $post): ?>
                        <?php
                        // Random integer generieren um random Image zu laden
                        $rand = rand(100, 200);
                        $invalid_values = [148, 150, 105, 138];
                        // Remove invalid values
                        while(in_array($rand, $invalid_values)) {
                            $rand++;
                        }

                        // Zeitformat umwandeln
                        $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $post->created_at);
                        $created_at = date_format($created_at, 'd.m.Y H:i');

                        // Autor Name evaluieren
                        $user_id = $post->user_id;
                        $userRepository = new \App\Repository\UserRepository();
                        $full_name = $userRepository->readById($user_id)->first_name . " " . $userRepository->readById($user_id)->last_name;
                        ?>
                        <div class="card my-2 w-100">
                            <?php // Random url kreieren ?>
                            <img class="card-img-top" src="https://picsum.photos/id/<?= $rand ?>/330/70"
                                 alt="<?= $post->title; ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= $post->title; ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Author: <?= $full_name ?></h6>
                                <a href="/post/details/?id=<?= $post->id ?>" class="card-link mt-auto">Mehr lesen</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <nav aria-label="Page pagination" class="my-5 w-100">
                        <h6 class="card-subtitle mb-2 text-muted text-center">Seiten</h6>
                        <ul class="pagination justify-content-center">
                            <?php
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1" tabindex="-1">Erste</a>
                            </li>
                            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>">Vorherige</a>
                            </li>
                            <li class="page-item <?php if($page >= $total_pages){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">Nächste</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $total_pages; ?>">Letzte</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Block Alle Posts -->

            <!-- Block Neuste Posts -->
            <div class="col-4 d-none d-sm-block">
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
                                    <li class="list-group-item"><a
                                                href="/post/details/?id=<?= $post->id ?>"><?= $post->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Block Neuste Posts -->
        <?php endif; ?>
    </div>
</article>
