<?php include("views/Header.View.php"); ?>

<div class="title-login">Camagru</div>

<div class="register reset">
	<h2 class="reset-title">Reset mdp</h2>
	<div>
		<label>email : </label>
		<input type="text" name="login" id="reset-email">
	</div>
	<input type="submit" class="submit" id="reset">
</div>

<div id="error"></div>

<?php include("views/Footer.View.php") ?>

<script><?php include("ressources/js/xhr.js") ?></script>
<script><?php include("ressources/js/reset.js") ?></script>