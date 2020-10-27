<div class="row">
	<form action="/user/doCreate" method="post" class="col-6">
		<div class="form-group">
		  <label for="fname">Vorname</label>
	  	<input id="fname" name="fname" type="text" class="form-control">
		</div>
		<div class="form-group">
		  <label for="lname">Nachname</label>
	  	<input id="lname" name="lname" type="text" class="form-control">
		</div>
		<div class="form-group">
		  <label for="email">Mail</label>
	  	<input id="email" name="email" type="text" class="form-control">
		</div>
		<div class="form-group">
			<label class="control-label" for="password">Passwort</label>
			<input id="password" name="password" type="password" class="form-control">
		</div>
		<button type="submit" name="send" class="btn btn-primary">Absenden</button>
	</form>
</div>
