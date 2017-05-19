// object pController
var pController = {
	init : function(){
		var active  = slidee.activeSlidee();
		$(".pControl li[pIndex='"+active+"']").addClass("curr");

		$(".pControl li").on("click", function(){
			var clicked = Number( $(this).attr("pIndex") );
			slidee.directTo(clicked);
		});
	},
	directTo : function(index){
		$(".pControl li").removeClass("curr");	
		$(".pControl li[pIndex='"+index+"']").addClass("curr");
	}
}

// object slidee
var slidee = {
	movable : true,
	min : Number($(".slidee:first").attr("slide-num")),
	max : Number($(".slidee:last").attr("slide-num")),
	init : function(){
		$(window).bind('mousewheel DOMMouseScroll', function(event){
		    if (event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) {
		        slidee.down();
		    }
		    else {
		        slidee.up();
		    }
		});
		$(window).keydown(function(event){
				switch(event.which){
				case 33:
				case 38:
					slidee.down();
					break;
				case 32:
				case 34:
				case 40:
					slidee.up();
					break;
			}
		});
	},
	activeSlidee : function(){
		return Number($(".slidee.active").attr("slide-num"));
	},
	up : function(){
		if (!slidee.movable){
			return;
		} else {
			var active = slidee.activeSlidee();
			var next = Number(active) + 1;
			if (next <= slidee.max){
				slidee.movable = false;
				$(".slidee[slide-num='"+next+"']").addClass("bottom");
				$(".slidee[slide-num='"+active+"'], .slidee[slide-num='"+next+"']").addClass("moveUp");
				pController.directTo(next);
				setTimeout(function(){
					$(".slidee[slide-num='"+active+"'], .slidee[slide-num='"+next+"']").removeClass("moveUp");
					$(".slidee[slide-num='"+active+"']").removeClass("active");
					$(".slidee[slide-num='"+next+"']").addClass("active");
					$(".slidee[slide-num='"+next+"']").removeClass("bottom");
					slidee.movable = true;
				}, 400);
			}
		}
	},
	down : function(){
		if (!slidee.movable){
			return;
		} else {
			var active = slidee.activeSlidee();
			var prev = Number(active) - 1;
			if (prev > slidee.min){
				slidee.movable = false;
				$(".slidee[slide-num='"+prev+"']").addClass("top");
				$(".slidee[slide-num='"+active+"'], .slidee[slide-num='"+prev+"']").addClass("moveDown");
				pController.directTo(prev);
				setTimeout(function(){
					$(".slidee[slide-num='"+active+"'], .slidee[slide-num='"+prev+"']").removeClass("moveDown");
					$(".slidee[slide-num='"+active+"']").removeClass("active");
					$(".slidee[slide-num='"+prev+"']").addClass("active");
					$(".slidee[slide-num='"+prev+"']").removeClass("top");
					slidee.movable = true;
				}, 400);
			}
		}
	},
	directTo : function(index){
		if (!slidee.movable){
			return;
		} else {
			var active = slidee.activeSlidee();
			var ready = index;
			var direction = "moveDown";
			var position = "top";
			if (active < ready){
				direction = "moveUp";	
				position = "bottom";
			}
			if (ready > slidee.min && ready <= slidee.max && ready != active){
				slidee.movable = false;
				$(".slidee[slide-num='"+ready+"']").addClass(position);
				$(".slidee[slide-num='"+active+"'], .slidee[slide-num='"+ready+"']").addClass(direction);
				pController.directTo(ready);
				setTimeout(function(){
					$(".slidee[slide-num='"+active+"']").removeClass("active");
					$(".slidee[slide-num='"+ready+"']").addClass("active");
					$(".slidee[slide-num='"+ready+"']").removeClass(position);
					$(".slidee[slide-num='"+active+"'], .slidee[slide-num='"+ready+"']").removeClass(direction);
					slidee.movable = true;
				}, 400);
			}
		}
	},
	freeze : function(){
		slidee.movable = false;
	},
	unfreeze : function(){
		slidee.movable = true;
	}
}// end object slidee

