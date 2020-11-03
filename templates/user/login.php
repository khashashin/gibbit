<article class="d-flex align-items-center flex-column">

    <!-- Falls vorhanden: Fehler anzeigen -->
    <?php if(isset($_GET['error'])):  ?>
    <div class="error">
        <h2>Fehler:</h2>
        <p><?= htmlspecialchars($_GET['error']); ?></p>
    </div>
    <?php endif; ?>

    <!-- Login Formular -->
    <h1 class="h3">Bei gibbit anmelden</h1>
    <div class="col-12 col-sm-6">
        <form action="/user/doLogin" method="post" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="username">Benutzername</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <div class="invalid-feedback">
                    Benutzername ist noch nötig.
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" autocomplete="off" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">
                    Password ist noch nötig.
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Anmelden</button>
        </form>
    </div>

</article>
