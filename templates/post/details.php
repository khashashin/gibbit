<article>
    <div class="row">
        <div class="col-12 col-sm-8">
            <h1 class="h5"><?= $post->title ?></h1>
            <hr>
            <p><?= $post->text ?></p>
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
            <?php endif; ?>
        </div>
        <div class="col-4 d-none d-sm-block">
            <div class="card w-100 bg-light">
                <div class="card-header">
                    Ähnliche Posts
                </div>
                <ul class="list-group list-group-flush">
                    <!-- Temporär wird statische posts verwendet
                         TODO: Get posts by similar tags (!not implemented yet)-->
                    <li class="list-group-item"><a
                            href="/post/details?id=<?= $post->id ?>"><?= $post->title; ?></a></li>
                    <li class="list-group-item"><a
                            href="/post/details?id=<?= $post->id ?>"><?= $post->title; ?></a></li>
                    <li class="list-group-item"><a
                            href="/post/details?id=<?= $post->id ?>"><?= $post->title; ?></a></li>
                    <li class="list-group-item"><a
                            href="/post/details?id=<?= $post->id ?>"><?= $post->title; ?></a></li>
                    <li class="list-group-item"><a
                            href="/post/details?id=<?= $post->id ?>"><?= $post->title; ?></a></li>
                    <li class="list-group-item"><a
                            href="/post/details?id=<?= $post->id ?>"><?= $post->title; ?></a></li>
                    <?php /*foreach ($similar_posts as $similar_post): */?>
                    <?php /*endforeach; */?>
                </ul>
            </div>
        </div>
    </div>
</article>