// object wall (full-screen-wall)
var wall = {
	init : function(){
		$(".full-screen-wall a[href='#close-wall']").on('click', function(e){
			e.preventDefault();
			wall.close();
		});
	},
	up : function(content){
		$(".full-screen-wall").children("*").not("a:first").remove();
		$(".full-screen-wall").append(content);
		$(".full-screen-wall").addClass("active");
		slidee.freeze();
	},
	upWithPane : function(content){
		$(".full-screen-wall").children("*").not("a:first").remove();
		$(".full-screen-wall").append("<div class='std-pane'>"+content+"</div>");
		$(".full-screen-wall").addClass("active");
		slidee.freeze();	
	},
	forSign : function(content){
		wall.up(content);
	},
	forShowCake : function(mb){
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'subPage/tr1-hienthi.php?mb='+mb, true);
		xhr.onreadystatechange = function(){
			if (xhr.readyState == 4){
				if (xhr.status == 200){
					wall.upWithPane(xhr.responseText);
				}
			}
		};
		xhr.send(null);
	},
	forSearch : function(tb){
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'subPage/search.php?ten='+tb, true);
		xhr.onreadystatechange = function(){
			if (xhr.readyState == 4){
				if (xhr.status == 200){
					wall.up(xhr.responseText);
				}
			}
		};
		xhr.send(null);
	},
	forVideo : function(content){
		$(".full-screen-wall").children("*").not("a:first").remove();
		$(".full-screen-wall").append("<div class='vid-pane'>"+content+"</div>");
		$(".full-screen-wall").addClass("active");
		slidee.freeze();	
	},
	close : function(){
		$(".full-screen-wall").removeClass("active");
		$(".full-screen-wall").children("*").not("a:first").remove();
		slidee.unfreeze();
	}
}// end object wall


// get cake info by cake id use AJAX
function getCakeInfo(mabanh){
	if (mabanh.length == 0){
		$(".dialog").append("Nothing to show you!");
		return;
	} else {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
				$(".dialog").children("*").not("span.close-dialog").remove();
				$(".dialog").append(xmlhttp.responseText);
			}
		};
		xmlhttp.open("GET", "subPage/tr1-hienthi.php?mb="+mabanh, true);
		xmlhttp.send();
	}
}

// logout dialog 
function logout(){
	window.location.href = "subPage/logout.php";
}


// check leap year
function leapYear(year){
	if ( (year%400) == 0 ){
		return true;
	}
	if ( ((year%4) == 0) && ((year%100) != 0) ){
		return true;
	}
	return false;
}

// handling input of contact form
$(document).on("input propertychange", ".form-class", function(){
	if ($(this).children("input, textarea").val() == ""){
		$(this).children("label").removeClass("toggleLabel");
	} else {
		$(this).children("label").addClass("toggleLabel");
	}
});


// disable/enable select cake, drink
$("table.table-ord input[type='checkbox']").on("change", function(){
	if($(this).prop("checked") == true) {
		$("table.table-ord select.cakename, table.table-ord select.drink").prop("disabled", false);
	} else {
		$("table.table-ord select.cakename, table.table-ord select.drink").prop("disabled", true);
	}
});

