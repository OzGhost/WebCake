
<?php
	if (isset($_GET["video"]) && !empty($_GET["video"])){
?>
		<video controls autoplay>
			<source src=<?php echo '"vid/'.$_GET['video'].'.mp4"'?> type="video/mp4">
		</video>
<?php
	} else {
		echo "You fools";
	}// End else of IF (isset && !empty)
?>