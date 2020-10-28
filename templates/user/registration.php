
<!-- Falls vorhanden: Fehler anzeigen -->
<?php if(isset($_GET['error'])):  ?>
    <div class="error">
        <p>Fehler:</p>
        <?= $_GET['error'] ?>
    </div>
<?php endif; ?>

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
		<button type="submit" name="send" class="btn btn-primary float-right">Absenden</button>
	</form>
</div>
