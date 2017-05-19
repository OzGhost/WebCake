<?php
	session_start();
	// echo "<pre>";
	// var_dump($_GET);
	// echo "</pre>";
	$logon = true;
	$valid = true;
	//check input info
	if (!isset($_SESSION["UserID"]) || empty($_SESSION["UserID"])){
		$logon = false;
		$valid = false;
	}
	if (!isset($_GET["thoigian"]) || empty($_GET["thoigian"])) $valid = false;
	if (!isset($_GET["ngaydat"]) || empty($_GET["ngaydat"])) $valid = false;
	if (!isset($_GET["bandat"]) || empty($_GET["bandat"])) $valid = false;
	if (!isset($_GET["banh"]) || empty($_GET["banh"])) $valid = false;
	if (!isset($_GET["nuoc"]) || empty($_GET["nuoc"])) $valid = false;
	
	if ($valid){
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$pass = "ngaymai";
		$db = "u952681548_cake";
		$conn = new mysqli($server, $host, $pass, $db)
			or die ("Can not connect to server! ".$conn->error);
		$sql_cmd = "INSERT INTO DATBAN(USERNAME, MABAN, MABANH, MANUOC, THOIGIAN, NGAYDAT) VALUES('"
			.$_SESSION["UserID"]."', '".$_GET["bandat"]."', ".$_GET["banh"].", ".$_GET["nuoc"].", '".$_GET["thoigian"]."', '".$_GET["ngaydat"]."');";
		if ($conn->query($sql_cmd)){
			echo '<span style="color: green;">Đặt bàn thành công.</span>';
		} else {
			echo $conn->error;
		}
	} else {
		echo "lack info!";
	}

?>