
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
	<link rel="stylesheet" type="text/css" href="css/tr1-thongtinchung.css">
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
				<li class="press">
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
		<div class="informa">
			<h2>Bảng thông tin của tôi</h2>
			<div>
				<span>Thông tin tài khoản</span>
				<a href="tr1-thongtintk"><span>Chỉnh sửa ></span></a>
			</div>
		</div>
		

		<div class="framew">
			Họ và tên: 
			<?php
				if ($logon){
					if ($row["HOTEN"] == NULL){
						echo "Chưa đặt";
					} else {
						echo $row["HOTEN"];
					}
				} else {
					echo "<span style='color: white; background-color: gray;'> Bạn chưa đăng nhập! </span>";
				}
			?><br>
			Email: 
			<?php
				if ($logon){
					if ($row["EMAIL"] == NULL){
						echo "Chưa đặt";
					} else {
						echo $row["EMAIL"];
					}
				} else {
					echo "<span style='color: white; background-color: gray;'> Bạn chưa đăng nhập! </span>";
				}
			?>
		</div>
		<div class="face1">
			Bạn có <span>
			<?php
				if ($logon){
					if ($row["XU"] == NULL){
						echo "0";
					} else {
						echo $row["XU"];
					}
				} else {
					echo "0";
				}
			?></span> xu trong tài khoản
		</div>
		<hr>
		<div class="adress">
			<h3>Sổ địa chỉ</h3>
			<?php
				if ($logon){

					$sql_command = 'SELECT SDC FROM KHACHHANG WHERE USERNAME=\''.$_SESSION["UserID"].'\'';
					$res = $conn->query($sql_command);
					$row = $res->fetch_assoc();

					$idCode = $row["SDC"];

					$sql_command = 'SELECT * FROM SODIACHI WHERE MASDC=\''.$idCode.'\'';
					$res = $conn->query($sql_command);
					$row = $res->fetch_assoc();

					if ($row == NULL){
						echo 'Bạn chưa thiết lập địa chỉ giao hàng mặc định <br><br>';
					} else {
						echo '<div class="defaultDC">
									<table>
										<tr><td>'.$row["HOTEN"].' - '.$row["SDT"].'</td></tr>
										<tr><td>'.$row["DIACHI"].', '.$row["XA_PHUONG"].', '.$row["QUAN_HUYEN"].', '.$row["TINH_TP"].'</td></tr>
									</table>
								</div>';
					}
				}
			?>
			
			
		</div>
		<div class="addadress">
			<a href="tr1-adddc">Thêm địa chỉ mới</a>
		</div>
		<hr>
		<div>
			<div class="foot1">
				<h3>Danh sách bạn bè</h3>
				Bạn có <span>0</span> bạn bè
			</div>

			<div class="foot2">
				<a href="https://www.facebook.com/">Thêm bạn bè bằng facebook</a>
			</div>
		</div>
	</div>

	<!-- Close Connection -->
	<?php
		if ($logon){
			$conn->close();
		}
	?>
	<script type="text/javascript" src="js/info-all.js"></script>
	<script type="text/javascript" src="js/tr1-thongtinchung.js"></script>
</body>
</html>