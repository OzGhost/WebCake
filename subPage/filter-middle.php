<?php
	$valid = true;
	if (!$_GET["kind"]) $valid = false;
	if (!$_GET["val"]) $valid = false;
	if ($valid){
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$pass = "ngaymai";
		$db = "u952681548_cake";
		$conn = new mysqli($server, $host, $pass, $db)
			or die ("Can not connect to server! ".$conn->error);

		$sort = "";
		switch($_GET["val"]){
			case "sale": $sort = "GIAMGIA"; break;
			case "hot": $sort = "SOLANBAN"; break;
			case "new": $sort = "NGAYRAMAT"; break;
		}
		$sql_command = "select MABANH, TENHINHANH from BANH where LOAI='".$_GET["kind"]."' order by ".$sort." DESC limit 3;";
		$rs = $conn->query($sql_command);
		$row = $rs->fetch_assoc();
		$counter = 0;
		while($row){
			if ($counter == 0){
				echo '<div pane-id="'.$counter.'" class="pane-item active">
						<img mb="'.$row["MABANH"].'" src="img/cake-lg/'.$row["TENHINHANH"].'" />
					</div>';
			} else {
				echo '<div pane-id="'.$counter.'" class="pane-item">
						<img mb="'.$row["MABANH"].'" src="img/cake-lg/'.$row["TENHINHANH"].'" />
					</div>';
			}
			$counter++;
			$row = $rs->fetch_assoc();
		}// end WHILE ($row)
	} else {
		echo "lack-info";
	}
?>

<script type="text/javascript">
	// cake info
	$(".intro-p01 img").on('click', function(){
		var mb = $(this).attr("mb");
		if (mb){
			wall.forShowCake(mb);
		}
	});
</script>