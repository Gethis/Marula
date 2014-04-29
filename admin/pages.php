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
		<script type="text/javascript" src="../script/marked.js?54737274421754"></script>
		<script type="text/javascript" src="../script/apprise.js?54737274421754"></script>
		<script type="text/javascript" src="../script/tipr.min.js?54737274421754"></script>
		<script type="text/javascript" src="../script/oldBrowserBox.js?54737274421754"></script>
		<script type="text/javascript" src="../script/tinymce.min.js?54737274421754"></script>
		<script type="text/javascript" src="../script/plugins/jbimages/plugin.min.js?54737274421754"></script>
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
		<div id="pages">
			<table class="nice-table nice-table-bordered">
				<thead>
					<tr>
						<th>Page Name</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php 
						$pages = pages();
						if($pages->num_rows != 0 || $pages->num_rows != 1){
							
							while($page = $pages->fetch_assoc()){
								echo "<tr>";
								echo "<td>".$page['name']."</td>";
								echo "<td><a title='Delete this page.' href='delete.php?table=pages&key=id&val={$page['id']}'><img class='delete' src='../img/delete.png'/></a> <a  href='#' class='editPage' data-toggle='#edit-page' data-change-text='false' data-store='{$page['id']}'><img class='edit' src='../img/edit.png'/></a></td>";
								$page_id = $page['id'];
								echo "</tr>";
							}
						} elseif($pages->num_rows == 1){
							$page = $pages->fetch_assoc();
							echo "<tr>";
							echo "<td>".$page['name']."</td>";
							echo "<td><a href='delete.php?table=pages&key=id&val={$page['id']}'><img class='delete' src='../img/delete.png'/></a> <a href='#' class='editPage' data-toggle='#edit-page' data-change-text='false' data-store='{$page['id']}'><img class='edit' src='../img/edit.png'/></a></td>";
							echo "</tr>";
							$page_id = $page['id'];
						}
					?>
					<tr>
						<td><a href="#" data-toggle="#add-page">Add Page</a></td>
						<td><img class='add' src='../img/add.png'/></td>
				</tbody>
			</table>
			<form style="display: none" action="" method="post" id="add-page">
				Page Name: <input type="text" name="pageName"/><br>
				Do you want to use a custom page: <input type="checkbox" name="cust_page" class='cust-page' id="custom_page"/><br>
				<span>Custom Page:</span> <input type="text" name="page_url" id="custom_page_name"/><br>
				<span>Page Content:</span><br> <textarea class="editor" name="content" id="content_text"></textarea><br>
				Do you want to show the page in navigation bar: <input type="checkbox" name="in_nav"/><br>
				<input type="submit" name="pageSubm"/>
			</form>
			<div id="loading" style="display:none;"><img src="../img/loader.gif"/></div>
			<form style="display: none" action="" method="post" id="edit-page">
				<input type="hidden" class='pageID' name='page_id'/>
				Page Name: <input type="text" name="pageName" id="page-name2"/><br>
				Do you want to use a custom page: <input class='cust-page' type="checkbox" name="cust_page" id="custom_page2"/><br>
				<span>Custom Page:</span> <input type="text" name="page_url" id="custom_page_name2"/><br>
				<span>Page Content:</span><br> <textarea value="" class="editor" name="content" id="content_text2"></textarea><br>
				Do you want to show the page in navigation bar: <input type="checkbox" name="in_nav" id="in-nav2"/><br>
				<input type="submit" name="edit_pageSubm"/>
			</form>
			<?php if(isset($_POST['pageSubm'])){
				if(isset($_POST['in_nav'])){
					$in_nav = 1;
				} else{ 
					$in_nav = 0;
				}
				if(isset($_POST['cust_page'])){
					$cust = 1;
				} else{ 
					$cust = 0;
				}
				addPage($_POST['pageName'], $_POST['content'], $in_nav, $cust, $_POST['page_url']);
			}
			if(isset($_POST['edit_pageSubm'])){
				if(isset($_POST['in_nav'])){
					$in_nav = 1;
				} else{ 
					$in_nav = 0;
				}
				if(isset($_POST['cust_page'])){
					$cust = 1;
				} else{ 
					$cust = 0;
				}
				addPage($_POST['pageName'], $_POST['content'], $in_nav, $cust, $_POST['page_url'], $_POST['page_id']);
			} ?>
		</div>
		<span class="hideScroll" id="toTop"></span>
	</body>
</html>
