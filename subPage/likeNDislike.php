<?php
	session_start();
	$valid = true;
	if (!isset($_SESSION["UserID"]) || empty($_SESSION["UserID"])) $valid = false;
	if (!isset($_GET["mb"]) || empty($_GET["mb"])) $valid = false;
	if (!isset($_GET["val"]) || empty($_GET["val"])) $valid = false;
	if (!$valid){
		echo "Lack-Info!";
	} else {
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$pass = "ngaymai";
		$db = "u952681548_cake";
		$conn = new mysqli($server, $host, $pass, $db)
			or die (" Can not connect to server! ".$conn->error);

		$sql_cmd = "";
		if ($_GET["val"] == "true"){
			$sql_cmd = "INSERT INTO LIKED VALUES('".$_SESSION["UserID"]."', ".$_GET["mb"].");";
		} else {
			$sql_cmd = "DELETE FROM LIKED WHERE USERNAME='".$_SESSION["UserID"]."' AND MABANH=".$_GET["mb"].";";
		}
		if ($conn->query($sql_cmd)){
			echo "Success";
		} else {
			echo "Failure!";
		}
	}// end else of IF(!$valid)
?>