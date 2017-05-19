$(document).ready(function(){
	$("#setdefault").mousedown(function(){
		$(this).addClass("onpress");
	});
	$("#setdefault").mouseup(function(){
		$(this).removeClass("onpress");
	});
	$(".itemDC").click(function(){
		$(".itemDC.choosed").removeClass("choosed");
		$(this).addClass("choosed");
	});
	$("#setdefault").click(function(){
		var idchoosed = $(".itemDC.choosed").attr("id");
		if (!idchoosed){
			$("div[name='addr-notice'] span:last").html('Vui lòng chọn một địa chỉ!');
			$("div[name='addr-notice']").removeClass("hide");
		} else {
			$("div[name='addr-notice']").addClass("hide");
			if ( idchoosed != $(".itemDC.default").attr("id") ) {
				var xhr = new XMLHttpRequest();
				xhr.open("GET", "subPage/setdefaultSDC.php?idCode="+idchoosed, true);
				xhr.onload = function(e){
					if (xhr.readyState == 4){
						if (xhr.status == 200){
							if (xhr.responseText == 'Success'){
								$("div[name='addr-notice']").html("<span class='glyphicon glyphicon-ok-sign' style='color: green; text-shadow: 0 03 3px white;'></span><span style='color: green;'>Đặt địa chỉ mặc định thành công.</span>");
								$("div[name='addr-notice']").removeClass("hide");
								$(".itemDC.default").removeClass("default");
								$(".itemDC.choosed").addClass("default");
								$(".itemDC.choosed.default").removeClass("choosed");
								setTimeout(function(){
									$("div[name='addr-notice']").addClass("hide");
									$("div[name='addr-notice']").html('<span class="glyphicon glyphicon-exclamation-sign"></span><span>message here :)</span>');
								}, 1500);	
							} else {
								$("div[name='addr-notice'] span:last").html('Xảy ra lỗi!');
								$("div[name='addr-notice']").removeClass("hide");
								console.log(xhr.responseText);
							}							
						}
					}
				};
				xhr.send(null);
			} else {
				$(".itemDC.choosed").removeClass("choosed");
			}	
		}
	});
});

$(".adress").children("a[href='tr1-adddc']").on('click', function(e){
	e.preventDefault();
	var rp = "subPage/" + $(this).attr("href") + ".php";
	var xhr = new XMLHttpRequest();
	xhr.open("GET", rp, true);
	xhr.onload = function(e){
		if (xhr.readyState == 4){
			if (xhr.status == 200){
				$(".slidee.toggle").children("*").not("span.close-toggle-slidee, hr.footering").remove();
				$(".slidee.toggle").append(xhr.responseText);
				$(".slidee.toggle").removeClass("deactive");
				scrollable = false;
				runable = false;
				onToggle = true;
			}
		}
	};
	xhr.send(null);
});

$("a[href='removeAd']").on('click', function(e){
	e.preventDefault();
	var idchoosed = $(".itemDC.choosed").attr("id");
	if (!idchoosed){
		$("div[name='addr-notice'] span:last").html('Vui lòng chọn một địa chỉ!');
		$("div[name='addr-notice']").removeClass("hide");
	} else {
		var removeDefault = false;
		if ( idchoosed == $(".itemDC.default").attr("id") ) {
			removeDefault = true;
		}
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "subPage/removeAd.php?idCode="+idchoosed+"&rmDf="+removeDefault, true);
		xhr.onload = function(e){
			if (xhr.readyState == 4){
				if (xhr.status == 200){
					if (xhr.responseText == 'Success'){
						$("div[name='addr-notice']").html("<span class='glyphicon glyphicon-ok-sign' style='color: green; text-shadow: 0 03 3px white;'></span><span style='color: green;'>Xóa địa chỉ thành công.</span>");
						$("div[name='addr-notice']").removeClass("hide");
						$(".itemDC.choosed").remove();
						setTimeout(function(){
							$("div[name='addr-notice']").addClass("hide");
							$("div[name='addr-notice']").html('<span class="glyphicon glyphicon-exclamation-sign"></span><span>message here :)</span>');
						}, 1500);	
					} else {
						$("div[name='addr-notice'] span:last").html('Xảy ra lỗi!');
						$("div[name='addr-notice']").removeClass("hide");
						console.log(xhr.responseText);
					}
				}
			}
		};
		xhr.send(null);
	}
});
