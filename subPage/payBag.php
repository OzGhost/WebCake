<?php
	session_start();
	if (!isset($_SESSION["giohang"]) || empty($_SESSION["giohang"])){
		echo '<h2 align="center">Giỏ hàng chưa có gì cả :)</h2>';
	} else {
		if (count($_SESSION["giohang"]) == 0){
			echo '<h2 align="center">Giỏ hàng chưa có gì cả :)</h2>';
		} else {
?>

<table class="getInfo">
	<tr><td><label>Họ tên người nhận:</label></td><td><input type="text" id="ten" placeholder="Nguyễn Hoàng Đức" /></td></tr>
	<tr><td><label>Giới tính:</label></td><td>
		<input type="radio" name="gt" id="nam" value="nam" /><label for="nam">Nam</label><br/>
		<input type="radio" name="gt" id="nu" value="nu" checked /><label for="nu">Nữ</label>
	</td></tr>
	<tr><td><label>Số điện thoại:</label></td><td><input type="text" id="sdt" placeholder="0903002001" /></td></tr>
	<tr><td><label>Email:</label></td><td><input type="text" id="email" placeholder="ducnh@gmail.com" /></td></tr>
	<tr><td><label>Giao/Nhận bánh:</label></td><td>
		<input type="radio" name="giaonhan" value="true" id="giao" /><label for="giao">Giao tận nơi</label><br/>
		<input type="radio" name="giaonhan" value="false" id="kogiao" checked /><label for="kogiao">Nhận tại cửa hàng</label>
	</td></tr>
	<tr><td><label>Hình thức thanh toán:</label></td><td>
		<input type="radio" name="httt" value="1" id="tt" /><label for="tt">Thanh toán trực tiếp khi nhận bánh</label><br/>
		<input type="radio" name="httt" value="2" id="nh" checked /><label for="nh">Thanh toán trước bằng tài khoản ngân hàng</label><br/>
		<input type="radio" name="httt" value="3" id="bt" /><label for="bt">Thanh toán bằng thẻ ngân hàng khi nhận bánh</label>
	</td></tr>
	<tr name="notice" class="hide">
		<td colspan="2">
			<div>
				<span  class="glyphicon glyphicon-exclamation-sign"></span>
      			<span>message here :)</span>
			</div>
		</td>
	</tr>
	<tr><td colspan="2"><input type="button" value="Tiếp tục" /></td></tr>
</table>

<script type="text/javascript">
	$("table.getInfo input[type='button']").on('click', function(){
		var ten = $("#ten").val();
		var gt = $("input[name='gt']:checked").val();
		var sdt = $("#sdt").val();
		var email = $("#email").val();
		var giaohang = $("input[name='giaonhan']:checked").val();
		var httt = $("input[name='httt']:checked").val();

		var message = "";
		if (!email) message = "Chưa nhập email!";
		if (!sdt) message = "Chưa nhập số điện thoại!";
		if (!ten) message = "Chưa nhập tên người nhận!";
		if (message){
			$("tr[name='notice'] span:last").html(message);
			$("tr[name='notice']").removeClass("hide");
		} else {
			$("tr[name='notice']").addClass("hide");
			var xml = new XMLHttpRequest();
			xml.onreadystatechange = function(){
				if (xml.readyState == 4 && xml.status == 200){
					wall.upWithPane(xml.responseText);
				}
			};
			if (giaohang == 'true'){
				xml.open('GET', 'subPage/addressChoosing.php?ten='+ten+'&gt='+gt+'&sdt='+sdt+'&email='+email+'&giaohang='+giaohang+'&httt='+httt, true);	
			} else {
				xml.open('GET', 'subPage/orderDone.php?ten='+ten+'&gt='+gt+'&sdt='+sdt+'&email='+email+'&giaohang='+giaohang+'&httt='+httt+'&diachi=DefaultLocation', true);
			}
			xml.send();
		}
	});
</script>

<?php
		}// end else of IF (count == 0)
	}// end else of IF (!isset || empty)
?>
