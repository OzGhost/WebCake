
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
	<title>Đăng xuất</title>
	<meta charset="utf8">
	<link rel="stylesheet" type="text/css" href="../css/tr1-dangxuat.css">
	<link rel="stylesheet" type="text/css" href="../css/tr1-all.css">
</head>
<body>
	<div class="mynav">
	  	<a class="logo" href="../">
		    <img class="img-circle" src="../img/logo.png"/>
		    <h1>Sweet Cakes</h1>
		</a>
		<form action="search.php">
	      <input class="search-bar" type="text" placeholder="Tìm kiếm tên bánh" />
	    </form>
		<div class="accgroup">
			<ul>
	        	<?php
	            	if (isset($_SESSION["UserID"])){
	            		if (! empty($_SESSION["UserID"])){
	            			echo '<li>  
	                        	' . $_SESSION["UserID"] . ' 
	                        	<img class="img-circle" src="../img/user.jpg">
	                            <ul>
	                            	<li class="press">
	                                	<a href="tr1-thongtinchung.php">Thông tin chung</a>
	                            	</li>
	                            	<li>
	                                	<a href="tr1-thongtintk.php">Thông tin tài khoản</a>
	                            	</li>
	                            	<li>
	                                	<a href="tr1-sodiachi.php">Sổ địa chỉ</a>
	                            	</li>
	                            	<li>
	                                	<a href="tr1-donhang.php">Đơn hàng của tôi</a>
	                            	</li>
	                            	<li>
	                                	<a href="tr1-dangxuat.php">Đăng xuất</a>
	                            	</li>
	                            </ul>
	                        </li>
	                        <li>
	                          <a href="giohang.html">
	                            <img src="../img/gio-hang.png">
	                            <span>Giỏ hàng</span>
	                          </a>
	                        </li>
	                        <li><a href="tr1-dangxuat.php">Đăng xuất</a></li>'; 
	            		}
	            	}  else {
	            		echo '<li><a href="../">Bạn chưa đăng nhập!</a></li>';
	            	}
	        	?>
			</ul>
		</div>
	</div>
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
					<a href="tr1-thongtinchung.php">Thông tin chung</a>
				</li>
				<li>
					<a href="tr1-thongtintk.php">Thông tin tài khoản</a>
				</li>
				<li>
					<a href="tr1-sodiachi.php">Sổ địa chỉ</a>
				</li>
				<li>
					<a href="tr1-donhang.php">Đơn hàng của tôi</a>
				</li>
				<?php
					if ($logon){
						echo '<li class="press">
								<a href="tr1-dangxuat.php">Đăng xuất</a>
							</li>';
					}
				?>
			</ul>
		</div>
	</div>
	<div class="bor2">
	
	<!--Từ đầu tới đây là giống nhau -->
		<div class="exit">
			<label>Bạn có chắc chắn muốn đăng xuất?</label>
			<div class="left">Có</div>
			<div class="right">Không</div>
		</div>
	</div>

	<script type="text/javascript" src="../js/jQuery_v1.12.3.min.js"></script>
	<script type="text/javascript" src="../js/tr1-dangxuat.js"></script>
	<script type="text/javascript" src="../js/tr1-all.js"></script>
</body>
