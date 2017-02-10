<?php include("views/Header.View.php"); ?>
<?php include("views/Menu.View.php"); ?>
<div class="filters">
			<img src="ressources/images/palmier.png" id="palmier" class="filter"></img>
			<img src="ressources/images/pokeball.png" id="pokeball" class="filter"></img>
			<img src="ressources/images/glasses.png" id="glasses" class="filter"></img>
	</div>
<div class="main">

	<img src="ressources/images/palmier.png" id="filter-palmier" class="hide"/>
	<img src="ressources/images/pokeball.png" id="filter-pokeball" class="hide"/>
	<img src="ressources/images/glasses.png" id="filter-glasses" class="hide"/>
	<div class="camera">
		<video id="video"></video><br>
		<input type='file' id="fileUpload" class="hide" accept="image/x-png"/>
		<button id="startbutton" class="hide">Prendre une photo</button>
		<br>
	</div>
	<div class="photos">
	</div>
</div>
<?php include("views/Footer.View.php"); ?>
<script><?php include("ressources/js/xhr.js") ?></script>
<script><?php include("ressources/js/webcam.js") ?></script>
<script><?php include("ressources/js/filter.js") ?></script>