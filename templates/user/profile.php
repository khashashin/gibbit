<!-- Überprüfen, ob der Nutzer eingeloggt ist -->
<?php if(!($_SESSION['isLoggedIn'] && $_SESSION['username'])): ?>
    <div class="error">
        <h2>Fehler:</h2>
        <p>Hierzu musst du eingeloggt sein!</p>
    </div>
<?php else: ?>

<article class="d-flex align-items-center flex-column">

    <h1 class="h3"><?= $_SESSION['username'] ?></h1>


    <div class="row w-100">
        <?php
        $postRepository = new \App\Repository\PostRepository();
        $user_posts = $postRepository->getAllPostsByUser($_SESSION['userid']);
        ?>
        <div class="col-6 d-none d-sm-block">
            <div class="card w-100 bg-light">
                <div class="card-header">
                    Deine Posts
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    if(!empty($user_posts)):
                    foreach ($user_posts as $post): ?>
                        <li class="list-group-item"><a
                                href="/post/details/?id=<?= $post->id ?>"><?= $post->title; ?></a>
                        </li>
                    <?php endforeach;
                    else: ?>
                    <li class="list-group-item">Du hast aktuell noch keine Posts</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="col-6 d-none d-sm-block">
            <div class="card w-100 bg-light">
                <div class="card-header">
                    Account verwalten
                </div>
                <ul class="list-group list-group-flush">
                    <!-- TODO: Needs to be implemented -->
                    <li class="list-group-item"><a href="#">Benutzername ändern</a></li>
                    <li class="list-group-item"><a href="#">Passwort ändern</a></li>
                    <li class="list-group-item"><a href="#">Account löschen</a></li>
                </ul>
            </div>
        </div>
    </div>

</article>

<?php endif; ?>
