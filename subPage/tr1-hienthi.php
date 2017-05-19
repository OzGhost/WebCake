<?php
	session_start();
	$logon = false;
	if (isset($_SESSION["UserID"]) && !empty($_SESSION["UserID"])){
		$logon = true;
	}
	if (isset($_GET["mb"]) && !empty($_GET["mb"])){
		$server = "mysql.hostinger.vn";
		$host = "u952681548_root";
		$pass = "ngaymai";
		$db = "u952681548_cake";
		
		$conn = new mysqli($server, $host, $pass, $db)
			Or die ("Can not connect to server! " . $conn->error);

		$sql_command = 'SELECT * FROM BANH WHERE MABANH = \''.$_GET["mb"].'\'';
		$resBanh = $conn->query($sql_command);
		$rowBanh = $resBanh->fetch_assoc();

		if ($rowBanh){

			$sql_command = "SELECT COUNT(*) as sl FROM LIKED WHERE MABANH=".$_GET["mb"].";";
			$rsLike = $conn->query($sql_command);
			$rowLike = $rsLike->fetch_assoc();
			$slLike = 0;
			if ($rowLike){
				$slLike = $rowLike["sl"];
			}

			$sql_command = 'SELECT COUNT(*) as sl FROM BINHLUAN WHERE MABANH = \''.$_GET["mb"].'\'';
			$resBL = $conn->query($sql_command);
			$rowBL = $resBL->fetch_assoc();
			$slBL = 0;
			if ($rowBL){
				$slBL = $rowBL["sl"];
			}
			$sql_command = 'SELECT * FROM BINHLUAN WHERE MABANH = \''.$_GET["mb"].'\'';
			$resBL = NULL;
			$resBL = $conn->query($sql_command);
			$rowBL = $resBL->fetch_assoc();
?>

		<div class="class1">
			<img mabanh=<?php echo '"'.$_GET["mb"].'"';?> src=<?php echo 'img/cake-md/'.$rowBanh["TENHINHANH"];?>>
			<p class="channeo">
				<span class="quick">Mua nhanh</span>
				<span class="normal">Thêm vào giỏ hàng</span>
			</p>
		</div>
		<div class="class2">
			<div class="child">
				<p class="bigger"><b><?php echo $rowBanh["TENBANH"];?></b></p>
				<p><span>Giá:
				<?php
					if ($rowBanh["GIAMGIA"] != '0'){
						echo "<strike>";
						echo (int)($rowBanh["GIA"]/1000).',';
						$du = $rowBanh["GIA"]%1000;
						if ($du == 0){
							echo '000';
						} else {
							echo $du;
						}
						echo " đ";
						echo "</strike>";

						echo "&nbsp;&nbsp;&nbsp;&nbsp;";

						echo "<b>";
						$newCost = (int)($rowBanh["GIA"]) - ( (int)($rowBanh["GIA"]) * (float)($rowBanh["GIAMGIA"]) );
						echo (int)($newCost/1000).',';
						$du = $newCost%1000;
						if ($du == 0){
							echo '000';
						} else {
							echo $du;
						}
						echo " đ";
						echo "</b>";
					} else {
						echo (int)($rowBanh["GIA"]/1000).',';
						$du = $rowBanh["GIA"]%1000;
						if ($du == 0){
							echo '000';
						} else {
							echo $du;
						}
						echo " đ";
					}
				?>
				</span></p>

				<hr>
				<div class="comment1">
						<input type="checkbox" id="like-btn" 	<?php
																	if ($logon){
																		$sql_command = "SELECT MABANH FROM LIKED WHERE USERNAME='".$_SESSION["UserID"]."' AND MABANH=".$_GET["mb"].";";
																		$rsLiked = $conn->query($sql_command);
																		$rowLiked = $rsLiked->fetch_assoc();
																		if ($rowLiked){
																			echo "checked";
																		}
																	} else {
																		echo "disabled";
																	}// end else IF ($logon)
																?> />
						<label for="like-btn"><i class="fa fa-thumbs-up"> <?php echo $slLike;?> Like</i></label>
					<i class="fa fa-comment"> <?php echo $slBL; ?> Comment</i>
				</div>
				<hr>
				<div class="comment2">
					<!-- <div> Comment</div> -->
					<?php
							while($rowBL){
								echo '<p><span class="user">'.$rowBL["USERNAME"].'</span>: '.$rowBL["NOIDUNG"].'</p>';
								$rowBL = $resBL->fetch_assoc();
							}// End while ($rowBL)
					?>
				</div>
				<div class="footer">
					<?php if($logon) { ?>
					<input type="text" id="cmt" placeholder="Viết bình luận" />
					<?php } // end IF ($logon)?>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			$("#cmt").on("keyup", function(e){
				var noidung = $("#cmt").val();
				if (e.keyCode == 13 && noidung.length > 0){
					var code = '<?php echo '<p><span class="user">'.$_SESSION["UserID"].'</span>: '; ?>' + noidung + '</p>';
					$(".comment2").append(code);
					$("#cmt").val("");

					var numbercmt = $(".comment1 i:last").text();
					var n = numbercmt.indexOf("Comment");
					n = Number(numbercmt.substring(1, n - 1));
					n++;
					$(".comment1 i:last").text(" " +n+ " Comment");


					var xmlHttp = new XMLHttpRequest();
					/*xmlHttp.onreadystatechange = function(){
						if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
							$(".class1").html(xmlHttp.responseText);
						}
					};*/
					xmlHttp.open("GET", "subPage/addBL.php?mb="+<?php echo $_GET["mb"];?>+"&user="+'<?php echo $_SESSION["UserID"];?>'+"&nd="+noidung, true);
  					xmlHttp.send();
  				}
			});

			$("span.quick").on("click", function(){
				var xml = new XMLHttpRequest();
				xml.onreadystatechange = function(){
					if (xml.readyState == 4 && xml.status == 200){
						wall.upWithPane(xml.responseText);
					}
				};
				xml.open("GET", "subPage/tr1-dathang.php?mabanh=<?php echo $rowBanh['MABANH'];?>&hinhanh=<?php echo $rowBanh['TENHINHANH'];?>&gia=<?php echo (int)($rowBanh['GIA'] * (float)(1-$rowBanh['GIAMGIA']));?>", true);
				xml.send();
			});

			$("span.normal").on('click', function(){
				var xml = new XMLHttpRequest();
				xml.onreadystatechange = function(){
					if (xml.readyState == 4 && xml.status == 200){
						wall.upWithPane(xml.responseText);
					}
				};
				xml.open("GET", "subPage/themvaoGH.php?mabanh=<?php echo $rowBanh['MABANH'];?>&hinhanh=<?php echo $rowBanh['TENHINHANH'];?>&gia=<?php echo (int)($rowBanh['GIA'] * (float)(1-$rowBanh['GIAMGIA']));?>", true);
				xml.send();
			});

			$("#like-btn").on('change', function(){
				var val = $(this).prop('checked');
				var mb = $(".class1").children("img").attr("mabanh");
				var xhr = new XMLHttpRequest();
				xhr.open('GET', 'subPage/likeNDislike.php?mb='+mb+'&val='+val, true);
				xhr.onreadystatechange = function(){
					if (xhr.readyState == 4){
						if (xhr.status == 200){
							console.log(xhr.responseText);
							var num = $("label[for='like-btn'] i").text();
							num = num.substring(1, num.indexOf('Like') - 1);
							num = Number(num);
							if (val){
								num++;
							} else {
								num--;
							}
							$("label[for='like-btn'] i").text(' '+num+' Like');
						}
					}
				};
				xhr.send(null);
			});

		</script>

<?php
		}// End if ($rowBanh)
		$conn->close();
	}// End if (isset && !empty)
?>
