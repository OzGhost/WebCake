
// select a row
$("table.dsdb tr").on('click', function(){
	$("table.dsdb tr.selecting").removeClass("selecting");
	$(this).addClass("selecting");
});

$("a[href='#huydatban']").on('click', function(e){
	e.preventDefault();
	var idCode = $("tr.selecting td:first").text();
	var message = "";
	if (!idCode){
		message = "Chưa chọn bàn để hủy!";
		$("span.notice").html(message);
		$("span.notice").removeClass("hide");
	} else {
		$("span.notice").addClass("hide");
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'subPage/rmOrderTable.php?idCode='+idCode, true);
		xhr.onreadystatechange = function(){
			if (xhr.readyState == 4){
				if (xhr.status == 200){
					switch (xhr.responseText){
						case 'Success':
							message = "Hủy đặt bàn thành công.";
							$("span.notice").html(message);
							$("span.notice").removeClass("hide");
							$("tr.selecting").remove();
							setTimeout(function(){
								$("span.notice").addClass("hide");	
							}, 1500);
							break;
						default:
							message = "Xảy ra lỗi! Vui lòng thử lại sau.";
							$("span.notice").html(message);
							$("span.notice").removeClass("hide");
							break;
					}
				}
			}
		};
		xhr.send(null);
	}
});
