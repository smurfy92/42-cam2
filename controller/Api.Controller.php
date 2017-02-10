<?php
include("config/database.php");


if ($router->params[1] == "Confirm" && $router->params[2])
{
	$stmt = $db->prepare("SELECT * FROM users WHERE hash=:hash");
	$stmt->bindParam(':hash', $router->params[2]);
	$stmt->execute();
	$ret = $stmt->fetchAll();
	if (count($ret) == 1)
	{
		$stmt = $db->prepare("UPDATE users set registered=1 WHERE hash=:hash");
		$stmt->bindParam(':hash', $router->params[2]);
		$stmt->execute();
		$user = New User($ret[0]["login"], $ret[0]["email"], $ret[0]["password"]);
		$user->id = $ret[0]["id"];
		$_SESSION["user"] = serialize($user);
		header("Location:/".str_replace("localhost:8080/","", $GLOBALS["racine"]));
	}
	else
		header("Location:/".str_replace("localhost:8080/","", $GLOBALS["racine"]));
	exit ;
}

if ($router->params[1] == "Reset-Confirm" && $router->params[2] && $router->params[3])
{
	$stmt = $db->prepare("SELECT * FROM users WHERE hash=:hash");
	$stmt->bindParam(':hash', $router->params[2]);
	$stmt->execute();
	$ret = $stmt->fetchAll();
	if (count($ret) == 1)
	{
		$stmt = $db->prepare("UPDATE users set password=:pass WHERE hash=:hash");
		$stmt->bindParam(':pass', hash("whirlpool",$router->params[3]));
		$stmt->bindParam(':hash', $router->params[2]);
		$stmt->execute();
		$user = New User($ret[0]["login"], $ret[0]["email"], $ret[0]["password"]);
		$user->id = $ret[0]["id"];
		$_SESSION["user"] = serialize($user);
		echo "ok";
	}
	else
		echo "Invalid hash";
	exit ;
}

if ($router->params[1] == "Reset" && $router->params[2])
{
	$stmt = $db->prepare("SELECT * FROM users WHERE email=:email");
	$stmt->bindParam(':email', $router->params[2]);
	$stmt->execute();
	$ret = $stmt->fetchAll();
	if (count($ret) == 1)
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$message = 'reset your email by clicking this <a href="http://'.$GLOBALS["racine"].'/Reset-Confirm/'.$ret[0]["hash"].'">link</a>';
		if (mail( $ret[0]["email"] , "camagru" , $message, $headers) == true)
		{
			echo "Email send";
		}
		else
			echo "Error sending email";
	}
	else
		echo "Invalid email";
	exit ;
}
//get json object via input

$data = json_decode(file_get_contents('php://input'), true);

if ($router->params[1] == "addcomment" && $data["id"] && $data["user_id"] && $data["value"])
{
	$stmt = $db->prepare("INSERT INTO comments (id, image_id, user_id, text) VALUES (NULL, :image_id, :user_id, :text)");
	$stmt->bindParam(':image_id', $data["id"]);
	$stmt->bindParam(':user_id', $data["user_id"]);
	$stmt->bindParam(':text', $data["value"]);
	$stmt->execute();
	echo "ok";
	$stmt = $db->prepare("SELECT * FROM users WHERE id=:user_id");
	$stmt->bindParam(':user_id', $data["user_id"]);
	$stmt->execute();
	$ret = $stmt->fetchAll();
	if (count($ret) == 1)
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$message = 'you received a comment on your photo';
		mail($ret[0]["email"] , "camagru" , $message, $headers);
	}
	exit ;

}

if ($router->params[1] == "delphoto" && $data["id"] && $data["user_id"])
{
	$stmt = $db->prepare("DELETE FROM images WHERE id=:id");
	$stmt->bindParam(':id', $data["id"]);
	$stmt->execute();
	echo "ok";
	exit ;
}

if ($router->params[1] == "addlike" && $data["id"] && $data["user_id"])
{
	$stmt = $db->prepare("SELECT * FROM images WHERE id=:id");
	$stmt->bindParam(':id', $data["id"]);
	$stmt->execute();
	$ret = $stmt->fetchAll();
	$likes = unserialize($ret[0]["likes"]);
	if ($likes[$data["user_id"]])
		exit;
	$likes[$data["user_id"]] = 1;
	$like = serialize($likes);
	$stmt = $db->prepare("UPDATE images set likes=:likes WHERE id=:id");
	$stmt->bindParam(':id', $data["id"]);
	$stmt->bindParam(':likes', $like);
	$stmt->execute();
	exit ;
}

