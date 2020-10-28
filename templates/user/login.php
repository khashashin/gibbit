<article class="hreview open special login">

    <!-- Falls vorhanden: Fehler anzeigen -->
    <?php if(isset($_GET['error'])):  ?>
    <div class="error">
        <h2>Fehler:</h2>
        <p><?= $_GET['error'] ?></p>
    </div>
    <?php endif; ?>

    <!-- Login Formular -->
    <h1>Bei gibbit anmelden</h1>
	<form action="/user/doLogin" class="login-form" method="post">
        <label for="username">Benutzername</label>
        <input type="text" class="form-control" name="username" required>
        <label for="password">Passwort</label>
        <input type="password" class="form-control" name="password" required>

        <button type="submit" class="btn btn-primary">Anmelden</button>
    </form>

</article>
