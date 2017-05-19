
function showVideo(str) {
    if (str.length == 0) { 
        wall.upWithPane("No video!");
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	wall.forVideo(xmlhttp.responseText);
            }
        };
        xmlhttp.open("GET", "subPage/tr3-huongdan.php?video=" + str, true);
        xmlhttp.send();
    }
}

$(document).ready(function(){
	$(".slidee.p03 table a").click(function(e){
        e.preventDefault();
		var videoname = $(this).text();
        showVideo(videoname);
	});
	
});


