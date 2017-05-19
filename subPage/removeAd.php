<?php
	session_start();
	// echo "<pre>";
	// print_r($_GET);
	// echo "</pre>";
	$valid = true;
	if (!isset($_SESSION["UserID"]) || empty($_SESSION["UserID"])) $valid = false;
	if (!isset($_GET["idCode"]) || empty($_GET["idCode"])) $valid = false;
	if (!isset($_GET["rmDf"]) || empty($_GET["rmDf"])) $valid = false;
	if ($valid){
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$pass = "ngaymai";
		$db = "u952681548_cake";
		$conn = new mysqli($server, $host, $pass, $db)
			or die ("Can not connect to server! ".$conn->error);
		
		// delete SDC Default
		if ($_GET["rmDf"] == "true"){
			$sql_cmd = "UPDATE KHACHHANG SET SDC=NULL WHERE USERNAME='".$_SESSION["UserID"]."';";
			$conn->query($sql_cmd);
		}

		// delete SDC
		$sql_cmd = "DELETE FROM SODIACHI WHERE MASDC=".$_GET["idCode"].";";
		$conn->query($sql_cmd);

		echo 'Success';
		if ($conn) $conn->close();
	} else {
		echo 'Lack-Info';
	}
?>