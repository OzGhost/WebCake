<?php
	session_start();
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	if (!empty($_POST["name"]) && !empty($_POST["number"]) && !empty($_POST["city"]) && !empty($_POST["district"]) && !empty($_POST["commune"]) && !empty($_POST["address"])){
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$hostpass = "ngaymai";
		$db = "u952681548_cake";

		$conn = new mysqli($server, $host, $hostpass, $db)
			or die ("Can't connect to server!" . $conn->error);

		$sql_command = 'INSERT INTO SODIACHI VALUES(NULL, \'' .$_SESSION["UserID"]. '\', \'' .$_POST["name"]. '\', \'' .$_POST["number"]. '\', \'' .$_POST["city"]. '\', \'' .$_POST["district"]. '\', \'' .$_POST["commune"]. '\', \'' .$_POST["address"]. '\');';

		if ($conn->query($sql_command)){
			$message = 'Success';
		} else {
			$message = $conn->error;
		}
		$conn->close();
	} else {
		$message = 'Lack-Info';
	}
	echo $message;
?>