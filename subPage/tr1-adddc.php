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
	<link rel="stylesheet" type="text/css" href="css/tr1-adddc.css">
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
				<li class="press">
					<a href="subPage/tr1-thongtintk">Thông tin tài khoản</a>
				</li>
				<li>
					<a href="subPage/tr1-sodiachi">Sổ địa chỉ</a>
				</li>
				<li>
					<a href="subPage/tr1-donhang">Đơn hàng của tôi</a>
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
		<div class="infor">
			<!--Từ đầu tới đây là giống nhau -->
			<h2>Thông tin tài khoản</h2>
			<div class="infor">
				<form method="POST">
					<div class="one">
						<label>Họ tên</label>
						<span>
							<input type="text" id="name" required="required">
						</span>
					</div>
					<div class="two">
						<label>Số điện thoại</label>
						<span>
							<input type="text" id="number" required="required">
						</span>
					</div>

					<div class="three">
						<label>Tỉnh/Thành phố</label>
						<span>
							<input type="text" id="city" required="required">
						</span>
					</div >
					<div class="four">
						<label>Quận huyện</label>
						<span>
							<input type="text" id="district" required="required">
						</span>
					</div >
					<div class="five">
						<label>Phường xã</label>
						<span>
							<input type="text" id="commune" required="required">
						</span>
					</div >
					<div class="six">
						<label>Địa chỉ</label>
						<span>
							<textarea id="address" rows="5" cols="40" required="required"></textarea>
						</span>
					</div >
					
					<div class="footer">
						<div class="hide" name="addadd-error">
			              <span  class="glyphicon glyphicon-exclamation-sign"></span>
			              <span>message here :)</span>
			            </div>
						<input type="submit" value="CẬP NHẬT" id="update">
					</div>

				</form><!-- End Addsdc -->
			</div>
		</div>
		
	</div>
	<script type="text/javascript" src="js/info-all.js"></script>
	<script type="text/javascript" src="js/tr1-adddc.js"></script>
</body>
</html>