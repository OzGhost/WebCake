<?php
	session_start();
	//echo "<pre>";
	//var_dump($_GET);
	//echo "</pre>";
	$logon = false;
	if (isset($_SESSION["UserID"]) && !empty($_SESSION["UserID"])) $logon = true;

	
?>
	<div class="content"> 
		<div class="star3">
			<img src="img/gio-hang.png">Thêm vào giỏ hàng
		</div>
		<div class="product">
			<div class="image">
				<img src="img/cake-md/<?php echo $_GET['hinhanh'];?>">
				<div class="money">
					Giá: <label><?php
									echo (int)($_GET['gia'] / 1000 ). ",";
									if (($_GET['gia'] % 1000 ) == 0){
										echo "000";
									} else {
										echo $_GET['gia'] % 1000;
									}
								?>đ</label>
				</div>
				<!--Hình ảnh sản phẩm -->
			</div>
			<div class="soluong">
				<label for="sl">Số lượng:</label>
				<input id="sl" type="number" min="1" value="1"/>
				<div class="first">
					<a href="#themvaogiohang"><input type="submit" id="themvaoGH" value="Thêm vào giỏ hàng"></a>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript">
	$(".soluong #themvaoGH").on('click', function(e){
		e.preventDefault();
		var sl = $("#sl").val();
		var xml = new XMLHttpRequest();
		xml.open('GET', 'subPage/addToBag.php?mabanh=<?php echo $_GET["mabanh"];?>&sl='+sl, true);
		xml.send();
		$(".myModal").removeClass("active");
		$(".myModal .dialog").children("*").not($("span.close-dialog")).remove();
		onToggle = false;
		runable = true;
		scrollable = true;
		var tat = 'Giỏ hàng (<?php
								if (isset($_SESSION["giohang"]) && !empty($_SESSION["giohang"])){
									$exist = false;
									foreach($_SESSION["giohang"] as $key => $value){
										if ($key == $_GET["mabanh"]){
											echo count($_SESSION["giohang"]);
											$exist = true;
											break;
										}
									}
									if (!$exist){
										echo count($_SESSION["giohang"]) + 1;
									}
								} else {
									echo "1";
								}
							?>)';
		$("a[href='#giohang']").children("span").text(tat);
	});
</script>
