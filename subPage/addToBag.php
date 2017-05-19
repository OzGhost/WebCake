<?php
	session_start();
	//echo "<pre>";
	//var_dump($_GET);
	//echo "</pre>";
	$exist = false;
	foreach ($_SESSION["giohang"] as $key => $value){
		if ($_GET["mabanh"] == $key){
			$_SESSION["giohang"]["$key"] += $_GET["sl"];
			$exist = true;
			break;
		}
	}
	if (!$exist){
		$_SESSION["giohang"][$_GET["mabanh"]] = $_GET["sl"];
	}
	// echo "<pre>";
	// var_dump($_SESSION["giohang"]);
	// echo "</pre>"
?>