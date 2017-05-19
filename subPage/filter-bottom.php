<?php
	$valid = true;
	if (!$_GET["kind"]) $valid = false;
	if (!$_GET["cost"]) $valid = false;
	if ($valid){
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$pass = "ngaymai";
		$db = "u952681548_cake";
		$conn = new mysqli($server, $host, $pass, $db)
			or die ("Can not connect to server! ".$conn->error);
		$sql_command = "";

		if ($_GET["cost"] == 'increase'){
        	$sql_command = "select MABANH, TENHINHANH from BANH where LOAI='".$_GET["kind"]."' order by GIA limit 12;";
		} else {
        	$sql_command = "select MABANH, TENHINHANH from BANH where LOAI='".$_GET["kind"]."' order by GIA DESC limit 12;";
		}
        $rs = $conn->query($sql_command);
        $row = $rs->fetch_assoc();
        $counter = 0;
        while($row){
          if ($counter < 6){
            echo '<div class="small-cake-item flex-item active" scp-id="'.$counter.'">
                    <img mb="'.$row["MABANH"].'" src="img/cake-sm/'.$row["TENHINHANH"].'" />
                  </div>';
          } else {
            echo '<div class="small-cake-item flex-item" scp-id="'.$counter.'">
                    <img mb="'.$row["MABANH"].'" src="img/cake-sm/'.$row["TENHINHANH"].'" />
                  </div>';
          }
          $counter++;
          $row = $rs->fetch_assoc();
        }
	}// end IF ($valid)
?>