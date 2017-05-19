<?php
	session_start();
	// echo "<pre>";
	// var_dump($_GET);
	// echo "</pre>";

	// kiem tra logn
	$logon = false;
	if (isset($_SESSION["UserID"]) && !empty($_SESSION["UserID"])){
		$logon = true;
		$user = $_SESSION["UserID"];
	}

	$quick = true;
	if (!isset($_GET["mabanh"]) || empty($_GET["mabanh"])){
		$quick = false;
		if (!isset($_SESSION["giohang"]) || empty($_SESSION["giohang"])) $valid = false;
	}

	// kiem tra cac doi so can thiet
	$valid = true;

	if (!isset($_GET["ten"]) || empty($_GET["ten"])) $valid = false;
	if (!isset($_GET["gt"]) || empty($_GET["gt"])) $valid = false;
	if (!isset($_GET["sdt"]) || empty($_GET["sdt"])) $valid = false;
	if (!isset($_GET["email"]) || empty($_GET["email"])) $valid = false;
	if (!isset($_GET["giaohang"]) || empty($_GET["giaohang"])) $valid = false;
	if (!isset($_GET["httt"]) || empty($_GET["httt"])) $valid = false;
	if (!isset($_GET["diachi"]) || empty($_GET["diachi"])) $valid = false;

	if ($valid){
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$pass = "ngaymai";
		$db = "u952681548_cake";
		$conn = new mysqli($server, $host, $pass, $db)
			Or die ("Can not connect to server! ". $conn->error);
		$sql_command = 'SELECT MAHD FROM HOADON ORDER BY MAHD DESC';
		$billID = 1;

		$rs = $conn->query($sql_command);
		$row = $rs->fetch_assoc();
		if ($row){
			$billID = 1 + (int)$row["MAHD"];
		}

		// dat USERNAME = autoSys khi khach hang ko dang nhap
		if (!$logon) $_SESSION["UserID"] = "autoSys";
		
		if (!$quick){// truong hop thanh toan gio hang
			// nap du lieu vao bang HOADON truong hop thanh toan gio hang
			$sql_command = 'INSERT INTO HOADON(MAHD, HOTEN, GIOITINH, SDT, EMAIL, GIAOHANG, HTTT, DIACHI, USERNAME) VALUES('
				.$billID.', \''
				.$_GET["ten"].'\', \''
				.$_GET["gt"].'\', \''
				.$_GET["sdt"].'\', \''
				.$_GET["email"].'\', '
				.$_GET["giaohang"].', '
				.$_GET["httt"].', \''
				.$_GET["diachi"].'\', \''
				.$_SESSION["UserID"].'\');';
			$conn->query($sql_command);
			if (!$logon) unset($_SESSION["UserID"]);

			// nap du lieu bao bang CTDH va bang BANH truong hop thanh toan gio hang
			$cost = 0;
			foreach ($_SESSION["giohang"] as $key => $value) {
				$sql_command = "SELECT GIA, SOLANBAN FROM BANH WHERE MABANH=$key;";
				$rs = $conn->query($sql_command);
				$row = $rs->fetch_assoc();
				$slb = 0;
				if ($row){
					$cost += (int)$row["GIA"];
					$slb = (int)$row["SOLANBAN"] + 1;
				}
				$sql_command = 'INSERT INTO CTDH VALUES('
					.$key.', '
					.$billID.', '
					.$value.');';
				$conn->query($sql_command);

				$sql_command = "UPDATE BANH SET SOLANBAN=".$slb." WHERE MABANH=$key;";
				$conn->query($sql_command);
			}
			$sql_command = "UPDATE HOADON SET TRIGIA=$cost, TRANGTHAI=1 WHERE MAHD=$billID;";
			$conn->query($sql_command);

		} else {// ELSE of IF (!quick) truong hop mua nhanh
			$sql_command = "SELECT GIA, SOLANBAN FROM BANH WHERE MABANH=".$_GET["mabanh"].";";
			$rs = $conn->query($sql_command);
			$row = $rs->fetch_assoc();
			$cost = 0;
			$slb = 0;
			if (!$row){
				echo "<h2>Có lỗi trong quá trình thực hiện (mã bánh ko tồn tại)</h2>";
			} else {
				$cost = (int)$row["GIA"];
				// nap du lieu vao bang HOADON truong hop mua nhanh
				$sql_command = 'INSERT INTO HOADON(MAHD, TRIGIA, HOTEN, GIOITINH, SDT, EMAIL, GIAOHANG, HTTT, DIACHI, USERNAME, TRANGTHAI) VALUES('
					.$billID.', '
					.$cost.', \''
					.$_GET["ten"].'\', \''
					.$_GET["gt"].'\', \''
					.$_GET["sdt"].'\', \''
					.$_GET["email"].'\', '
					.$_GET["giaohang"].', '
					.$_GET["httt"].', \''
					.$_GET["diachi"].'\', \''
					.$_SESSION["UserID"].'\', 1);';
				$conn->query($sql_command);

				$slb = (int)$row["SOLANBAN"] + 1;
				$sql_command = "UPDATE BANH SET SOLANBAN=".$slb." WHERE MABANH=".$_GET["mabanh"].";";
				$conn->query($sql_command);

				// cong XU
				$cost /= 10000;
				$cost = (int)$cost;
				$sql_command = "SELECT XU FROM KHACHHANG WHERE USERNAME='".$_SESSION["UserID"]."';";
				$rs = $conn->query($sql_command);
				$row = $rs->fetch_assoc();
				$xu = (int)$row["XU"] + $cost;
				$sql_command = "UPDATE KHACHHANG SET XU=".$xu." WHERE USERNAME='".$_SESSION["UserID"]."';";
				$conn->query($sql_command);
				// unset if !logon
				if (!$logon) unset($_SESSION["UserID"]);

				// nap du lieu vao bang CTDH truong hop mua nhanh
				$sql_command = 'INSERT INTO CTDH VALUES('
					.$_GET["mabanh"].', '
					.$billID.', 1);';
				$conn->query($sql_command);
			}
			
		}// end else of IF (!quick)
		echo '<h1 align="center" style="color: green;">Đặt hàng thành công!</h1>';
		echo '<script type="text/javascript">$("a[href=\'#giohang\']").children("span").text("Giỏ hàng(0)");</script>';
		// foreach ($_SESSION["giohang"] as $key => $value){
		// 	echo "<pre>";
		// 	echo $_SESSION["giohang"]["$key"];
		// 	echo "</pre>";
		// }
		unset($_SESSION["giohang"]);
	} else {
		echo "<pre><h2 align='center'>Đặt hàng thất bại (thông tin còn thiếu).</h2></pre>";
	}
?>