// handling on ready
$(document).ready(function(){

	// lock scroll slidee at logon/register
	$("a[href='#login']").click(function(e){
		e.preventDefault();
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'subPage/sign.php', true);
		xhr.onreadystatechange = function(){
			if (xhr.readyState == 4){
				if (xhr.status == 200){
					wall.forSign(xhr.responseText);
				}
			}
		};
		xhr.send(null);
	});

	// toggle filter for bottom slidebar
	$(".anov-list").hover(function(){
		$(".anov-list .upsot").addClass("upshow");
	}, function(){
		$(".anov-list .upsot.upshow").removeClass("upshow");
	});

	// toggle filter for middle slide
	$(".cake-slide").hover(function(){
		$(".cake-slide-frame .leftsot").addClass("leftshow");
	}, function(){
		$(".cake-slide-frame .leftsot.leftshow").removeClass("leftshow");
	});
	$(".cake-slide-frame").hover(function(){
		$(".cake-slide-frame .leftsot").addClass("leftshow");
	}, function(){
		$(".cake-slide-frame .leftsot.leftshow").removeClass("leftshow");
	});

	// pull bottom slidebar on manual
	$(".next-btn").click(function(){
		if ( $(this).hasClass("clickable") ){
			$(this).removeClass("clickable");
			pushL();
			runable = false;
			setTimeout(function(){
				if ( $(this).hasClass("clickable") ){
					runable = true;
				}
			}, 1500);
		}
	});
	$(".prev-btn").click(function(){
		if ( $(this).hasClass("clickable") ){
			$(this).removeClass("clickable");
			pushR();
			runable = false;
			setTimeout(function(){
				if ( $(this).hasClass("clickable") ){
					runable = true;
				}
			}, 1500);
		}
	});

	// changing color label of form
	$(".form-class").focusin(function(){
		$(this).children("label").css("color", "#3c9");
	});
	$(".form-class").focusout(function(){
		$(this).children("label").css("color", "gray");
	});

	// closing message
	$(".close-message").click(function(){
		$("body > .message").remove();
	});

	// stopping bottom slidebar on hover
	$(".myitem").hover(function(){
		runable = false;
	}, function(){
		if (!onToggle)
			runable = true;
	});

	// showing myModal for cake infomation
	$(".item, .myitem").click(function(){
		slidee.movable = false;
		runable = false;
		onToggle = true;
		getCakeInfo($(this).children("img").attr("mabanh"));
		$(".myModal").addClass("active");
	});

	// hiding myModal by close button
	$(".myModal span.close-dialog").click(function(){
		$(".myModal").removeClass("active");
		$(".myModal .dialog").children("*").not($(this)).remove();
		onToggle = false;
		runable = true;
		slidee.movable = true;
	});

	// hiding slidee toggle by close button
	$(".slidee.toggle").children("span.close-toggle-slidee").click(function(){
		slidee.movable = true;
		runable = true;
		onToggle = false;
		$(".slidee.toggle").addClass("deactive");
	});

	// hiding slidee message-dialog
	$(".message-dialog a.close-message-dialog[href='#']").click(function(e){
		e.preventDefault();
		$(".message-wall").addClass("deactive");
		slidee.movable = true;
		onToggle = false;
	});

	// pin page 3
	$("#pinpoint").change(function(){
		var val = $(this).prop('checked');
		if (val == true){
			$("label[for='pinpoint'] span").removeClass("fa-hand-paper-o");
			$("label[for='pinpoint'] span").addClass("fa-hand-rock-o");
			slidee.movable = false;
		} else {
			$("label[for='pinpoint'] span").removeClass("fa-hand-rock-o");
			$("label[for='pinpoint'] span").addClass("fa-hand-paper-o");
			slidee.movable = true;
		}
	});

	// open Bag 
	$("a[href='#giohang']").click(function(e){
		e.preventDefault();
		slidee.movable = false;
		var xml = new XMLHttpRequest();
		xml.onreadystatechange = function(){
			if (xml.readyState == 4 && xml.status == 200){
				wall.upWithPane(xml.responseText);
			}
		};
		xml.open("GET", "subPage/giohang.php", true);
		xml.send();
	});

	// user infomation on slidee toggle
	$("div.accgroup li:first").find("a").click(function(e){
		e.preventDefault();
		var rp = $(this).attr("href") + ".php";
		if (rp == "dangxuat.php"){
			logout();
		} else if (rp != "#giohang.php") {
			var xml = new XMLHttpRequest();
			xml.onreadystatechange = function(){
				if (xml.readyState == 4 && xml.status == 200){
					$(".slidee.toggle").children("*").not("span.close-toggle-slidee, hr.footering").remove();
					$(".slidee.toggle").append(xml.responseText);
					$(".slidee.toggle").removeClass("deactive");
					slidee.movable = false;
					runable = false;
					onToggle = true;
				}
			};
			xml.open('GET', rp, true);
			xml.send();
		}
		$(".accgroup ul li:first").children("ul").removeClass("active");
	});

	// logout button top right corner
	$(".mynav a[href='dangxuat']").click(function(e){
		e.preventDefault();
		logout();
	});

	// toggle account infomation panel when hover in/out
	$(".accgroup ul li:first").hover(function(){
		$(this).children("ul").addClass("active");
	}, function(){
		$(this).children("ul").removeClass("active");
	});

	// prevent scroll on date time choosing
	$("td.d-m select, .table-ord input[type='time']").mouseenter(function(){
		slidee.movable = false;
	});
	$("td.d-m select, .table-ord input[type='time']").mouseleave(function(){
		slidee.movable = true;
	});

	// validating date time
	$("td.d-m select.thang").change(function(){
		switch ( Number($(this).val()) ){
			case 2:
				$("td.d-m select.ngay").children("option[value='31'], option[value='30']").prop('disabled', true);
				var year = new Date().getFullYear();
				if (leapYear(year)){
					$("td.d-m select.ngay").children("option[value='29']").prop('disabled', false);
				} else {
					$("td.d-m select.ngay").children("option[value='29']").prop('disabled', true);
				}
				break;
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				$("td.d-m select.ngay").children("option[value='31'], option[value='30'], option[value='29']").prop('disabled', false);
				break;
			case 4:
			case 6:
			case 9:
			case 11:
				$("td.d-m select.ngay").children("option[value='30'], option[value='29']").prop('disabled', false);
				$("td.d-m select.ngay").children("option[value='31']").prop('disabled', true);
				break;
		}
	});

	// sending table order infor
	$("table.table-ord input[type='submit']").click(function(e){
		e.preventDefault();
		var gio = $("table.table-ord select[name='time']").val();
		var message = "";
		if (!gio){
			message = "Chưa chọn giờ!";
		}
		if (message){
			$("table.table-ord tr.notices").children("td").html(message);
			$("table.table-ord tr.notices").addClass("up");
		} else {
			var thang = $("table.table-ord select.thang").val();
			var ngay = $("table.table-ord select.ngay").val();
			var ngaydat = new Date().getFullYear() + "-" + thang + "-" + ngay ;
			var vitri = $("table.table-ord select.place").val();
			var datbanh = $("#cake-ord").prop('checked');
			var banh = "NULL";
			var nuoc = "NULL";
			if (datbanh){
				banh = $("table.table-ord select.cakename").val();
				nuoc = $("table.table-ord select.drink").val();
			}
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4){
					if (xhr.status == 200){
						$("table.table-ord tr.notices").children("td").html(xhr.responseText);
						$("table.table-ord tr.notices").addClass("up");
						setTimeout(function(){
							$("table.table-ord tr.notices").removeClass("up");
							$("#cake-ord").prop('checked', false);
							$("table.table-ord select.cakename, table.table-ord select.drink").prop("disabled", true);
							$("table.table-ord input[type='time']").val(null);
						}, 2000);
					}
				}
			};
			xhr.open('GET', 'subPage/orderTable.php?thoigian='+gio+'&ngaydat='+ngaydat+'&bandat='+vitri+'&banh='+banh+'&nuoc='+nuoc, true);
			xhr.send(null);
		}
	});

}); // end handling on ready