if ($router->params[1] == "dellike" && $data["id"] && $data["user_id"])
{
	$stmt = $db->prepare("SELECT * FROM images WHERE id=:id");
	$stmt->bindParam(':id', $data["id"]);
	$stmt->execute();
	$ret = $stmt->fetchAll();
	$likes = unserialize($ret[0]["likes"]);
	if ($likes[$data["user_id"]])
		unset($likes[$data["user_id"]]);
	$like = serialize($likes);
	$stmt = $db->prepare("UPDATE images set likes=:likes WHERE id=:id");
	$stmt->bindParam(':id', $data["id"]);
	$stmt->bindParam(':likes', $like);
	$stmt->execute();
	exit ;
}


//traitement en cas dobjet json login
if ($data["Login"])
{
	$stmt = $db->prepare("SELECT * FROM users WHERE email=:email");
	$stmt->bindParam(':email', $data["Login"]["email"]);
	$stmt->execute();
	$ret = $stmt->fetchAll();
	if (count($ret) == 1)
	{
		if ($ret[0]["password"] === hash("whirlpool", $data["Login"]["password"]) && $ret[0]["registered"] == 1)
		{
			$user = New User($ret[0]["login"], $ret[0]["email"], $ret[0]["password"]);
			$user->id = $ret[0]["id"];
			$_SESSION["user"] = serialize($user);
			echo "ok";
		}
		else if ($ret[0]["registered"] == 0)
			echo "You need to confirm mail";
		else
			echo "Invalid Password";
	}
	else
		echo "Invalid Email";
	exit;
}

//traitement en cas dobjet json register


function generatehash()
{
	return bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
}

if ($data["Register"])
{
	if (strlen($data["Register"]["password"]) < 5)
	{
		echo "password too short";
		exit;
	}
	if (strlen($data["Register"]["login"]) < 5)
	{
		echo "login too short";
		exit;
	}
	if (!preg_match("/^[a-zA-Z0-9_.-]*$/", $data["Register"]["login"]))
	{
		echo "login can contain only letters ans numbers";
		exit;
	}
	if (!preg_match("/^[a-zA-Z0-9_.-]*$/", $data["Register"]["password"]))
	{
		echo "password can contain only letters ans numbers";
		exit;
	}
	if (!filter_var($data["Register"]["email"], FILTER_VALIDATE_EMAIL)) {
		echo "invalid email";
		exit;
	}
	$stmt = $db->prepare("SELECT * FROM users WHERE email=:email");
	$stmt->bindParam(':email', $data["Register"]["email"]);
	$stmt->execute();
	$ret = $stmt->fetchAll();
	if (count($ret) == 0)
	{
		$hash = generatehash();
		$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$message = 'please confirm your email by clicking this <a href="http://'.$GLOBALS["racine"].'/Api/Confirm/'.$hash.'">link</a>';
		if (mail( $data["Register"]["email"] , "camagru" , $message, $headers) == true)
		{
			$stmt = $db->prepare("INSERT INTO users (id, login, email, password, registered, hash) VALUES (NULL, :login, :email, :password, 0, :hash)");
			$stmt->bindParam(':login', $data["Register"]["login"]);
			$stmt->bindParam(':email', $data["Register"]["email"]);
			$stmt->bindParam(':hash', $hash);
			$stmt->bindParam(':password', hash("whirlpool",$data["Register"]["password"]));
			$stmt->execute();
			$user = New User($data["Register"]["login"], $data["Register"]["email"], $data["Register"]["password"]);
			$user->id = $db->lastInsertId();
			echo "Email send";
		}
		else
			echo "Error sending email";

	}
	else
		echo "Email already in use";
	exit;
}

// partie ou il faut etre log


if (!$_SESSION["user"])
 	exit ;

$user = unserialize($_SESSION["user"]);

//dans le cas d'une insertion d'image pour un utlisateur
if ($data["Base64"])
{
	$user->addimage($data["Base64"], $data["selection"]);
	exit;
}
if ($data["img"])
{
	$user->saveimage($db, $data["img"]);
	exit;
}

 ?>
