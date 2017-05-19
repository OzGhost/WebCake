<?php
// Start the session
session_start();
	$have_ddb = true;
	$logon = false;
	if ( isset($_SESSION["UserID"]) && !empty($_SESSION["UserID"])){
		$logon = true;
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$hostpass = "ngaymai";
		$db = "u952681548_cake";
		$conn = new mysqli($server, $host, $hostpass, $db);
		if ($conn->connect_error) {
  			die("Connection failed: " . $conn->connect_error);
		}

		$sql_command = 'SELECT * FROM KHACHHANG WHERE USERNAME = \'' . $_SESSION["UserID"] . '\'';
		$res = $conn->query($sql_command);
		$row = $res->fetch_assoc();
	}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/tr1-donhang.css">
	<link rel="stylesheet" type="text/css" href="css/tr1-dondatban.css">
</head>
<body>
	<div class="bor1">
		<div class="user">
			Tài khoản của<br>
			<?php
				if ($logon) {
					if ($row["HOTEN"] == NULL){
						echo "Tôi";
					} else {
						echo $row["HOTEN"];
					}
				} else {
					echo "<span style='color: white; background-color: gray;'> Bạn chưa đăng nhập! </span>";
				}
			?>
		</div>
		<div class="list">
			<ul>
				<li>
					<a href="subPage/tr1-thongtinchung">Thông tin chung</a>
				</li>
				<li>
					<a href="subPage/tr1-thongtintk">Thông tin tài khoản</a>
				</li>
				<li>
					<a href="subPage/tr1-sodiachi">Sổ địa chỉ</a>
				</li>
				<li>
					<a href="subPage/tr1-donhang">Đơn hàng của tôi</a>
				</li>
				<li class="press">
					<a href="subPage/tr1-dondatban">Thông tin đặt bàn</a>
				</li>
				<?php
					if ($logon){
						echo '<li>
								<a href="dangxuat">Đăng xuất</a>
							</li>';
					}
				?>
			</ul>
		</div>
	</div>

	<div class="bor2">

			<!--Từ đầu tới đây là giống nhau -->
		<h2>Danh sách đặt bàn của tôi</h2>
		<div class="order-list">
		<?php
			$sql_command = "SELECT * FROM DATBAN WHERE USERNAME='".$_SESSION["UserID"]."';";
			$rs = $conn->query($sql_command);
			$row = $rs->fetch_assoc();
			if (!$row){
				echo "Bạn chưa đặt bàn nào cả.";
				$have_ddb = false;
			} else {
		?>
			<table class="dsdb">
				<tr>
					<td>Mã đặt bàn</td>
					<td>Bàn đặt</td>
					<td>Ngày đặt</td>
					<td>Thời gian</td>
					<td>Bánh</td>
					<td>Nước</td>
				</tr>
			
		<?php
				while ($row){
		?>
				<tr>
					<td><?php echo $row["MADB"];?></td>
					<td><?php echo $row["MABAN"];?></td>
					<td><?php echo $row["NGAYDAT"];?></td>
					<td><?php echo $row["THOIGIAN"];?></td>
					<td><?php
							if (!$row["MABANH"]){
								echo "...";
							} else {
								$sql_commandnd = "SELECT TENBANH FROM BANH WHERE MABANH='".$row["MABANH"]."';";
								$rsnd = $conn->query($sql_commandnd);
								$rownd = $rsnd->fetch_assoc();
								if ($rownd){
									echo $rownd["TENBANH"];
								}
							}
						 ?></td>
					<td><?php
							if (!$row["MANUOC"]){
								echo "...";
							} else {
								$sql_commandnd = "SELECT TENNUOC FROM NUOC WHERE MANUOC='".$row["MANUOC"]."';";
								$rsnd = $conn->query($sql_commandnd);
								$rownd = $rsnd->fetch_assoc();
								if ($rownd){
									echo $rownd["TENNUOC"];
								}
							}
						 ?></td>					
				</tr>
		<?php
					$row = $rs->fetch_assoc();
				}// end WHILE ($row)
		?>
			</table><!-- end of table dsdb -->
		<?php
			}// end else of IF ($row)
		?>
		</div> <!-- end of order-list -->
		<?php
			if ($have_ddb){
		?>
		<p class="remote-btn">
			<a href="#huydatban"><span>Hủy đặt bàn</span></a>
			<span class="notice hide">Message here :)</span>
		</p>
		<?php
			}// end IF($have_ddb)
		?>
	</div>
	<script type="text/javascript" src="js/info-all.js"></script>
	<script type="text/javascript" src="js/tr1-dondatban.js"></script>