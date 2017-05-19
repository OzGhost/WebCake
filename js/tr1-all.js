$(document).ready(function(){
	$(".list > ul > li").click(function(){
		$(".press").removeClass('press');
		$(this).addClass('press');
	});
});