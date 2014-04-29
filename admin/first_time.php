﻿<head>
	<link href="style/style.css" type="text/css" rel="stylesheet"/>
	<script type="text/javascript" src="../script/jquery.min.js?57391411486839"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#loading").hide();
			$("#register").show();
		});
	</script>
</head>
<body class="center" style="background: url(../img/backgrounds/bg-<?php echo rand(1,12); ?>-full.jpg) no-repeat; background-size: 100%;">
	<?php include "cms.php";
	require_once('../includes/recaptchalib.php');
	$publickey = "6LfNNvESAAAAABFr3YOWDVk-L8W9v6LSs6csNTGj";
	$privatekey = "6LfNNvESAAAAAPFW2nZ-92ZZwIUX8DZ506r9bILn";
	echo $_SERVER['HTTP_REFERER'];
	echo $_SERVER['PHP_SELF'];
	?>
	<h1 id="login_title" class='login'><?php echo websiteName(); ?><br></h1><span id="login_span" class="login big">Created with Marula CMS</span>
	<div id="loading" style="display: block;">
		<img src="../img/loader.gif" />
	</div>
	<div style="display: none;" id="register" class="form">
		<span class="info">Set up your details.</span>
		<form id="registr" method="post" action="">
			Your email<br> <input type="text" name="email" /><br>
			Username<br> <input type="text" name="username" /><br>
			Password<br> <input type="text" name="password" /><br>
			Website name<br> <input type="text" name="site_name" /><br>
			To make sure that you're not a robot or a monkey, please enter this captcha.
			<?php
				echo recaptcha_get_html($publickey);
			?>
			<input type="submit" value="Register" name="subm" />
		</form>
	</div>
	<?php
	if(isset($_POST['subm'])){
		$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$email = $_POST['email'];
		$site_name = $_POST['site_name'];
		if(is_html($user) || is_html($pass) || is_html($email) || is_html($site_name)){
			echo "<strong style='color:white;'>Please DO NOT enter HTML in the username, password, website name or email!</strong>";
			exit();
		}
		if(empty($email) || $email == null){
			echo "<strong style='color:white;'>Please enter your email!</strong>";
			exit();
		}
		if(empty($user) || $user == null){
			echo "<strong style='color:white;'>Please enter a username!</strong>";
			exit();
		}
		if(empty($pass) || $pass == null){
			echo "<strong style='color:white;'>Please enter a password!</strong>";
			exit();
		}
		if(empty($site_name) || $site_name == null){
			echo "<strong style='color:white;'>Please enter a website name!</strong>";
			exit();
		}
		if (!$resp->is_valid) {
			echo "<strong style='color:white;'>The reCAPTCHA wasn't entered correctly. Please try again...</strong>";
			exit();
		}
		setInfo("name", $site_name);
		$stmt = $mysqli->prepare("INSERT IGNORE INTO admin (name, val) VALUES ('username', ?)");
		$stmt->bind_param("s", $user);
		$stmt->execute();
		$stmt->close;
		$stmt1 = $mysqli->prepare("INSERT IGNORE INTO admin (name, val) VALUES ('password', ?)");
		$stmt1->bind_param("s", $pass);
		$stmt1->execute();
		$stmt1->close;
		$stmt1 = $mysqli->prepare("INSERT IGNORE INTO admin (name, val) VALUES ('email', ?)");
		$stmt1->bind_param("s", $email);
		$stmt1->execute();
		$stmt1->close;
		$_SESSION['logged_in'] = true;
		$_SESSION['username'] = $user;
		$_SESSION['password'] = $pass;
		header("Location: index.php");
	}
	?>
</body>