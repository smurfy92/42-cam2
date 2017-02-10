<?php

// require des dependances

require_once(dirname(__FILE__)."/config/database.php");
require_once(dirname(__FILE__)."/config/setup.php");
require_once(dirname(__FILE__)."/classes/Router.Class.php");
require_once(dirname(__FILE__)."/classes/User.Class.php");
require_once(dirname(__FILE__)."/classes/Image.Class.php");
// lancement du router

$racine = explode("/", $_SERVER["SCRIPT_NAME"]);
$racine = array_diff($racine, array('index.php', ""));
array_unshift($racine , $_SERVER["HTTP_HOST"]);
$racine = implode("/", $racine);
$racine;
$router = New Router();


// cherche si un ctrl exist pour le premier parametre de l'url
// cas particulier :
//	- si le ctrl exist et que l'utilisateur n'est pas connecter redirige vers le ctrl Login
// 	- si le premier parametre n'existe pas et que l'utilisateur est connecter redirige vers le ctrl Home
// 	- si le ctrl n'existe pas envoyer vers le ctrl notfound

if ($router->params[0] == "Api")
	include(dirname(__FILE__)."/controller/Api.Controller.php");
else if ($router->params[0] == "Reset")
	include(dirname(__FILE__)."/controller/Reset.Controller.php");
else if ($router->params[0] == "Reset-Confirm")
	include(dirname(__FILE__)."/controller/Reset-Confirm.Controller.php");
else if ((!$router->params[0] || file_exists(dirname(__FILE__)."/controller/".$router->params[0].".Controller.php")) && !$_SESSION["user"])
	include(dirname(__FILE__)."/controller/Login.Controller.php");
else if (!$router->params[0])
	include(dirname(__FILE__)."/controller/Home.Controller.php");
else if (file_exists("controller/".$router->params[0].".Controller.php"))
	include(dirname(__FILE__)."/controller/".$router->params[0].".Controller.php");
else
	include(dirname(__FILE__)."/views/Notfound.View.php");

 ?>