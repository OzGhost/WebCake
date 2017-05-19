
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
	<link rel="stylesheet" type="text/css" href="css/tr1-sodiachi.css">
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
				<li class="press">
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
		<div class="content">
			<h2>Sổ địa chỉ</h2>
			<?php
				$have_sdc = true;
				if ($logon){
					$sql_command = 'SELECT * FROM SODIACHI WHERE USERNAME=\''.$_SESSION["UserID"].'\'';
					$res = $conn->query($sql_command);
					$row = $res->fetch_assoc();
					if ($row == NULL){
						echo "Bạn chưa có sổ địa chỉ nào cả";
						$have_sdc = false;
					} else {
						$index = 1;
						$sql_command = 'SELECT SDC FROM KHACHHANG WHERE USERNAME=\''.$_SESSION["UserID"].'\'';
						$restmp = $conn->query($sql_command);
						$khtmp = $restmp->fetch_assoc();

						echo '<div class="dsSDC">';
						while ($row != NULL){
							if ($row["MASDC"] === $khtmp["SDC"]){
								echo '<div class="itemDC default" id="'.$row["MASDC"].'">';
							} else {
								echo '<div class="itemDC" id="'.$row["MASDC"].'">';
							}
							echo '<table>
											<tr><td rowspan="2">'.$index.'</td><td>'.$row["HOTEN"].' - '.$row["SDT"].'</td></tr>
											<tr><td>'.$row["DIACHI"].', '.$row["XA_PHUONG"].', '.$row["QUAN_HUYEN"].', '.$row["TINH_TP"].'</td></tr>
										</table>
									</div>';
							$index++;
							$row = $res->fetch_assoc();
						}
						echo '</div>';
					}
				}
			?>
			<div class="hide" name="addr-notice">
				<span  class="glyphicon glyphicon-exclamation-sign"></span>
				<span>message here :)</span>
			</div>
		</div>
		<div class="adress">
			<a href="tr1-adddc">Thêm địa chỉ mới</a>
		</div>
		<?php
			if ($have_sdc){

		?>
		<div class="adress">
			<a href="removeAd">Xóa địa chỉ</a>
		</div>
		<div class="adress" id="setdefault">
			<span>Đặt làm<br/>mặc định</span>
		</div>
		<?php
			}// end IF ($have_sdc)
		$conn->close();
		?>
	</div>
<script type="text/javascript" src="js/info-all.js"></script>
<script type="text/javascript" src="js/tr1-sodiachi.js"></script>