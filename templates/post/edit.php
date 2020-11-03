<article class="container">
    <div class="row">
        <!-- Falls vorhanden: Fehler anzeigen -->
        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <h2>Fehler:</h2>
                <p><?= $_GET['error'] ?></p>
            </div>
        <?php endif; ?>
        <form action="/post/doUpdate" method="post" class="col-12 needs-validation" novalidate>
            <div class="form-group">
                <label for="post-title">Titel</label>
                <input id="post-title" type="text" name="title" class="form-control" required
                       value="<?= $post->title ?>">
                <div class="invalid-feedback">
                    Titel ist noch nötig.
                </div>
            </div>
            <div class="form-group">
                <label for="post-text">Post</label>
                <textarea id="post-text" name="text" rows="10" class="form-control" required><?= $post->text ?></textarea>
                <div class="invalid-feedback">
                    Post-text ist noch nötig.
                </div>
            </div>
            <input type="hidden" name="post_id" value="<?= $post->id ?>">
            <button type="submit" class="btn btn-primary">Speichern</button>
            <a href="/post/details?id=<?= $post->id ?>" class="btn btn-secondary">Zurück</a>
        </form>
    </div>
</article>
