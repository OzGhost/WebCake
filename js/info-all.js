$(".bor1 .list ul li").children("a").on('click', function(e){
	e.preventDefault();
	var rp = $(this).attr("href") + ".php";
	if (rp == "dangxuat.php"){
		logout();
	} else {
		var xml = new XMLHttpRequest();
		xml.open("GET", rp, true);
		xml.onload = function(e){
			if (xml.readyState == 4){
				if (xml.status == 200){
					$(".slidee.toggle").children("*").not("span.close-toggle-slidee, hr.footering").remove();
					$(".slidee.toggle").append(xml.responseText);
					$(".slidee.toggle").removeClass("deactive");
					scrollable = false;
					runable = false;
					onToggle = true;
				}
			}
		};
		xml.send(null);
	}
});