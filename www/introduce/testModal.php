<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Login Modal Dialog Window with CSS and jQuery</title>
<link href="../css/modal.css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/loginModal.js"></script>
<link rel="canonical" href="http://www.alessioatzeni.com/wp-content/tutorials/jquery/login-box-modal-dialog-window/index.html" />
</head>
<body>
<h1>Login Modal Dialog Window with CSS and jQuery<small>Tutorial by Alessio Atzeni | <a href="http://www.alessioatzeni.com/blog/login-box-modal-dialog-window-with-css-and-jquery/">View Tutorial</a></small></h1>
<div class="container">
	<div id="content">

		<div class="post">
    	<h2>Your Login or Sign In Box</h2>
        	<div class="btn-sign">
				<a href="#login-box" class="login-window">Login / Sign In</a>
        	</div>
		</div>

        <div id="login-box" class="login-popup">
        <a href="#" class="close"><img src="close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
          <form method="post" class="signin" action="#">
                <fieldset class="textbox">
            	<label class="username">
                <span>Username or email</span>
                <input id="username" name="username" value="" type="text" autocomplete="on" placeholder="Username">
                </label>

                <label class="password">
                <span>Password</span>
                <input id="password" name="password" value="" type="password" placeholder="Password">
                </label>

                <button class="submit button" type="button">Sign in</button>

                <p>
                <a class="forgot" href="#">Forgot your password?</a>
                </p>

                </fieldset>
          </form>
		</div>

    </div>
</div>

</body>
</html>
