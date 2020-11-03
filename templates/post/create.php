<article class="container">
    <div class="row">
        <!-- Falls vorhanden: Fehler anzeigen -->
        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <h2>Fehler:</h2>
                <p><?= htmlspecialchars($_GET['error']); ?></p>
            </div>
        <?php endif; ?>
        <form action="/post/doCreate" method="post" class="col-12 needs-validation" novalidate>
            <div class="form-group">
                <label for="post-title">Titel</label>
                <input id="post-title" type="text" name="title" class="form-control" required>
                <div class="invalid-feedback">
                    Titel ist noch nötig.
                </div>
            </div>
            <div class="form-group">
                <label for="post-text">Post</label>
                <textarea id="post-text" name="text" rows="10" class="form-control" required></textarea>
                <div class="invalid-feedback">
                    Post-text ist noch nötig.
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Erstellen</button>
        </form>
    </div>
</article>
