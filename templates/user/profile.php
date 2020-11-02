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

        <?php
        // Benutzer Objekt erzeugen und in Variablen abfüllen
        $userRepostory = new \App\Repository\UserRepository();
        $user = $userRepostory->readById($_SESSION['userid']);
        $username = $user->username;
        $password = $user->password;
        ?>

        <div class="col-6 d-none d-sm-block">
            <div class="card w-100 bg-light">
                <div class="card-header">
                    Account verwalten
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <form name="updateCredentials" action="/user/updateUsername" class="updateCredentials" method="post">
                            <label class="w-50" for="username">Benutzername<br>
                                <input class="w-100" value="<?= $username ?>" type="text" name="username">
                            </label>
                            <input name="userid" type="hidden" value="<?= $_SESSION['userid']; ?>">
                            <button class="btn btn-success profile-submit" type="submit">Änderungen speichern</button>
                        </form>
                    </li>
                    <li class="list-group-item"><a href="/user/deleteUser" onclick="return confirm('Möchtest du deinen Account wirklich löschen?')">Account löschen</a></li>
                </ul>
            </div>
        </div>
    </div>

</article>

<?php endif; ?>
