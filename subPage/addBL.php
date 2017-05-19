<?php
	if (isset($_GET["mb"]) && !empty($_GET["mb"]) && isset($_GET["user"]) && !empty($_GET["user"]) && isset($_GET["nd"]) && !empty($_GET["nd"])){
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$pass = "ngaymai";
		$db = "u952681548_cake";
		$conn = new mysqli($server, $host, $pass, $db)
			or die ("can not connect to server! ".$conn->error);
		$sql_command = 'INSERT INTO BINHLUAN (MABANH, USERNAME, NOIDUNG) VALUES(\''.$_GET["mb"].'\', \''.$_GET["user"].'\', \''.$_GET["nd"].'\')';
		$conn->query($sql_command);
	}
?>