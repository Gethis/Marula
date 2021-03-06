﻿<?php echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">'; include("cms.php"); ?>
<html>
	<head>
		<link href="style/style.css?1584829572" type="text/css" rel="stylesheet"/>
		<link href="../style/gtw.css?1584829572" type="text/css" rel="stylesheet"/>
		<link href="../style/melon.datepicker.css?1584829572" type="text/css" rel="stylesheet"/>
		<link href="../script/tipr.css?1104838543" type="text/css" rel="stylesheet"/>
		<link href="../script/apprise.css?1104838543" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="../script/jquery.min.js?57391411486839"></script>
		<script type="text/javascript" src="../script/jquery-ui.min.js?6739201637531"></script>
		<script type="text/javascript" src="../script/jpicker-1.1.6.min.js?54737274421754"></script>
		<script type="text/javascript" src="../script/apprise.js?54737274421754"></script>
		<script type="text/javascript" src="../script/tipr.min.js?54737274421754"></script>
		<script type="text/javascript" src="../script/oldBrowserBox.js?54737274421754"></script>
		<script type="text/javascript" src="script.js?1"></script>
		<script src="../script/instantclick.js" type="text/javascript" data-no-instant></script>
		<script type="text/javascript">InstantClick.init(75, true); console.log("start");</script>
		<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
	</head>
	<body data-instant-track data-instant>
		<div id="oldBrowserBox"><button class="close">x</button></div>
		<?php if(!isset($_SESSION['logged_in']) || !isset($_SESSION['password']) || !isset($_SESSION['username'])){
			header("Location: login.php");
		} ?>
		<div id="nav">
			<h1 id="websiteName" class="right"><?php echo websiteName(" Admin"); ?><br><span style="margin-left: 25px;font-size: 15px"><a class="right" href="../">View full site</a></span></h1>
			Welcome <b><?php echo $_SESSION['username'] ?>!</b>
			<div>
				<a class="showNotifications"><?php echo (countRows("notifications") == "1") ? countRows("notifications")." Notification" : countRows("notifications")." Notifications" ?></a>
			</div>
			<div class="menu">
				<a href="index.php">Dashboard</a>
				<a href="website.php">Website Content</a>
				<a href="stats.php">Statistics</a>
				<a href="pages.php">Pages</a>
			</div>
		</div>
		<div id="notifications" style="display: none;" class="scroll-pane">
			<?php
				allNotifications(3, "date", "asc");
			?>
		</div>
		<div id="stats">
			<h2>Page Loading times</h2>
			Home page: <?php echo pageLoad(dirname(dirname(__FILE__))."/index.php"); ?><br>
		</div>
		<span class="hideScroll" id="toTop"></span>
	</body>
</html>
