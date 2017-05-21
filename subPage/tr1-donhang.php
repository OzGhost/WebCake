
<?php
// Start the session
session_start();
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
					echo "<span> Bạn chưa đăng nhập! </span>";
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
				<li class="press">
					<a href="subPage/tr1-donhang">Đơn hàng của tôi</a>
				</li>
				<li>
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
		<h2>Danh sách đơn hàng của tôi</h2>
		<div>
		<?php
			$sql_command = "SELECT * FROM HOADON WHERE USERNAME='".$_SESSION["UserID"]."';";
			$rs = $conn->query($sql_command);
			$row = $rs->fetch_assoc();
			if (!$row){
				echo "<p>Bạn chưa có đơn hàng nào cả :)</p>";
			} else {
		?>
			<table>
				<tr>
					<td>
						Mã đơn hàng
					</td>
					<td>
						Ngày mua
					</td>
					<td>
						Sản phẩm
					</td>
					<td>
						Tổng tiền
					</td>
					<td>
						Trạng thái đơn hàng
					</td>
				</tr>
				<?php
					while ($row){
				?>
					<tr>
						<td>
							<?php echo $row["MAHD"];?>
						</td>
						<td>
							<?php echo $row["NGAYTAO"];?>
						</td>
						<td>
							<?php
								$sql_command = 'SELECT b.TENBANH, ct.SOLUONG FROM CTDH ct, BANH b WHERE ct.MABANH=b.MABANH AND ct.MADH='.$row["MAHD"];
								$rs_sd = $conn->query($sql_command);
								$row_sd = $rs_sd->fetch_assoc();
								echo "<ul>";
								while ($row_sd){
									// echo "<li>".$row_sd["TENBANH"]." x ".$row_sd["SOLUONG"];
									echo "<li><span style='color:red;'>".$row_sd["SOLUONG"]."</span> x ".$row_sd["TENBANH"]."</li>";
									$row_sd = $rs_sd->fetch_assoc();	
								}
								echo "</ul>";
							?>
						</td>
						<td>
							<?php 
								$gia = $row["TRIGIA"];
								if ($gia > 1000000){
									echo (int)($gia / 1000000) . ",";
									echo (int)($gia / 1000) - 1000 . ",";
								} else {
									echo (int)($gia / 1000) . ",";	
								}
								if ( ($gia % 1000) == 0 ){
									echo "000";
								} else {
									echo $gia % 1000;
								}
							?>đ
						</td>
						<td>
							<?php
								switch($row["TRANGTHAI"]){
									case 1: echo "Mới đặt"; break;
									case 2: echo "Đang giao"; break;
									case 3: echo "Giao thành công"; break;
									default: echo "Giao thất bại!"; break;
								}
							?>
						</td>
					</tr>
				<?php
						$row = $rs->fetch_assoc();
					}// end WHILE ($row)
				?>

			</table>
		<?php
			}// end of IF ($row)
		?>
		</div>
	</div>
	<script type="text/javascript" src="js/info-all.js"></script>