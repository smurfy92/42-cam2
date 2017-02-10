<?php

// ctrl = controlleur
Class Router{

	function __construct()
	{

		// parsing de l'url (split sur les /)
		$route = explode("/", $_SERVER['REQUEST_URI']);
		$racine = explode("/", dirname(__FILE__));
		// filtre sur dossier de dev
		foreach ($route as $key => $value)
			if (in_array($value, $racine))
				unset($route[$key]);
		// filtre les valeurs vides
		$this->params = array_values(array_filter($route));
	}
}

 ?>