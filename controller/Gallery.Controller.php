<?php
include("config/database.php");

$user = unserialize($_SESSION["user"]);
if ($user)
{
	$stmt = $db->prepare('SELECT * FROM images', array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$stmt->bindParam(':userid', $user->id);
	$stmt->execute();
	$images = $stmt->fetchAll();
	$start = 0;
	while ($images[$start])
	{

		$stmt = $db->prepare('SELECT * FROM comments WHERE image_id=:image_id', array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$stmt->bindParam(':image_id', $images[$start]["id"]);
		$stmt->execute();
		$images[$start]["comments"] = $stmt->fetchAll();
		$start2 = 0;
		while ($images[$start]["comments"][$start2])
		{
			$stmt = $db->prepare('SELECT login FROM users WHERE id=:user_id', array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$stmt->bindParam(':user_id', $images[$start]["comments"][$start2]["user_id"]);
			$stmt->execute();
			$images[$start]["comments"][$start2]["login"] = $stmt->fetch()["login"];
			$start2++;
		}

		$start++;

	}
}
else
	header("Location:/Login");

include("views/Gallery.View.php");



 ?>