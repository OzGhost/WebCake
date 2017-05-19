<div class="rs-pane">
  <h2>Kết quả tìm kiếm</h2>
  <hr/>
  <?php
    if (!$_GET["ten"]){
      echo "Chưa nhập tên bánh";
    } else {
      $serer = "mysql.hostinger.vn";
      $host = "u952681548_root";
      $pass = "ngaymai";
      $db = "u952681548_cake";
      $conn = new mysqli($server, $host, $pass, $db)
        or die ("Can not connect to server! ".$conn->error);

      $sql_cmd = "select MABANH, TENHINHANH, TENBANH from BANH where TENBANH like '%".$_GET["ten"]."%';";
      $rs = $conn->query($sql_cmd);
      $row = $rs->fetch_assoc();
      if (!$row){
        echo "Không tìm thấy kết quả nào.";
      } else {
        while ($row){
          echo '<a href="'.$row["MABANH"].'" class="rs-item">
                  <img src="img/cake-sm/'.$row["TENHINHANH"].'" />
                  <span>'.$row["TENBANH"].'</span>
                </a>';
          $row = $rs->fetch_assoc();
        }
      }
    }
  ?>
</div>
<script type="text/javascript">
  $(".rs-pane a").on('click', function(e){
    e.preventDefault();
    var mb = $(this).attr("href");
    wall.forShowCake(mb);
  });
</script>