<?php include("views/Header.View.php"); ?>
<?php include("views/Menu.View.php"); ?>
<?php

$max_images = 4;


//var_dump($images);

if (!$router->params[1])
	$start = 0;
else
	$start = $router->params[1] * $max_images;
$end = $start + $max_images;
if ($start > count($images))
	$start = floor(count($images) /$max_images ) * $max_images;

echo "<div id='error'></div>";

while ($start < $end)
{

	if ($images[$start])
	{
		//var_dump($images[$start]);
		echo "<div class='photo'>";
		echo "<img src='data:image/png;base64,".$images[$start]["b64"]."'>";
		$likes = unserialize($images[$start]["likes"]);
		if ($likes[$user->id])
			echo "<input type='submit' value='UnLike' class='like' onclick='dellike(".$images[$start]["id"].",".$user->id.")'>";
		else
			echo "<input type='submit' value='Like' class='like' onclick='addlike(".$images[$start]["id"].",".$user->id.")'>";
		echo "<span>";

		if ($likes)
			echo count($likes);
		else
			echo "0";
		echo "</span>";
		// if ($images[$start]["user_id"] == $user->id)
		// 	echo "you can delete";1

		echo "<div class='comments'>";

		foreach ($images[$start]["comments"] as $img)
		{
			echo "<label>".strtoupper($img["login"])."</label>";
			echo " : ";
			echo $img["text"];
			echo "</br>";
		}
		echo "</div>";

		echo "<label>Comment : </label>";
		echo "<input type='text' class='comment' id='comment_".$images[$start]["id"]."'>";
		echo "<input type='submit' value='Send' onclick='addcomment(".$images[$start]["id"].", ".$user->id.")'>";
		if ($images[$start]["user_id"] == $user->id)
			echo "<input type='submit' value='delete' onclick='delphoto(".$images[$start]["id"].", ".$user->id.")'>";
		echo "</div>";
	}

	$start++;
}
?>
<div>
<button id="prev">Prev</button>
<button id="next">Next</button>
</div>
<script><?php include("ressources/js/xhr.js"); ?></script>
<script><?php include("ressources/js/gallery.js"); ?></script>
<script><?php include("ressources/js/menu.js") ?></script>
<?php include("views/Footer.View.php"); ?>
