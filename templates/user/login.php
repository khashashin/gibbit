<article class="d-flex align-items-center flex-column">

    <!-- Falls vorhanden: Fehler anzeigen -->
    <?php if(isset($_GET['error'])):  ?>
    <div class="error">
        <h2>Fehler:</h2>
        <p><?= $_GET['error'] ?></p>
    </div>
    <?php endif; ?>

    <!-- Login Formular -->
    <h1 class="h3">Bei gibbit anmelden</h1>
    <div class="col-12 col-sm-6">
        <form action="/user/doLogin" method="post">
            <div class="form-group">
                <label for="username">Benutzername</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Anmelden</button>
        </form>
    </div>

</article>
