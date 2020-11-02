<script type="application/javascript">
    confirmDelete = () => {
        if (confirm('Möchten Sie wirklich den Post löschen?')) {
            window.location.href = "/post/delete/?id=<?= $post->id ?>";
        } else return
    }
</script>

<article class="container">
    <div class="row">
        <div class="col-12 col-sm-8">
            <h1 class="h5"><?= $post->title ?></h1>
            <hr>
            <p><?= $post->text ?></p>
            <?php if($is_post_owner):?>
            <div class="btn-group">
                <a href="/post/edit/?id=<?= $post->id ?>"><button class="btn btn-warning">Editieren</button></a>
                <button class="btn btn-danger" onclick="confirmDelete()">Löschen</button>
            </div>
            <?php endif; ?>
        </div>
        <div class="col-4 d-none d-sm-block">
            <div class="card w-100 bg-light">
                <div class="card-header">
                    Ähnliche Posts
                </div>
                <ul class="list-group list-group-flush">

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



