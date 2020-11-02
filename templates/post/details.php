<article>
    <div class="row">
        <div class="col-12 col-sm-8">
            <h1 class="h5"><?= $post->title ?></h1>
            <hr>
            <p><?= $post->text ?></p>
            <p><strong><?= $user->first_name . " " . $user->last_name?></strong><br>
                <i><?= $post->created_at ?></i></p>
            <?php if($is_post_owner):?>
            <div class="btn-group">
                <script type="application/javascript">
                    confirmDelete = () => {
                        if (confirm('Möchten Sie wirklich den Post löschen?')) {
                            window.location.href = "/post/delete/?id=<?= $post->id ?>";
                        } else return
                    }
                </script>
                <a href="/post/edit/?id=<?= $post->id ?>" class="btn btn-outline-secondary btn-sm">Editieren</a>
                <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete()">Löschen</button>
            </div>
            <hr>
            <?php endif; ?>
        </div>
        <div class="col-4 d-none d-sm-block">
            <div class="card w-100 bg-light">
                <div class="card-header">
                    Ähnliche Posts
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    foreach ($similar_posts as $similar_post): ?>
                    <!-- Temporär wird statische posts verwendet
                         TODO: Get posts by similar tags (!not implemented yet)-->
                    <li class="list-group-item"><a
                            href="/post/details/?id=<?= $similar_post->id ?>"><?= $similar_post->title; ?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</article>



