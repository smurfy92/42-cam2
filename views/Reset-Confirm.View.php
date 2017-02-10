<?php include("views/Header.View.php"); ?>


<div class="title-login">Camagru</div>

<div class="register reset">
	<h2 class="reset-title">Reset mdp</h2>
	<div>
		<label>newpassword : </label>
		<input type="password" name="login" id="reset-confirm-email">
	</div>
	<input type="submit" class="submit" id="Reset-Confirm">
</div>

<div id="error"></div>

<?php include("views/Footer.View.php"); ?>
<script><?php include("ressources/js/xhr.js") ?></script>
<script><?php include("ressources/js/Reset-Confirm.js") ?></script>