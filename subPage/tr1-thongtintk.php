
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
	<link rel="stylesheet" type="text/css" href="css/tr1-thongtintk.css">
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
				<li >
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
		<h2>Thông tin tài khoản</h2>
		<div class="infor">
			<form action="updatekh.php" method="POST" id="updateI">
				<div class="one">
					<label>Giới tính</label>
					
					<span class="difi">
						<?php 
							if ($logon){
								if ($row["GIOITINH"] == "nu"){
									echo '<input type="radio" name="gt" value="nam" >Nam
											<input type="radio" name="gt" value="nu"  checked="checked">Nữ';
								} else {
									echo '<input type="radio" name="gt" value="nam" checked="checked">Nam
											<input type="radio" name="gt" value="nu" >Nữ';
								}
							}
						?>
					</span>
					
				</div>
				<div class="two">
					<label>Họ tên</label>
					<span>
						<input type="text" id="name" name="name" <?php 
														if ($logon){
															echo 'value= "' . $row["HOTEN"] . '"';
														}
													?> >
					</span>
				</div>
				<div class="three">
					<label>Ngày sinh</label>
					<span class="difi2">
						<input type="date" id="date" name="bday" placeholder="yyyy-mm-dd" <?php 
														if ($logon){
															echo 'value= "' . $row["NGAYSINH"] . '"';
														}
													?> >
					</span>
				</div>

				<div class="four">
					<label>Email</label>
					<span>
						<input type="email" id="email" name="email" <?php 
												if ($logon){
													echo 'value= "' . $row["EMAIL"] . '"';
												}
											?> >
					</span>
					
				</div >
				<div class="five">
					<input type="checkbox" id="changepass" name="chpass">
					<label for="changepass">Thay đổi mật khẩu</label>
				</div>
				<div id="readd">
				
					<div class="six" >
						<label>Mật khẩu cũ</label>
						<span>
							<input type="password" id="pass" name="oldpass" placeholder="Nhập mật khẩu cũ">
						</span>
						
					</div>
					<div class="seven ">
						<label>Mật khẩu mới</label>
						<span>
							<input type="password" id="nepass" name="newpass" placeholder="Nhập mật khẩu mới">
						</span>
						
					</div>
					<div class="eight">
						<label>Nhập lại mật khẩu</label>
						<span>
							<input type="password" id="repass" name="repass" placeholder="Nhập lại mật khẩu mới">
						</span>
						
					</div>

				</div>
				<div class="footer">
					<div class="hide" name="updateI-error">
		              <span  class="glyphicon glyphicon-exclamation-sign"></span>
		              <span>message here :)</span>
		            </div>
					<input type="submit" value="CẬP NHẬT">
				</div>

			</form><!-- End updatekh -->
			<p><?php
				if( isset($_SESSION["message"]) && !empty($_SESSION["message"]) ){
					echo $_SESSION["message"];
					unset($_SESSION["message"]);
				}
			?></p>
		</div>
		
	</div>
	<script type="text/javascript" src="js/tr1-thongtintk.js"></script>
	<script type="text/javascript" src="js/info-all.js"></script>
</body>
</html>