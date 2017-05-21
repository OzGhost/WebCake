<header>
	<link rel="stylesheet" type="text/css" href="css/giohang.css">
</header>
<?php
	session_start();
	//echo "<pre>";
	//var_dump($_SESSION["giohang"]);
	//echo "</pre>";
?>
	
		<?php
			if (!isset($_SESSION["giohang"]) && empty($_SESSION["giohang"])) {
				echo "<pre align='center'><h2>Giỏ hàng chưa có gì cả :)</h2></pre>";
			} else {
				echo '<div class="center">';
				if (isset($_GET["throwout"]) && !empty($_GET["throwout"])){
					unset($_SESSION["giohang"][$_GET["throwout"]]);
					if (count($_SESSION["giohang"]) == 0) unset($_SESSION["giohang"]);
				}
		?>
		<table>
			<?php
				$server = "mysql.hostinger.vn";
				$host = "u952681548_root";
				$pass = "ngaymai";
				$db = "u952681548_cake";
				$conn = new mysqli($server, $host, $pass, $db)
					Or die ("Can not connect to server! ".$conn->error);
				$index = 0;
				foreach ($_SESSION["giohang"] as $key => $value){
					$sql_command = "SELECT * FROM BANH WHERE MABANH=$key;";
					$rs = $conn->query($sql_command);
					$row = $rs->fetch_assoc();
					if ($row){
						$gia = (int)$value * ((int)$row["GIA"] * (float)(1-$row["GIAMGIA"]));
						$gia = (int)$gia;
						$s += $gia;
			?>
			<tr>
				<td><?php $index++; echo $index;?></td>
				<td class="lineheight">
					<img src="img/cake-sm/<?php echo $row["TENHINHANH"];?>">
					<span class="updatecenter"><?php echo $row["TENBANH"];?></span> 
				</td>
				<td><?php echo "x ". $value;?></td>
				<td>
					Tổng Giá :<br/> <b><?php
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
									?>đ</b>
				</td>
				<td><a href="#throwOut" mabanh="<?php echo $key;?>" ><span class="fa fa-times-circle-o" aria-hidden="true"></span></a></td>
			</tr>
			<?php
					}//end IF ($row)
				}//end foreach ($i < 10)
			?>			
		</table>
		<div class="pay">
			<p>Tổng Cộng: <?php
							if ($s > 1000000){
								echo (int)($s / 1000000) . ",";
								echo (int)($s / 1000) - 1000 . ",";
							} else {
								echo (int)($s / 1000) . ",";	
							}
							if ( ($s % 1000) == 0 ){
								echo "000";
							} else {
								echo $s % 1000;
							}
						;?> VND <input type="button" value="Thanh Toán" /></p>
		</div>
	</div>

<script type="text/javascript">
	$(".pay input[type='button']").on('click', function(){
		var xml = new XMLHttpRequest();
		xml.onreadystatechange = function(){
			if (xml.readyState == 4 && xml.status == 200){
				wall.upWithPane(xml.responseText);
			}
		};
		xml.open('GET', 'subPage/payBag.php', true);
		xml.send();
	});

	$("a[href='#throwOut']").on('click', function(e){
		e.preventDefault();
		var sl = <?php echo $index;?>;
		var mb = $(this).attr("mabanh");
		var xml = new XMLHttpRequest();

		if (<?php echo count($_SESSION["giohang"]);?> == 1){
			wall.upWithPane("<pre align='center'><h2>Giỏ hàng chưa có gì cả :)</h2></pre>");
		} else {
			xml.onreadystatechange = function(){
				if (xml.readyState == 4 && xml.status == 200){
					wall.upWithPane(xml.responseText);
				}
			};
		}
		xml.open('GET', 'subPage/giohang.php?throwout='+mb, true);
		xml.send();
		sl--;
		$("a[href='#giohang']").children("span").text("Giỏ hàng("+sl+")");
	});
</script>
<?php
	}// End else of IF (isset && !empty)
?>