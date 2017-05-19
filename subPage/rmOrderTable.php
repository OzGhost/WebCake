<?php
	session_start();
	$valid = true;
	if (!isset($_SESSION["UserID"]) || empty($_SESSION["UserID"])) $valid = false;
	if (!isset($_GET["idCode"]) || empty($_GET["idCode"])) $valid = false;

	if (!$valid){
		echo "Lack-Info";
	} else {
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$pass = "ngaymai";
		$db = "u952681548_cake";
		$conn = new mysqli($server, $host, $pass, $db)
			or die ("Can not connect to server! ".$conn->error);

		$sql_cmd = "DELETE FROM DATBAN WHERE MADB=".$_GET["idCode"].";";
		if ($conn->query($sql_cmd)){
			echo "Success";
		} else {
			echo $conn->error;
		}
		if ($conn) $conn->close();
	}
?>