// close all Modal/Toggle with Esc key
$(document).keydown(function(e){
	if(e.keyCode == 27){
		wall.close();
	}
});

var pane = {
	left_movable : true,
	right_movable : true,
	middle_movable : true,
	init : function(){
		$(".left-pane a.next-btn.clickable").on('click', function(e){
			e.preventDefault();
			var s = ".left-pane";
			pane.moveNext(s);
		});
		$(".left-pane a.prev-btn.clickable").on('click', function(e){
			e.preventDefault();
			var s = ".left-pane";
			pane.movePrev(s);
		});

		$(".right-pane a.next-btn.clickable").on('click', function(e){
			e.preventDefault();
			var s = ".right-pane";
			pane.moveNext(s);
		});
		$(".right-pane a.prev-btn.clickable").on('click', function(e){
			e.preventDefault();
			var s = ".right-pane";
			pane.movePrev(s);
		});

		$(".middle-pane a.next-btn.clickable").on('click', function(e){
			e.preventDefault();
			var s = ".middle-pane";
			pane.moveNext(s);
		});
		$(".middle-pane a.prev-btn.clickable").on('click', function(e){
			e.preventDefault();
			var s = ".middle-pane";
			pane.movePrev(s);
		});
		pane.autorun();
	},
	activePane : function(s){
		return Number($(s + " .pane-item.active").attr("pane-id"));
	},
	nextPane : function(s){
		var res = Number($(s + " .pane-item.active").attr("pane-id"));
		var min = Number($(s + " .pane-item:first").attr("pane-id"));
		var max = Number($(s + " .pane-item:last").attr("pane-id"));
		res++;
		if (res > max) res = min;
		return res;
	},
	prevPane : function(s){
		var res = Number($(s + " .pane-item.active").attr("pane-id"));
		var min = Number($(s + " .pane-item:first").attr("pane-id"));
		var max = Number($(s + " .pane-item:last").attr("pane-id"));
		res--;
		if (res < min) res = max;
		return res;
	},
	moveNext : function(s){
		var movable;
		switch(s){
			case ".left-pane": movable = pane.left_movable; break;
			case ".right-pane": movable = pane.right_movable; break;
			case ".middle-pane": movable = pane.middle_movable; break;
		}
		if (!movable) {
			return;
		} else {
			switch(s){
				case ".left-pane": pane.left_movable = false; break;
				case ".right-pane": pane.right_movable = false; break;
				case ".middle-pane": pane.middle_movable = false; break;
			}
			$(s+" a.next-btn.clickable, "+s+" a.prev-btn.clickable").removeClass("clickable");
			var active = pane.activePane(s);
			var next = pane.nextPane(s);
	
			$(s + " .pane-item[pane-id='"+next+"']").addClass("right");
			$(s + " .pane-item[pane-id='"+next+"'], "+s+" .pane-item[pane-id='"+active+"']").addClass("moveL");
			setTimeout(function(){
				$(s+" .pane-item[pane-id='"+active+"']").removeClass("active");
				$(s+" .pane-item[pane-id='"+next+"']").addClass("active");
				$(s+" .pane-item[pane-id='"+next+"']").removeClass("right");
				$(s+" .pane-item[pane-id='"+active+"'], "+s+" .pane-item[pane-id='"+next+"']").removeClass("moveL");
				$(s+" a.next-btn, "+s+" a.prev-btn").addClass("clickable");
				switch(s){
					case ".left-pane": pane.left_movable = true; break;
					case ".right-pane": pane.right_movable = true; break;
					case ".middle-pane": pane.middle_movable = true; break;
				}
			}, 1000);
		}// end of IF(!movable)
	},
	movePrev : function(s){
		var movable;
		switch(s){
			case ".left-pane": movable = pane.left_movable; break;
			case ".right-pane": movable = pane.right_movable; break;
			case ".middle-pane": movable = pane.middle_movable; break;
		}
		if (!movable) {
			return;
		} else {
			switch(s){
				case ".left-pane": pane.left_movable = false; break;
				case ".right-pane": pane.right_movable = false; break;
				case ".middle-pane": pane.middle_movable = false; break;
			}
			$(s+" a.next-btn.clickable, "+s+" a.prev-btn.clickable").removeClass("clickable");
			var active = pane.activePane(s);
			var prev = pane.prevPane(s);

			$(s + " .pane-item[pane-id='"+prev+"']").addClass("left");
			$(s + " .pane-item[pane-id='"+prev+"'], "+s+" .pane-item[pane-id='"+active+"']").addClass("moveR");
			setTimeout(function(){
				$(s+" .pane-item[pane-id='"+active+"']").removeClass("active");
				$(s+" .pane-item[pane-id='"+prev+"']").addClass("active");
				$(s+" .pane-item[pane-id='"+prev+"']").removeClass("left");
				$(s+" .pane-item[pane-id='"+active+"'], "+s+" .pane-item[pane-id='"+prev+"']").removeClass("moveR");
				$(s+" a.next-btn, "+s+" a.prev-btn").addClass("clickable");
				switch(s){
					case ".left-pane": pane.left_movable = true; break;
					case ".right-pane": pane.right_movable = true; break;
					case ".middle-pane": pane.middle_movable = true; break;
				}				
			}, 1000);
		}// end else of IF(!movable)
	},
	append : function(s, content){
		$(s).children("*").not("a").remove();
		$(s).append(content);
	},
	autorun : function(){
		setTimeout(function(){
			pane.movePrev(".left-pane");
			pane.moveNext(".right-pane");
			pane.moveNext(".middle-pane");
			pane.autorun();
		}, 5000);
	},
	freeze : function(){
		pane.left_movable = false;
		pane.right_movable = false;
		pane.middle_movable = false;
	},
	unfreeze : function(){
		pane.left_movable = true;
		pane.right_movable = true;
		pane.middle_movable = true;
	},
	freezeOnly : function(s){
		switch(s){
			case "left": pane.left_movable = false; break;
			case "right": pane.right_movable = false; break;
			case "middle": pane.middle_movable = false; break;
		}
	},
	unfreezeOnly : function(s){
		switch(s){
			case "left": pane.left_movable = true; break;
			case "right": pane.right_movable = true; break;
			case "middle": pane.middle_movable = true; break;
		}
	}
}// end object Pane


