// toggling card register
$('.toggle').on('click', function() {
  $('.lgcontainer').stop().addClass('active');
});

// closing card register
$('.close').on('click', function() {
  $('.lgcontainer').stop().removeClass('active');
});


$("#login-button").on('click', function(e){
		e.preventDefault();
		var user = $("#Username").val();
		var pass = $("#Password").val();
		var message = "";
		if (!pass){
			message = "Chưa nhập mật khẩu!";
		}
		if (!user){
			message = "Chưa nhập tài khoản!";
		}
		if (message){
			$(".card div[name='login-error']").removeClass("hide");
			$(".card div[name='login-error'] span:last").html(message);
		} else {
			$(".card div[name='login-error']").addClass("hide");
			var params =  "Username=" + user + "&Password=" + pass;
			var xhr = new XMLHttpRequest();
			xhr.open("POST", 'subPage/relogin.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4){
					if (xhr.status == 200){
						switch(xhr.responseText){
							case "User-Wrong":
								message = "Tài khoản chưa tồn tại!";
								break;
							case "Pass-Wrong":
								message = "Sai mật khẩu!";
								break;
							case "Success": 
								message = "";
								window.location.href = ".";
								break;
							default:
								message = "<pre>Xảy ra lỗi!<br/>Vui lòng thử lại sau.</pre>";
								console.log(xhr.responseText);
								break;
						}
						if (message){
							$(".card div[name='login-error']").removeClass("hide");
							$(".card div[name='login-error'] span:last").html(message);
						}
					}
				}
			};
			xhr.send(params)
		}
	});

	// register re-check
	$("#reg-button").on('click', function(e){
		e.preventDefault();
		var user = $("#User").val();
		var pass = $("#Pass").val();
		var repass = $("#RePass").val();
		var email = $("#Email").val();
		var message = "";
		if (!email) message = "Chưa nhập email!";
		if (!repass) message = "Chưa nhập lại mật khẩu!";
		if (!pass) message = "Chưa nhập mật khẩu!";
		if (!user) message = "Chưa nhập tài khoản!";
		if(!message){
			if (repass != pass) message = "Hai mật khẩu không khớp!";
		}
		if (message){
			$(".card.alt div[name='reg-error']").removeClass("hide");
			$(".card.alt div[name='reg-error'] span:last").html(message);	
		} else {
			$(".card.alt div[name='reg-error']").addClass("hide");
			var params = "user=" + user + "&pass=" + pass + "&repass=" + repass + "&email=" + email;
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'subPage/reg.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4){
					if (xhr.status == 200){
						switch(xhr.responseText){
							case "User-Existed":
								message = "Tài khoản đã tồn tại!";
								break;
							case "RePass-Wrong":
								message = "Hai mật khẩu không khớp!";
								break;
							case "Success": 
								message = "<span class='glyphicon glyphicon-ok-sign' style='color: green; text-shadow: 0 03 3px white;'></span><span style='color: green;'>Đăng ký thành công.</span>";
								$(".card div[name='reg-error']").html(message);
								$(".card div[name='reg-error']").removeClass("hide");
								message = "";
								setTimeout(function(){
									$(".card div[name='reg-error']").addClass("hide");
									$(".card div[name='reg-error']").children("*").remove();
									$(".card div[name='reg-error']").append('<span  class="glyphicon glyphicon-exclamation-sign"></span><span>message here :)</span>');
									$('.lgcontainer').stop().removeClass('active');
								}, 1500);
								break;
							default:
								message = "<pre>Xảy ra lỗi!<br/>Vui lòng thử lại sau.</pre>";
								console.log(xhr.responseText);
								break;
						}
						if (message){
							$(".card div[name='reg-error']").removeClass("hide");
							$(".card div[name='reg-error'] span:last").html(message);
						}
					}
				}
			};
			xhr.send(params);
		}
		
	});