<?php
	session_start();
	$valid = true;
	// var_dump($_POST);
	if (!isset($_POST["Username"]) || empty($_POST["Username"])) $valid = false;
	if (!isset($_POST["Password"]) || empty($_POST["Password"])) $valid = false;

	if ($valid){
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$hostpass = "ngaymai";
		$db = "u952681548_cake";

		$conn = new mysqli($server, $host, $hostpass, $db)
			Or die ("Can't create database connection! " . $conn->error);

		$sql_cmd = "SELECT PASSWORD FROM KHACHHANG WHERE USERNAME='".$_POST["Username"]."';";
		$rs = $conn->query($sql_cmd);
		$row = $rs->fetch_assoc();
		if (!$row){
			echo "User-Wrong";
		} else {
			if ($row["PASSWORD"] != $_POST["Password"]){
				echo "Pass-Wrong";
			} else {
				echo "Success";
				$_SESSION["UserID"] = $_POST["Username"];
			}
		}

		$conn->close();
	} else {
		echo "lack info!";
	}
	// header('Location: ../');
?>