var small_cake_pane = {
	movable : true,
	min : Number($(".small-cake-pane .small-cake-item:first").attr("scp-id")),
	max : Number($(".small-cake-pane .small-cake-item:last").attr("scp-id")),
	init : function(){
		$(".small-cake-pane a.prev-btn.clickable").on('click', function(e){
			e.preventDefault();
			small_cake_pane.moveR();
		});
		$(".small-cake-pane a.next-btn.clickable").on('click', function(e){
			e.preventDefault();
			small_cake_pane.moveL();
		});
		small_cake_pane.autorun();
	},
	nextPane : function(){
		var next = Number($(".small-cake-item.active:last").attr("scp-id"));
		next++;
		if (next > small_cake_pane.max) next = small_cake_pane.min;
		return next;
	},
	prevPane : function(){
		var prev = Number($(".small-cake-item.active:first").attr("scp-id"));
		prev--;
		if (prev < small_cake_pane.min) prev = small_cake_pane.max;
		return prev;
	},
	moveL : function(){
		if (!small_cake_pane.movable){
			return;
		} else {
			small_cake_pane.movable = false;
			$(".small-cake-pane a.prev-btn, .small-cake-pane a.next-btn").removeClass("clickable");
			var next = small_cake_pane.nextPane();
			$(".small-cake-item[scp-id='"+next+"']").addClass("right");
			$(".small-cake-item[scp-id='"+next+"'], .small-cake-item.active").addClass("moveL");
			setTimeout(function(){
				$(".small-cake-item[scp-id='"+next+"'], .small-cake-item.active").removeClass("moveL");
				$(".small-cake-item.active:first").removeClass("active");
				$(".small-cake-item[scp-id='"+next+"']").addClass("active");
				$(".small-cake-item[scp-id='"+next+"']").removeClass("right");
				$(".small-cake-item:first").appendTo(".small-cake-pane");
				$(".small-cake-pane a.prev-btn, .small-cake-pane a.next-btn").addClass("clickable");
				small_cake_pane.movable = true;
			}, 400);
		}
	},
	moveR : function(){
		if (!small_cake_pane.movable) {
			return;
		} else {
			small_cake_pane.movable = false;
			$(".small-cake-pane a.prev-btn, .small-cake-pane a.next-btn").removeClass("clickable");
			var prev = small_cake_pane.prevPane();
			$(".small-cake-item[scp-id='"+prev+"']").addClass("left");
			$(".small-cake-item[scp-id='"+prev+"'], .small-cake-item.active").addClass("moveR");
			setTimeout(function(){
				$(".small-cake-item[scp-id='"+prev+"'], .small-cake-item.active").removeClass("moveR");
				$(".small-cake-item.active:last").removeClass("active");
				$(".small-cake-item[scp-id='"+prev+"']").addClass("active");
				$(".small-cake-item[scp-id='"+prev+"']").removeClass("left");
				$(".small-cake-item:last").prependTo(".small-cake-pane");
				$(".small-cake-pane a.prev-btn, .small-cake-pane a.next-btn").addClass("clickable");
				small_cake_pane.movable = true;
			}, 400);
		}
	},
	append : function(content){
		$(".small-cake-pane").children("*").not("a").remove();
		$(".small-cake-pane").append(content);
	},
	autorun : function(){
		setTimeout(function(){
			small_cake_pane.moveL();
			small_cake_pane.autorun();
		}, 5000);
	},
	freeze : function(){
		small_cake_pane.movable = false;
	},
	unfreeze : function(){
		small_cake_pane.movable = true;
	}
}// end object small_cake_pane

