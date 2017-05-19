
<?php
	// Start the session
	session_start();

	unset($_SESSION["UserID"]);
	header('Location: ../');
?>
