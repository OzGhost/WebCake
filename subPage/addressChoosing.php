<?php
	session_start();
	// echo "<pre>";
	// var_dump($_GET);
	// echo "</pre>";
  $logon = false;
  if (isset($_SESSION["UserID"]) && !empty($_SESSION["UserID"])){
    $logon = true;
    $user = $_SESSION["UserID"];
  } // end IF (isset && !empty)

?>

<table class="getInfo">
	<tr><td>
    <?php
      if ($logon){
        $server = "mysql.hostinger.vn";
        $host = "u952681548_root";
        $pass = "ngaymai";
        $db = "u952681548_cake";
        $conn = new mysqli($server, $host, $pass, $db)
          Or die ("Can not connect to server! ". $conn->error);
        
        // lay ma so dia chi mac dinh
        $sql_command = "SELECT SDC FROM KHACHHANG WHERE USERNAME='$user';";
        $rs = $conn->query($sql_command);
        $row = $rs->fetch_assoc();
        $sdcDefault = false;
        if ($row){
          if ($row["SDC"] == NULL ){
            $sdcDefault = -1;
          } else {
            $sdcDefault = $row["SDC"];
          }
        }

        // lay danh sach so dia chi
        $sql_command = "SELECT * FROM SODIACHI WHERE USERNAME='$user';";
        $rs = $conn->query($sql_command);
        $row = $rs->fetch_assoc();
        if ($row){
    ?>
      <input type="radio" id="select" name="addr" value="choice" />
      <label for="select">Chọn địa chỉ từ sổ địa chỉ:</label><br/>
      <select id="addr">
    <?php
          while ($row){
            $addren = $row["DIACHI"].", ".$row["XA_PHUONG"].", ".$row["QUAN_HUYEN"].", ".$row["TINH_TP"];
            
            if ($row["MASDC"] == $sdcDefault){
              echo '<option selected>'.$addren.'</option>';
              // echo "<option>$addren</option>";
            }else {
              echo '<option>'.$addren.'</option>';
              // echo "<option>aa</option>";
            }
            $row = $rs->fetch_assoc();
          }// end WHILE ($row)
        } else {// else of IF ($row)
    ?>
      <input type="radio" id="select" name="addr" value="choice" disabled />
      <label for="select">Chọn địa chỉ từ sổ địa chỉ:</label><br/>
      <select id="addr" disabled >
        <option selected disabled>Bạn chưa tạo bất kỳ sổ địa chỉ nào!</option>
    <?php
        }// end IF ($row)
        // closing the connection
        if ($conn) $conn->close();
      } else { // else of IF ($logon)
    ?>
      <input type="radio" id="select" name="addr" value="choice" disabled />
      <label for="select">Chọn địa chỉ từ sổ địa chỉ:</label><br/>
      <select id="addr" disabled >
        <option selected disabled>Bạn cần đăng nhập để sử dụng tùy chọn này</option>
    <?php
        
      }// end else IF ($logon)
    ?>
  </select></td></tr>
  <tr><td>
    <input type="radio" id="ndc" name="addr" value="manual" checked /><label for="ndc">Nhập địa chỉ:</label><br/>
    <textarea class="fullRow" rows="13"></textarea>
  </td></tr>
  <tr name="notice" class="hide"><td>
    <div>
      <span  class="glyphicon glyphicon-exclamation-sign"></span>
      <span>message here :)</span>
    </div>
  </td></tr>
  <tr><td><input id="Done" type="button" value="Hoàn tất !" /></td></tr>
</table>

<script type="text/javascript">
  $("#Done").on('click', function(){
    var ten = "<?php echo $_GET['ten'];?>";
    var gt = "<?php echo $_GET['gt'];?>";
    var sdt = "<?php echo $_GET['sdt'];?>";
    var email = "<?php echo $_GET['email'];?>";
    var giaohang = "<?php echo $_GET['giaohang'];?>";
    var httt = "<?php echo $_GET['httt'];?>";
    var choised = $("table.getInfo input[name='addr']:checked").val();
    var diachi = "";
    if (choised == "choice"){
      diachi = $("select#addr").val();
    } else if (choised == "manual"){
      diachi = $("table.getInfo textarea").val();
    }
    if (!diachi){
      $("tr[name='notice'] span:last").html('Vui lòng nhập địa chỉ!');
      $("tr[name='notice']").removeClass("hide");
    } else {
      $("tr[name='notice']").addClass("hide");
      var quick = <?php
                    if (isset($_GET["mabanh"]) && !empty($_GET["mabanh"])){
                      echo "true";
                    } else {
                      echo "false";
                    }
                  ?>;
      var xml = new XMLHttpRequest();
      xml.onreadystatechange = function(){
        if (xml.readyState == 4 && xml.status == 200){
          wall.upWithPane(xml.responseText);   
        }
      };
      if (quick){
        var mb = "<?php echo $_GET['mabanh'];?>";
        xml.open('GET', 'subPage/orderDone.php?ten='+ten+'&gt='+gt+'&sdt='+sdt+'&email='+email+'&giaohang='+giaohang+'&httt='+httt+'&diachi='+diachi+"&mabanh="+mb, true);
      } else {
        xml.open('GET', 'subPage/orderDone.php?ten='+ten+'&gt='+gt+'&sdt='+sdt+'&email='+email+'&giaohang='+giaohang+'&httt='+httt+'&diachi='+diachi, true);
      }
      xml.send();
    }
  });
</script>
