
<script>
document.getElementById('loginUrl').value = location.href;
</script>

<div id="login-box" class="login-popup">
  <div class="modal-header">
					<a href="#" class="close btn_close">x</a>
					<h2 class="modal-title text-center fc-orange">로그인</h2>
		</div>
  <!-- <a href="#" class="close btn_close"><img src="../img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a> -->
  <form method="post" class="signin" name="form-login" action="../login-action.php">
    <input type="hidden" name="login-action" value="1">
    <input type="hidden" id="loginUrl" name="loginHref">
    <fieldset class="textbox">
      <label class="username">
        <span>아이디</span>
        <input id="username" name="user_id" value="" type="text" autocomplete="on">
      </label>

      <label class="password">
        <span>비밀번호</span>
        <input id="password" name="passwd" value="" type="password">
      </label>

      <input class="submitbutton" id="submit" type="submit" value="로그인">
    </fieldset>
  </form>
</div>
