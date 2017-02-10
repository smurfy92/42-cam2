<?php include("views/Header.View.php"); ?>

<div class="title-login">Camagru</div>
<?php if ($error){echo $error;}?>
<div class="connect">

	<div class="register">
		<h2 class="login-title">Register</h2>
		<div>
			<label>username : </label>
			<input type="text" name="login" id="register-login">
		</div>
		<div>
			<label>email :</label>
			<input type="text" name="email" id="register-email">
		</div>
		<div>
			<label>password : </label>
			<input type="password" name="password" id="register-password" class="password">
		</div>
		<input type="submit" class="submit" id="register">
	</div>
	<div class="login">
		<h2 class="login-title">login</h2>
		<div>
			<label>email : </label>
			<input type="text" name="login-email" id="login-email">
		</div>
		<div>
			<label>password : </label>
			<input type="password" name="login-password" id="login-password" class="password">
		</div>
		<input type="submit" class="submit" id="login">
		<input type="submit" class="submit" id="reset" value="Reset">
	</div>
</div>
<div id="error"></div>

<?php include("views/Footer.View.php") ?>
<script><?php include("ressources/js/xhr.js") ?></script>
<script><?php include("ressources/js/login.js") ?></script>
