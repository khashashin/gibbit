<article class="container">
    <div class="row">
        <!-- Falls vorhanden: Fehler anzeigen -->
        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <h2>Fehler:</h2>
                <p><?= $_GET['error'] ?></p>
            </div>
        <?php endif; ?>
        <form action="/post/doUpdateComment" method="post" class="col-12">
            <div class="form-group">
                <label for="comment-text">Kommentar</label>
                <textarea id="comment-text" name="text" rows="10" class="form-control" required><?= $comment->text ?></textarea>
            </div>
            <input type="hidden" name="comment_id" value="<?= $comment->id ?>">
            <input type="hidden" name="post_id" value="<?= $post->id ?>">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </form>
    </div>
</article>
