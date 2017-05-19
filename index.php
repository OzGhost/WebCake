
<?php
  // Start the session
  session_start();
  $sl = 0;
  if (isset($_SESSION["giohang"]) && !empty($_SESSION["giohang"])) $sl = count($_SESSION["giohang"]);
  // check for logon
  $logon = false;
  if (isset($_SESSION["UserID"]) && !empty($_SESSION["UserID"])) $logon = true;

  $server ="mysql.hostinger.vn";
  $host = "u952681548_root";
  $pass = "ngaymai";
  $db = "u952681548_cake";
  $conn = new mysqli($server, $host, $pass, $db)
    Or die ("Can not connect to server! ".$conn->error);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>Sweet Cakes</title>
  <link rel="icon" href="img/icon.png" />
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/login-style.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
  <link rel="stylesheet" type="text/css" href="css/tr1-all.css">
  <link rel="stylesheet" type="text/css" href="css/tr1-hienthi.css">
  <link rel="stylesheet" type="text/css" href="css/tr3-huongdan.css">
  <link rel="stylesheet" type="text/css" href="css/tr1-dathang.css">
  <link rel="stylesheet" type="text/css" href="css/tr1-hoantat.css">
  <link rel="stylesheet" type="text/css" href="css/payBag.css">
  <script type="text/javascript" src="js/jQuery_v1.12.3.min.js"></script>
</head>
<body>

<table class="mynav"><tr>
  <td>
    <a class="logo" href=".">
      <img src="img/logo.png"/>
      <h1>Sweet Cakes</h1>
    </a>
  </td>
  <td>
    <form action="search.php">
      <input class="search-bar" type="text" placeholder="Tìm kiếm tên bánh" />
    </form>
  </td>
  <td class="<?php if($logon) echo 'long'; else echo 'short';?>">
    <div class="accgroup">
      <ul>
          <?php
            if (isset($_SESSION["UserID"])){
              if (! empty($_SESSION["UserID"])){
                echo '<li>  
                          ' . $_SESSION["UserID"] . ' 
                          <img class="img-circle" src="img/user.jpg">
                            <ul>
                              <li class="press">
                                <a href="subPage/tr1-thongtinchung">Thông tin chung</a>
                              </li>
                              <li>
                                <a href="subPage/tr1-thongtintk">Thông tin tài khoản</a>
                              </li>
                              <li>
                                <a href="subPage/tr1-sodiachi">Sổ địa chỉ</a>
                              </li>
                              <li>
                                <a href="subPage/tr1-donhang">Đơn hàng của tôi</a>
                              </li>
                              <li>
                                <a href="subPage/tr1-dondatban">Thông tin đặt bàn</a>
                              </li>
                              <li>
                                <a href="dangxuat">Đăng xuất</a>
                              </li>
                            </ul>
                        </li>
                        <li>
                          <a href="#giohang">
                            <img class="img-circle" src="img/gio-hang.png">
                            <span>Giỏ hàng('.$sl.')</span>
                          </a>
                        </li>
                        <li><a href="dangxuat">Đăng xuất</a></li>'; 
              }
            }  else {
              echo '<li><a href="#giohang">
                          <img src="img/gio-hang.png">
                          <span>Giỏ hàng('.$sl.')</span>
                        </a></li>
              <li><a href="#login" data-toggle="modal">Đăng nhập</a></li>';
            }
          ?>
      </ul>
    </div>
  </td>
</tr></table>

<div class="big-father">

  <div class="slidee toggle deactive" slide-num="0">
    <span class="close-toggle-slidee fa fa-times" aria-hidden="true"></span>
    <hr class="footering" />
  </div>

  <div class="pControl">
    <ul>
      <li pIndex="1"><div></div></li>
      <li pIndex="2"><div></div></li>
      <li pIndex="3"><div></div></li>
      <li pIndex="4"><div></div></li>
    </ul>
  </div>
