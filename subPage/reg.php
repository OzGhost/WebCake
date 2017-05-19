<?php
	// Start the session
	session_start();
	$valid = true;
	if (!isset($_POST["user"]) || empty($_POST["user"])) $valid = false;
	if (!isset($_POST["pass"]) || empty($_POST["pass"])) $valid = false;
	if (!isset($_POST["repass"]) || empty($_POST["repass"])) $valid = false;
	if (!isset($_POST["email"]) || empty($_POST["email"])) $valid = false;

	if ($valid){
		if ($_POST["pass"] != $_POST["repass"]){
			echo "RePass-Wrong";
		} else {
			$server = "mysql.hostinger.vn";
			$host = "u952681548_root";
			$pass = "ngaymai";
			$db = "u952681548_cake";
			$conn = new mysqli($server, $host, $pass, $db)
				or die ("Can not connect to server! ".$conn->error);

			$sql_cmd = "SELECT USERNAME FROM KHACHHANG WHERE USERNAME='".$_POST["user"]."';";
			$rs = $conn->query($sql_cmd);
			$row = $rs->fetch_assoc();
			if ($row){
				echo "User-Existed";
			} else {
				$sql_cmd = "INSERT INTO KHACHHANG(USERNAME, PASSWORD, EMAIL) VALUES(
					'".$_POST["user"]."', '".$_POST["pass"]."', '".$_POST["email"]."');";
				if ( $conn->query($sql_cmd) ){
					echo "Success";
				} else {
					echo $conn->error;
				}
			}// end else of IF ($row)
			if ($conn) $conn->close();
		}// end else of IF (pass != repass)
	} else {
		echo "lack info!";
	}// end else of IF ($valid)
?>