<?php echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">'; include("cms.php"); ?>
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
		<div id="todo">
			
			<h2 class="title">To Do Notes</h2>
			<?php
				allToDos(3, "date", "asc");
			?><br>
			<div class="tip" data-tip="Add another to do note. <a href='' class'help'>Help</a>"><a class="addToDo" href="#">Add Note<br></a></div>
			<form method="post" action="" id="addToDo" style="display: none;">Topic:<br><input type="text" name="toDoTitle" /><br>Content:<br><input type="text" name="toDoContent" /><br>Do By:<br><input class="date" type="text" name="toDoFor" placeholder="YYYY-MM-DD" /><br><input name="addToDo" type="submit" value="Add To Do" id="addToDoSubm" />
			<?php if(isset($p["addToDo"])){
				addToDo($p['toDoTitle'], $p['toDoContent'], $p['toDoFor']);
			} ?>
			</form>
			<div class="footer">
				<a href="pages/todos.php">View All</a>
				|
				<a href="?clearToDos=1">Clear All</a>
			</div>
		</div>
		<div id="easy_change">
			<h2>Change Website Details</h2>
			<form action="#" method="post" id="changeName">Website Name: <input placeholder="<?php echo websiteName() ?>" type="text" name="changeName"/><input type="submit" value="Change" name="changeNameS"/></form>
			<?php if(isset($p["changeNameS"])){
				setInfo("name", $_POST["changeName"]);
			} ?>
			<form action="#" method="post" id="image_upload" enctype="multipart/form-data">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000"/> 
				Change Logo Image: <input type="file" name="photo" accept="image/png, image/jpeg"/> 
				<input type="submit" name="file_submit" value="Upload"/><br>
				Current Logo Image: <?php echo websiteLogo("../img/logo.png") ?>
			</form>
			<?php
				
				if(isset($_POST['file_submit'])){
					
					$tmp_name = $_FILES["photo"]["tmp_name"];
					$name = $_FILES["photo"]["name"];
					move_uploaded_file($tmp_name, SITE_ROOT."/img/logo.png");
				}
			?>
			<form action="#" method="post" id="change_theme">
				Change Theme: 
				<select name="theme_name">
					<?php foreach(allThemes() as $theme){
						$theme = basename($theme);
						if($theme == theme()){
							echo "<option selected value='$theme'>$theme</option>";
						} else{
							echo "<option value='$theme'>$theme</option>";
						}
					} ?>
				</select>
				<input type="submit" name="theme_subm" value="Submit"/><br>
				Current Theme: <?php echo theme() ?>
			</form>
			<?php if(isset($_POST['theme_subm'])){ changeTheme($_POST['theme_name']); } ?>
		</div>
		<span class="hideScroll" id="toTop"></span>
	</body>
</html>
