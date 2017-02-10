<?php

Class User{
	function __construct($login, $email, $password)
	{
		$this->login = $login;
		$this->email = $email;
		$this->password = $password;
	}

	function insertbdd()
	{
		$stmt = $db->prepare('INSERT INTO users (id, login, email, password) VALUES (NULL, :login, :email, :password)', array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$stmt->bindParam(':login', $this->login);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':password', $this->password);
		$stmt->execute();
		$this->id = $db->lastInsertId();
	}

	function addimage($b64, $selection)
	{
		$image = new Image($b64, $selection, $this->id);
		echo $image->result;
	}

	function saveimage($db, $b64)
	{
		$stmt = $db->prepare('INSERT INTO images (id, user_id, b64, likes) VALUES (NULL, :userid, :b64, NULL)', array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$stmt->bindParam(':userid', $this->id);
		$stmt->bindParam(':b64', $b64);
		$this->getImages($db);
		$stmt->execute();
	}

	function getImages($db)
	{
		$stmt = $db->prepare('SELECT * FROM images WHERE user_id=:userid', array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$stmt->bindParam(':userid', $this->id);
		$stmt->execute();
		$this->images = $stmt->fetchAll();
	}
}

?>