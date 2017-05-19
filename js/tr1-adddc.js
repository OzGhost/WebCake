$(document).ready(function(){
	$("#update").click(function(e){
		e.preventDefault();
		var name = $("#name").val();
		var phone = $("#number").val();
		var city = $("#city").val();
		var district = $("#district").val();
		var commune = $("#commune").val();
		var address = $("#address").val();
		var message = "";
		if (!address) message = "Chưa nhập địa chỉ!";
		if (!commune) message = "Chưa nhập phường/xã!";
		if (!district) message = "Chưa nhập quận/huyện!";
		if (!city) message = "Chưa nhập tỉnh/thành phố!";
		if (!phone) message = "Chưa nhập số điện thoại!";
		if (!name) message = "Chưa nhập họ tên!";
		if (message){
			$("div[name='addadd-error'] span:last").html(message);
			$("div[name='addadd-error']").removeClass("hide");
		} else {
			$("div[name='addadd-error']").addClass("hide");
			var params = "name="+name+"&number="+phone+"&city="+city+"&district="+district+"&commune="+commune+"&address="+address;
			var xhr = new XMLHttpRequest();
			xhr.open("POST", 'subPage/addsdc.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onload = function(e){
				if (xhr.readyState == 4){
					if (xhr.status == 200){
						switch(xhr.responseText){
							case 'Success':
								message = "<span class='glyphicon glyphicon-ok-sign' style='color: green; text-shadow: 0 03 3px white;'></span><span style='color: green;'>Cập nhật thành công.</span>";
								$("div[name='addadd-error']").html(message);
								$("div[name='addadd-error']").removeClass("hide");
								message = "";
								setTimeout(function(){
									$("#name").val(null);
									$("#number").val(null);
									$("#city").val(null);
									$("#district").val(null);
									$("#commune").val(null);
									$("#address").val(null);
									$("div[name='addadd-error']").addClass("hide");
									$("div[name='addadd-error']").html('<span class="glyphicon glyphicon-exclamation-sign"></span><span>message here :)</span>');
								}, 1500);
								break;
							case 'Lack-Info':
								message = "Lỗi truyền thông! Vui lòng thử lại sau.";
								break;
							default:
								message = "Xảy ra lỗi! Vui lòng thử lại sau.";
								console.log(xhr.responseText);
								break;
						}
						if (message){
							$("div[name='addadd-error'] span:last").html(message);
							$("div[name='addadd-error']").removeClass("hide");
						}
						
					}
				}
			};
			xhr.send(params);
		}// end else of IF (message)
	});
});