<!-- trang 1 -->
  <div class="slidee intro-p01 active" slide-num="1">
    <div class="filter flex-cont-around">
      <div class="filter-kind flex-item">
        <span class="title">Loại:</span>
        <input type="radio" value="KEM" name="kind" id="kem" /><label for="kem">Bánh Kem</label>
        <input type="radio" value="NGOT" name="kind" id="ngot" checked /><label for="ngot">Bánh Ngọt</label>
      </div>
      <div class="filter-cost flex-item">
        <span class="title">Giá:</span>
        <input type="radio" value="increase" name="cost" id="incre" checked /><label for="incre">Tăng dần</label>
        <input type="radio" value="decrease" name="cost" id="decre"><label for="decre">Giảm dần</label>
      </div>
      <div class="filter-special flex-item">
        <span class="title">Tiêu điểm:</span>
        <input type="radio" value="sale" name="special" id="sale" checked /><label for="sale">Khuyến mãi</label>
        <input type="radio" value="hot" name="special" id="hot" /><label for="hot">Mua nhiều</label>
        <input type="radio" value="new" name="special" id="new" /><label for="new">Mới nhất</lable>
      </div>
    </div>
    <div class="cake-slide flex-cont-between">
      <div class="left-pane flex-item">
        <a href="#" class="prev-btn clickable"><p></p></a>
        <a href="#" class="next-btn clickable"><p></p></a>
        <?php
          $sql_command = "select MABANH, TENHINHANH from BANH where LOAI='KEM' order by GIAMGIA DESC limit 3;";
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
          }
        ?>
      </div><!-- end left-spane -->
      <div class="right-pane flex-item">
        <a href="#" class="prev-btn clickable"><p></p></a>
        <a href="#" class="next-btn clickable"><p></p></a>
        <?php
          $sql_command = "select MABANH, TENHINHANH from BANH where LOAI='NGOT' order by GIAMGIA DESC limit 3;";
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
          }
        ?>
      </div><!-- end right-spane -->
    </div><!-- End CakeSlide -->

    <div class="small-cake-pane flex-cont-around">
      <a href="#" class="prev-btn clickable"><p></p></a>
      <a href="#" class="next-btn clickable"><p></p></a>
      <?php
        $sql_command = "select MABANH, TENHINHANH from BANH where LOAI='NGOT' order by GIA limit 12;";
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
      ?>
    </div><!-- end multi-cake-pane -->

  </div><!-- End Slide 01 -->


