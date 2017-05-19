<?php
	session_start();
	//echo "<pre>";
	//var_dump($_GET);
	//echo "</pre>";
?>
	<div class="content"> 
		<div class="star2">
			<img src="img/buoc2.png">
			Chọn cách thanh toán
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
								?></label><span> đ</span>
				</div>
				<!--Hình ảnh sản phẩm -->
			</div>
			<div class="buy">
				<div class="afterbuy">
					<b>Người đặt:</b> <?php echo $_GET['ten'];?> <br>
					<b>Số điện thoại:</b> <?php echo $_GET['sdt'];?> <br>
					<b>Email:</b> <?php echo $_GET['email'];?> <br>
					<b>Tổng tiền:</b> <label><?php
												echo (int)($_GET['gia'] / 1000 ). ",";
												if (($_GET['gia'] % 1000 ) == 0){
													echo "000";
												} else {
													echo $_GET['gia'] % 1000;
												}
											?>đ</label><br>
					Chọn 1 trong 3 cách thanh toán miễn phí sau: <br>
					<input type="radio" id="item1" name="pttt" value="1" checked> <label for="item1">Trả bằng tiền mặt sau khi nhận hàng</label><br>
					<input type="radio" id="item2" name="pttt" value="2"><label for="item2">Trả bằng ATM, Visa sau khi nhận hàng</label><br>
					<input type="radio" id="item3" name="pttt" value="3"><label for="item3">Thanh toán trực tuyến (ATM, Visa)</label><br>
				</div>
				
				
				<div class="finally">
					<input type="submit" value="Hoàn tất" id="done">
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript">
	$("#done").on('click', function(){
		var httt = $("input[name='pttt']:checked").val();
		var xml = new XMLHttpRequest();
		xml.onreadystatechange = function(){
			if (xml.readyState == 4 && xml.status == 200){
				wall.upWithPane(xml.responseText);
			}
		};
		if (<?php echo $_GET["giaohang"];?>){
			xml.open('GET', 'subPage/addressChoosing.php?mabanh=<?php echo $_GET["mabanh"];?>&gia=<?php echo $_GET["gia"];?>&ten=<?php echo $_GET["ten"];?>&sdt=<?php echo $_GET["sdt"];?>&email=<?php echo $_GET["email"];?>&gt=<?php echo $_GET["gt"];?>&giaohang=<?php echo $_GET["giaohang"];?>&httt='+httt, true);
		} else {
			xml.open('GET', 'subPage/orderDone.php?mabanh=<?php echo $_GET["mabanh"];?>&ten=<?php echo $_GET["ten"];?>&sdt=<?php echo $_GET["sdt"];?>&email=<?php echo $_GET["email"];?>&gt=<?php echo $_GET["gt"];?>&giaohang=<?php echo $_GET["giaohang"];?>&httt='+httt+"&diachi=DefaultLocation", true);
		}
		xml.send();
	});
</script>