<?php
	session_start();
	//echo "<pre>";
	//var_dump($_GET);
	//echo "</pre>";
	$logon = false;
	if (isset($_SESSION["UserID"]) && !empty($_SESSION["UserID"])) $logon = true;

	
?>
	<div class="content"> 
		<div class="star1">
			<img src="img/buoc1.png">
			Đặt mua
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
			<div class="buy">
				<ol>
					<li>
						Thông tin người mua
						 <input type="radio" id="man" name="gt" value="nam" checked/><label for="man"> Anh</label>
						 <input type="radio" id="woman" name="gt" value="nu" ><label for="woman"> Chị</label><br><br>
						<input type="text" id="name" placeholder="Họ tên (bắt buộc)" /><br><br>
						<input type="number" id="phone" placeholder="Số điện thoại (bắt buộc)" /><br><br>
						<input type="email" id="email" placeholder="Email (để nhận thông tin đặt hàng)" /><br><br>
					</li>
					<li>
						Chọn phương thức nhận hàng<br><br>
						<input type="radio" id="cach1" name="httt"checked value="true"><label for="cach1"> Giao tận nơi</label>
						<input type="radio" id="cach2" name="httt" value="false"><label for="cach2"> Nhận ở cửa hàng </label><br><br>
					</li>

				</ol>
				<div class="hide" name="notice">
					<span  class="glyphicon glyphicon-exclamation-sign"></span>
					<span>message here :)</span>
				</div>
				<div class="first">
					<a href="#dathang"><input type="submit" id="dathang" value="Tiếp tục"></a>
				</div>
				
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$("a[href='#dathang']").on('click', function(e){
			e.preventDefault();
			var name = $("input[id='name']").val();
			var phone = $("input[id='phone']").val();
			var email = $("input[id='email']").val();
			var gt = $("input[name='gt']:checked").val();
			var gh = $("input[name='httt']:checked").val();
			var message = "";
			if (!email) message = "Chưa nhập email!";
			if (!phone) message = "Chưa nhập số điện thoại!";
			if (!name) message = "Chưa nhập họ tên!";
			if (message){
				$("div[name='notice'] span:last").html(message);
				$("div[name='notice']").removeClass("hide");
			} else {
				$("div[name='notice']").addClass("hide");
				var xml = new XMLHttpRequest();
				xml.onreadystatechange = function(){
					if (xml.readyState == 4 && xml.status == 200){
						wall.upWithPane(xml.responseText);
					}
				};
				xml.open('GET', "subPage/tr1-hoantat.php?mabanh=<?php echo $_GET['mabanh'];?>&hinhanh=<?php echo $_GET['hinhanh'];?>&gia=<?php echo $_GET['gia'];?>&ten="+name+"&sdt="+phone+"&email="+email+"&gt="+gt+"&giaohang="+gh, true);
				xml.send();
			}
		});
	</script>