<!-- trang 2 -->
  <div class="slidee p02"  slide-num="2">

    <div class="front">

      <div class="things">
        <form>
          <table class="table-ord">
            <tr><td class="title"><?php
                                      $allow = "";
                                      if ($logon){
                                        echo "Bạn muốn đặt bàn?";
                                        $allow = "";
                                      } else {
                                        echo "Bạn cần đăng nhập để sử dụng chức năng đặt bàn!";
                                        $allow = "disabled";
                                      }
                                    ?></td></tr>
            <tr><td> Thời gian:<select name="time" <?php echo $allow;?>>
                                  <option value="08:00">08:00</option>
                                  <option value="09:00">09:00</option>
                                  <option value="10:00">10:00</option>
                                  <option value="11:00">11:00</option>
                                  <option value="12:00">12:00</option>
                                  <option value="13:00">13:00</option>
                                  <option value="14:00">14:00</option>
                                  <option value="15:00">15:00</option>
                                  <option value="16:00">16:00</option>
                                  <option value="17:00">17:00</option>
                                  <option value="18:00">18:00</option>
                                  <option value="19:00">19:00</option>
                                  <option value="20:00">20:00</option>
                                  <option value="21:00">21:00</option>
                                  <option value="22:00">22:00</option>
                                 
                                </select></td></tr>
            <tr><td class="d-m">
              <table>
                <tr><td colspan="2">Ngày:</td></tr>
                <tr>
                  <td>
                    <select class="thang" <?php echo $allow;?> >
                      <option value="1">tháng một</option>
                      <option value="2">tháng hai</option>
                      <option value="3">tháng ba</option>
                      <option value="4">tháng tư</option>
                      <option value="5">tháng năm</option>
                      <option value="6">tháng sáu</option>
                      <option value="7">tháng bảy</option>
                      <option value="8">tháng tám</option>
                      <option value="9">tháng chín</option>
                      <option value="10">tháng mười</option>
                      <option value="11">tháng mười một</option>
                      <option value="12">tháng mười hai</option>
                    </select>
                  </td>
                  <td>
                    <select class="ngay" <?php echo $allow;?> >
                      <?php
                        for ($i = 0; $i < 31; $i++){
                          echo "<option value='".($i + 1)."'>".($i + 1)."</option>";
                        }
                      ?>
                    </select>
                  </td>
                </tr>
              </table><!-- end table ngay-thang -->
            </td></tr>
            <tr><td> Vị trí:<!--<input type="text" placeholder="Vi tri" name="place" />-->
              <select class="place" <?php echo $allow;?> >
                <?php
                  if ($logon){
                    $sql_command = "SELECT * FROM BAN;";
                    $rs = $conn->query($sql_command);
                    $row = $rs->fetch_assoc();
                    $option = "";
                    while($row){
                      $option = "Bàn ".$row["MABAN"]." (";
                      $nothave = "disabled";
                      if ($row["TINHTRANG"] == 1){
                        $nothave = "";
                        $option .= $row["SOGHE"]." ghế)";
                      } else {
                        if ($row["TINHTRANG"] == 2){
                          $option .= "đã được đặt)";
                        } else{
                          if ($row["TINHTRANG"] == 3) {
                            $option .= "đang sửa chữa)";
                          }
                        }
                      }
                ?>
                <option value="<?php echo $row["MABAN"];?>" <?php echo $nothave;?> ><?php echo $option;?></option>
                <?php
                      $row = $rs->fetch_assoc();
                    }// end of WHILE ($row)
                    // if ($conn) $conn->close();
                  }// end of IF ($logon)
                ?>
              </selected>
            </td></tr>
            <?php
              if ($logon){
                echo '<tr><td class="title"><input type="checkbox" id="cake-ord" name="plus" />
                      <label for="cake-ord">Bạn muốn đặt bánh trước?</label></td></tr>';    
              }
            ?>
            <tr><td> Tên bánh:<!--<input type="text" placeholder="Ten banh" name="cakename" disabled />-->
              <select disabled class="cakename">
                <?php
                  $sql_command = "SELECT MABANH, TENBANH FROM BANH ORDER BY TENBANH";
                  $rs = $conn->query($sql_command);
                  $row = $rs->fetch_assoc();
                  while ($row){
                    echo '<option value="'.$row["MABANH"].'">'.$row["TENBANH"].'</option>';
                    $row = $rs->fetch_assoc();
                  }
                ?>
              </select>
            </td></tr>
            <tr><td> Nước uống:<!--<input type="text" placeholder="Nuoc uong" name="drink" disabled />-->
              <select disabled class="drink">
                <?php
                  $sql_command = "SELECT MANUOC, TENNUOC FROM NUOC  ORDER BY TENNUOC";
                  $rs = $conn->query($sql_command);
                  $row = $rs->fetch_assoc();
                  while ($row){
                    echo '<option value="'.$row["MANUOC"].'">'.$row["TENNUOC"].'</option>';
                    $row = $rs->fetch_assoc();
                  }
                ?>
              </select>
            </td></tr>
            <tr class="notices"><td>Chưa chọn thời gian</td></tr>
            <tr><td><input type="submit" value="Đặt Bàn" <?php echo $allow;?> /></td></tr>
          </table>
        </form>
      </div><!-- End things -->

      <div class="bigImgs middle-pane">
        <a href="#" class="prev-btn clickable"><p></p></a>
        <a href="#" class="next-btn clickable"><p></p></a>
        <div pane-id="1" class="pane-item active">
          <img src="img/Store/placeA.jpg" />
        </div>
        <div pane-id="2" class="pane-item">
          <img src="img/Store/placeB.jpg" />
        </div>
        <div pane-id="3" class="pane-item">
          <img src="img/Store/placeC.jpg" />
        </div>
      </div><!-- End bigImgs -->

      <div class="events">
        <div class="eItem in">
          <img src="img/event-icon.png">
          <span>Chào mừng khai trương hệ thống cửa tiệm bánh mới</span>
        </div>
        <div class="eItem in">
          <img src="img/event-icon.png">
          <span>Từng bừng đón lễ tình nhân 14/02 cùng các ưu đãi đặc biệt</span>
        </div>
        <div class="eItem in">
          <img src="img/event-icon.png">
          <span>Tri ân khách hàng với chương trình bốc thăm trúng thưởng hấp dẫn</span>
        </div>
        <div class="eItem in">
          <img src="img/event-icon.png">
          <span>[Thông báo] Tạm đóng cửa chi nhánh ... để nâng cấp quán</span>
        </div>
      </div><!-- End events -->
    </div><!-- End front -->

  </div><!-- End Slide 02 -->

  <!-- trang 3: how to make the cakes? -->
  <div class="slidee p03"  slide-num="3">
    <input type="checkbox" id="pinpoint" />
    <label for="pinpoint"><span class="fa fa-hand-paper-o" aria-hidden="true"></span></label>
    <div class="wallvid">
      <div class="panelvid" id="innerpanel">
        <div class="innerpanelvid">
          <a name="title-vid"></a>

          <div class="menu">
            
            <div class="menucon">
              <p class="article hightlight">Bánh kem</p>
            <hr>
            <table>
              <tr>
                <td>
                  <img src="img/videoCap/1445486642_banhkemsinhnhattainha.jpg">
                  <p><a href="#title-vid">Cách làm bánh kem sinh nhật tại nhà</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/59807_body_6.jpg">
                    <p><a href="#title-vid">Cách làm bánh kem dâu ngon đẹp đơn giản</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/59807_body_5.jpg">
                    <p><a href="#title-vid">Cách làm bánh kem giáng sinh 2016 mẫu Ông Già Noel</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/hinh-anh-nen-banh-sinh-nhat-tuyet-dep-3.jpg">
                    <p><a href="#title-vid">Làm Bánh Kem Với Phong Cách Làm Gốm Sứ Cực Đỉnh</a> <!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/59807_body_5.jpg">
                    <p><a href="#title-vid">Bánh kem trà xanh không cần lò nướng</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
              </tr>
            </table>
            <p class="article hightlight">Bánh ngọt</p>
            <hr>
            <table>
              <tr>
                <td>
                  <img src="img/videoCap/tinhyeu.gif">
                    <p><a href="#title-vid">Cách làm bánh ngọt Mararoon Pháp bốn màu</a> <!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/Fn7q19G.jpg">
                    <p><a href="#title-vid">Cách làm bánh Mochi cực kì đơn giản</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/chewy-junior-travelnhatrangnet-1100.jpg">
                    <p><a href="#title-vid">Cách làm bánh ngọt cực chất</a> <!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/hinh-anh-banh-kem-5.jpg">
                    <p><a href="#title-vid">dạy làm bánh Cheesecake chanh dây siêu ngon, cực dễ</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/hinh-nen-_635930351561592624.jpg">
                    <p><a href="#title-vid">Cách làm bánh ngọt đẹp đơn giản</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
              </tr>
            </table>
            <p class="article hightlight">Bánh bông lan<!--<span> - 1 giờ trước</span>--></p>
            <hr>
            <table>
              <tr>
                <td>
                  <img src="img/videoCap/mon-an-cua-nhat-mon-an-cua-nhat-thom-ngon-banh-bong-lan-tra-xanh-2.jpg">
                    <p><a href="#title-vid">Cách làm bánh bông lan cầu vồng</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/1430989506-banh-bong-lan-trung-muoi-7.jpg">
                  <p><a href="#title-vid">Dạy cách làm bánh bông lan từ đầu</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/cach-lam-banh-bong-lan-1.jpg">
                    <p><a href="#title-vid">Cách làm bánh Flan bông lan chocolate - Gateau flan</a> <!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/179022-banh-bl-body- (5).jpg">
                  <p><a href="#title-vid">Cách làm bánh bông lan ngon</a> <!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/anh 5.2.jpg">
                    <p><a href="#title-vid">Cách làm bánh Dorayaki</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
              </tr>
            </table>
            <p class="article hightlight">Capuchino</p>
            <hr>
            <table>
              <tr>
                <td>
                  <img src="img/videoCap/images (2).jpg">
                    <p><a href="#title-vid">Dạy pha chế cà phê capuchino, latte cafe</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/images (3).jpg">
                    <p><a href="#title-vid">Cách pha cappuccino độc đáo</a> <!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/cach-pha-capuchino-don-gian-co-the-lam-bang-may-hoac-bang-tay.jpg">
                    <p><a href="#title-vid">Cách vẽ hình trên tách Cappucino</a> <!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/Cappuccino_in_Tokio.jpg">
                  <p><a href="#title-vid">Cách làm Coffee Capuchino</a><!--<span> - 1 giờ trước</span>--></p>
                </td>
                <td>
                  <img src="img/videoCap/capu-chi-no-cho-ngay-nang_top9xy.wap.sh.jpg">
                    <p><a href="#title-vid">Đẳng Cấp Pha Cà Phê Capuchino</a> <!--<span> - 1 giờ trước</span>--></p>
                </td>
              </tr>
            </table>
          </div>
          </div><!-- End Menu -->


        </div><!-- End innerpanelvid -->
      </div><!-- End panelvid -->
    </div><!-- End wallvid -->
  </div><!-- End Slidee 03 -->

  <!-- Part 04: contact -->
  <div class="slidee p04"  slide-num="4">
    <div class="flex-cont-around">
    <div class="panel flex-item">
      <div class="header">
        <h1>Message</h1>
      </div>
      <div class="chuaform">
      <form action="subPage/lienhe.php" method="post">
        <div class="form-class">
          <label>Tên</label>
          <input type="text" name="name" placeholder="Tên" size="60" data-validation-required-message="Vui lòng nhập tên của bạn." aria-invalid="false">
          <hr >
        </div>
        <div class="form-class">
          <label>Email</label>
          <input type="text" name="email" placeholder="Email" size="60" data-validation-required-message="Vui lòng nhập email của bạn." aria-invalid="false">
          <hr>
        </div>
        <div class="form-class">
          <label>Chủ đề </label>
          <input type="text" name="subject" placeholder="Chủ đề" size="60" data-validation-required-message="Vui lòng nhập số điện thoại của bạn." aria-invalid="false">
          <hr>
        </div>
        
        <div class="form-class">
          <label>Nội dung</label>
          <textarea placeholder="Nội dung" name="content" rows="2" cols="60" data-validation-required-message="Vui lòng nhập lời nhắn của bạn." aria-invalid="false"></textarea/>
          <hr>
        </div>
        </div>
        <div class="center">
          <input type="submit" value="Gửi">
        </div>  
      </form>

    </div>
    <div class="contact flex-item">
    <h1>Contact</h1>
    <img src="./img/emai.png">
    <span class="befor1"><a href="mailto:tranhuong13520340@gmail.com"> tranhuong13520340@gmail.com</a></span><br>
    <img src="./img/dienthoai.png">
    <span class="befor2"> +84 672 419 575</span><br>
     <img src="./img/diachi.png">
    <span class="befor3"> Kí túc xá khu B, HCM City</span><br><br>
    <h1>Social networks</h1>
    <img src="./img/face.png">
    <span class="befor1"><a href="https://www.facebook.com/Sweet-Cakes-813512162118489"> Facebook</a></span>
    
    </div>
  </div><!-- end flex-cont -->
  </div><!-- End Slidee 04 -->


</div><!-- End BigFather -->


	<div class="full-screen-wall">
    <a href="#close-wall"><span class="fa fa-times-circle-o" aria-hidden="true"></span></a>
  </div>

	<script type="text/javascript" src="js/index.js"></script>
  <script type="text/javascript" src="js/tr3-huongdan.js"></script>
  <?php
    if ($conn) $conn->close();
  ?>
</body>
</html> 