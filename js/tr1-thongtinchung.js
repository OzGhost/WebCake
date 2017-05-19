$(".addadress, .informa>div").children("a").on('click', function(e){
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

$("a[href='https://www.facebook.com/']").on('click', function(e){
	e.preventDefault();
});
