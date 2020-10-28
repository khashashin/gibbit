<article class="hreview open special">

    <!-- Falls vorhanden: Fehler anzeigen -->
    <?php if(isset($_GET['error'])):  ?>
    <div class="error">
        <p>Fehler:</p>
        <?= $_GET['error'] ?>
    </div>
    <?php endif; ?>

    <!-- Login Formular -->
	<form action="/user/doLogin" method="post">
        <input type="text" name="username" required>
        <label for="username">Benutzername</label>
        <input type="password" name="password" required>
        <label for="password">Passwort</label>

        <button type="submit">Anmelden</button>
    </form>

</article>
