$(document).ready(function(){
	$("#changepass").change(function(){
		if($(this).prop("checked")){
			$(".six, .seven, .eight").addClass('change');
		}
		else {
			$(".six, .seven, .eight").removeClass('change');
		}
	});
});

$("form#updateI").on('submit', function(e){
	e.preventDefault();
	var message = "";
	var gt = $("input[type='radio'][name='gt']:checked").val();
	var name = $("#name").val();
	var bdate = $("#date").val();
	var email = $("#email").val();
	var chpass = $("#changepass").prop('checked');
	var oldpass = $("#pass").val();
	var newpass = $("#nepass").val();
	var repass = $("#repass").val();
	if (chpass){
		if (repass != newpass) message = "Hai mật khẩu mới không khớp!";
		if (!repass) message = "Chưa nhập lại mật khẩu mới!";
		if (!newpass) message = "Chưa nhập mật khẩu mới!";
		if (!oldpass) message = "Chưa nhập mật khẩu cũ!"
	}
	if (!email) message = "Chưa nhập email!";
	if (!bdate) message = "Chưa nhập ngày sinh!";
	if (!name) message = "Chưa nhập họ tên!";
	if (message){
		$("div[name='updateI-error'] span:last").html(message);
		$("div[name='updateI-error']").removeClass("hide");
	} else {
		$("div[name='updateI-error']").addClass("hide");
		var params = "gt=" +gt+ "&name=" +name+ "&bdate=" +bdate+ "&email=" +email+ "&chpass=" +chpass+ "&oldpass=" +oldpass+ "&newpass=" +newpass+ "&repass=" +repass;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", 'subPage/updatekh.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function(){
			if (xhr.readyState == 4){
				if (xhr.status == 200){
					switch (xhr.responseText){
						case 'Success':
							message = "<span class='glyphicon glyphicon-ok-sign' style='color: green; text-shadow: 0 03 3px white;'></span><span style='color: green;'>Cập nhật thành công.</span>";
							$("div[name='updateI-error']").html(message);
							$("div[name='updateI-error']").removeClass("hide");
							message = "";
							setTimeout(function(){
								$(".six, .seven, .eight").removeClass('change');
								$("#changepass").prop('checked', false);
								$("#repass").val(null);
								$("#repass").val(null);
								$("#repass").val(null);
								$("div[name='updateI-error']").addClass("hide");
								$("div[name='updateI-error']").html('<span class="glyphicon glyphicon-exclamation-sign"></span><span>message here :)</span>');
							}, 1500);
							break;
						case 'RePass-Wrong':
							message = "Hai mật khẩu mới không khớp!";
							break;
						case 'OldPass-Wrong':
							message =  "Mật khẩu cũ không đúng!";
							break;
						case 'Lack-Info':
							message = "Lỗi đường truyền! Vui lòng thử lại sau.";
							break;
						default:
							message = "Xảy ra lỗi! Vui lòng thử lại sau.";
							console.log(xhr.responseText);
							break;
					}
					if (message){
						$("div[name='updateI-error'] span:last").html(message);
						$("div[name='updateI-error']").removeClass("hide");
					}
				}
			}
		};
		xhr.send(params);
	}
});
