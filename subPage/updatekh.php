<?php
	session_start();
	$valid = true;
	$chpass = false;
	if (!isset($_SESSION["UserID"]) || empty($_SESSION["UserID"])) $valid = false;
	if (!isset($_POST["gt"]) || empty($_POST["gt"])) $valid = false;
	if (!isset($_POST["name"]) || empty($_POST["name"])) $valid = false;
	if (!isset($_POST["bdate"]) || empty($_POST["bdate"])) $valid = false;
	if (!isset($_POST["email"]) || empty($_POST["email"])) $valid = false;
	if (isset($_POST["chpass"]) && !empty($_POST["chpass"])){
		if ($_POST["chpass"] == "true"){
			if (!isset($_POST["oldpass"]) || empty($_POST["oldpass"])) $valid = false;
			if (!isset($_POST["newpass"]) || empty($_POST["newpass"])) $valid = false;
			if (!isset($_POST["repass"]) || empty($_POST["repass"])) $valid = false;
			$chpass = true;
		}
	}
	if ($valid){
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$pass = "ngaymai";
		$db = "u952681548_cake";
		$conn = new mysqli($server, $host, $pass, $db)
			or die ("Can not connect to server! ".$conn->error);
		$sql_cmd = "";

		if ($chpass){
			if ($_POST["newpass"] != $_POST["repass"]) {
				echo "RePass-Wrong";
				$sql_cmd = "";
			} else {
				$sql_cmd = "SELECT PASSWORD FROM KHACHHANG WHERE USERNAME='".$_SESSION["UserID"]."' AND PASSWORD='".$_POST["oldpass"]."';";
				$rs = $conn->query($sql_cmd);
				$row = $rs->fetch_assoc();
				if (!$row){
					echo "OldPass-Wrong";
					$sql_cmd = "";
				} else {
					$sql_cmd = "UPDATE KHACHHANG 
								SET GIOITINH='".$_POST["gt"]."', HOTEN='".$_POST["name"]."', NGAYSINH='".$_POST["bdate"]."', 
								EMAIL='".$_POST["email"]."', PASSWORD='".$_POST["newpass"]."' 
								WHERE USERNAME='".$_SESSION["UserID"]."';";
				}
			}// end else of IF (newpass != repass)
		} else {
			$sql_cmd = "UPDATE KHACHHANG 
						SET GIOITINH='".$_POST["gt"]."', HOTEN='".$_POST["name"]."', NGAYSINH='".$_POST["bdate"]."', 
						EMAIL='".$_POST["email"]."' 
						WHERE USERNAME='".$_SESSION["UserID"]."';";
		}// end else of IF ($chpass)
		// execute command
		if ($sql_cmd){
			if ($conn->query($sql_cmd)){
				echo "Success";
			} else {
				echo $conn->error;
			}
		}
		// close connection
		if ($conn) $conn->close();
	} else {
		echo "Lack-Info";
	}
?>