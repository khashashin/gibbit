<div class="register">
    <!-- Falls vorhanden: Fehler anzeigen -->
    <?php if (isset($_GET['error'])): ?>
        <div class="error">
            <h2>Fehler:</h2>
            <p><?= $_GET['error'] ?></p>
        </div>
    <?php endif; ?>

    <h1>Bei gibbit registrieren</h1>

    <div class="row">
        <form action="/user/doCreate" method="post" class="col-6">
            <div class="form-group">
                <label for="username">Benutzername</label>
                <input id="username" name="username" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fname">Vorname</label>
                <input id="fname" name="fname" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="lname">Nachname</label>
                <input id="lname" name="lname" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input id="email" name="email" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="control-label" for="password">Passwort</label>
                <input id="password" name="password" type="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="control-label" for="password">Passwort wiederholen</label>
                <input id="passwordRepeat" name="passwordRepeat" type="password" class="form-control" required>
            </div>
            <button type="submit" name="send" class="btn btn-primary w-100">Registrieren</button>
        </form>
    </div>
</div>
