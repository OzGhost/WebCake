
<?php
	echo "<pre>";
	var_dump($_COOKIE);
	echo "</pre>";
	unset($_COOKIE["PHPSESSID"]);
	echo "<pre>";
	var_dump($_COOKIE);
	echo "</pre>";
?>