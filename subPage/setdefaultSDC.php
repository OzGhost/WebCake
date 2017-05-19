<?php
// Start the session
session_start();
	$logon = false;
	if ( isset($_SESSION["UserID"]) && !empty($_SESSION["UserID"])){
		$message = "";
		if ( !empty($_GET["idCode"])){
			$logon = true;
			$server = "mysql.hostinger.vn";
			$host = "u952681548_root";
			$hostpass = "ngaymai";
			$db = "u952681548_cake";
			$conn = new mysqli($server, $host, $hostpass, $db);
			if ($conn->connect_error) {
	  			die("Connection failed: " . $conn->connect_error);
			}

			$sql_command = 'UPDATE KHACHHANG SET SDC=\''.$_GET["idCode"].'\' WHERE USERNAME=\''.$_SESSION["UserID"].'\'';
			
			if ($conn->query($sql_command)){
				$message = 'Success';
			} else {
				$message = $conn->error();
			}	
		} else {
			$message = 'Lack_Info';
		}
		echo $message;
	}
?>