pController.init();
slidee.init();
pane.init();
small_cake_pane.init();
wall.init();


// handling of filter
$(".intro-p01 .filter input[type='radio']").not("input[name='special']").on('change', function(){
	small_cake_pane.freeze();
	var kind = $(".intro-p01 .filter input[name='kind']:checked").val();
	var cost = $(".intro-p01 .filter input[name='cost']:checked").val();
	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'subPage/filter-bottom.php?kind='+kind+'&cost='+cost, true);
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4){
			if (xhr.status == 200){
				small_cake_pane.append(xhr.responseText);
				small_cake_pane.unfreeze();
			}
		}
	};
	xhr.send(null);
});

$(".intro-p01 .filter input[name='special']").on('change', function(){
	pane.freezeOnly("left");
	pane.freezeOnly("right");
	var val = $(this).prop("checked", "true").val();
	var xhr1 = new XMLHttpRequest();
	var xhr2 = new XMLHttpRequest();
	xhr1.open('GET', 'subPage/filter-middle.php?kind=KEM&val='+val, true);
	xhr1.onreadystatechange = function(){
		if (xhr1.readyState == 4){
			if (xhr1.status == 200){
				pane.append(".left-pane", xhr1.responseText);
				pane.unfreezeOnly("left");
			}
		}
	};
	xhr1.send(null);
	xhr2.open('GET', 'subPage/filter-middle.php?kind=NGOT&val='+val, true);
	xhr2.onreadystatechange = function(){
		if (xhr2.readyState == 4){
			if (xhr2.status == 200){
				pane.append(".right-pane", xhr2.responseText);
				pane.unfreezeOnly("right");
			}
		}
	};
	xhr2.send(null);
});
// end fiter handing

// searching
$("form[action='search.php']").on('submit', function(e){
	e.preventDefault();
	var tb = $(this).children("input").val();
	wall.forSearch(tb);
});
// end searching

// cake info
$(".intro-p01 img").on('click', function(){
	var mb = $(this).attr("mb");
	if (mb){
		wall.forShowCake(mb);
	}
});
