<article class="d-flex flex-column align-items-center">
    <!-- Falls vorhanden: Fehler anzeigen -->
    <?php if (isset($_GET['error'])): ?>
        <div class="error">
            <h2>Fehler:</h2>
            <p><?= $_GET['error'] ?></p>
        </div>
    <?php endif; ?>

    <h1 class="h3">Bei gibbit registrieren</h1>

    <div class="row w-100 justify-content-center">
        <form action="/user/doCreate" method="post" class="col-12 col-sm-6 needs-validation" novalidate>
            <div class="form-group">
                <label for="username">Benutzername</label>
                <input id="username" name="username" type="text" class="form-control" required>
                <div class="invalid-feedback">
                    Benutzername ist noch nötig.
                </div>
            </div>
            <div class="form-group">
                <label for="fname">Vorname</label>
                <input id="fname" name="fname" type="text" class="form-control" required>
                <div class="invalid-feedback">
                    Vorname ist noch nötig.
                </div>
            </div>
            <div class="form-group">
                <label for="lname">Nachname</label>
                <input id="lname" name="lname" type="text" class="form-control" required>
                <div class="invalid-feedback">
                    Nachname ist noch nötig.
                </div>
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input id="email" name="email" type="text" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                <div class="invalid-feedback">
                    Gültige E-Mail ist nötig.
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="password">Passwort</label>
                <input id="password" name="password" type="password" class="form-control" pattern=".{8,}" required>
            </div>
            <div class="form-group">
                <label class="control-label" for="passwordRepeat">Passwort wiederholen</label>
                <input id="passwordRepeat" name="passwordRepeat" type="password" class="form-control" pattern=".{8,}" required>
            </div>
            <button type="submit" name="send" class="btn btn-primary btn-block">Registrieren</button>
        </form>
    </div>
</article>
