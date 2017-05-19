      <div class="lgcontainer">
        <div class="card"></div>
        <div class="card">
          <h1 class="title">Đăng Nhập</h1>
          <form action="subPage/relogin.php" method="POST">
            <div class="input-lgcontainer">
              <input type="text" id="Username" required="required" name="Username"/>
              <label for="Username">Tài khoản</label>
              <div class="bar"></div>
            </div>
            <div class="input-lgcontainer" name="pass">
              <input type="password" id="Password" required="required" name="Password"/>
              <label for="Password">Mật khẩu</label>
              <div class="bar"></div>
            </div>
            <div class="input-lgcontainer hide" name="login-error">
              <span  class="glyphicon glyphicon-exclamation-sign"></span>
              <span>message here :)</span>
            </div>
            <div class="button-lgcontainer">
              <input type="submit" value="Đăng Nhập" id="login-button" />
            </div>
          </form><!-- End form login -->
        </div>
        <div class="card alt">
          <div class="toggle">Đăng ký</div>
          <h1 class="title">Đăng ký
            <div class="close"></div>
          </h1>
          <form action="subPage/reg.php" method="POST">
            <div class="input-lgcontainer">
              <input type="text" id="User" required="required" name="user"/>
              <label for="Username">Tài khoản</label>
              <div class="bar"></div>
            </div>
            <div class="input-lgcontainer">
              <input type="password" id="Pass" required="required" name="pass"/>
              <label for="Password">Mật khẩu</label>
              <div class="bar"></div>
            </div>
            <div class="input-lgcontainer">
              <input type="password" id="RePass" required="required" name="repass"/>
              <label for="Repeat Password">Nhập lại mật khẩu</label>
              <div class="bar"></div>
            </div>
            <div class="input-lgcontainer">
              <input type="email" id="Email" required="required" name="email"/>
              <label for="Email">Email</label>
              <div class="bar"></div>
            </div>
            <div class="input-lgcontainer hide" name="reg-error">
              <span  class="glyphicon glyphicon-exclamation-sign"></span>
              <span>message here :)</span>
            </div>
            <div class="button-lgcontainer">
              <input type="submit" value="Đăng ký" id="reg-button" />
            </div>
          </form><!-- End form sign up -->
        </div>
      </div><!-- end sign-pane -->
    <script type="text/javascript" src="js/sign.js"></script>