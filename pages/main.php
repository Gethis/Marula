<?php
	require dirname(__FILE__) . "/../admin/cms.php";
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">';
	function head(){
		echo "<link href='style/normalize.min.css' type='text/css' rel='stylesheet' />";
		echo "<link href='script/jquery.bxslider.css' type='text/css' rel='stylesheet' />";
		echo "<link href='".themeDir()."/style.min.css' type='text/css' rel='stylesheet' />";
		echo '<script type="text/javascript" src="script/jquery.min.js?57391411486839"></script>
		<script type="text/javascript" src="script/jquery.bxslider.js?57391411486839"></script>
		<script type="text/javascript">
			$(window).load(function() {
				$(".bxslider").bxSlider({
					touchEnabled: true
				});
			});
		</script>
		<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" /><link rel="shortcut icon" type="image/png" href="img/logo.png"/>';
	}
	function socialIcons(){
		$icons = "<ul class='social'>";
		if(hasRow("type", "facebook", "info")){
			$icons .= "<li class='facebook social_icon'><a href='".fetchData("type", "value", "facebook", "info")."'><img src='img/social/facebook_48.png'/></a></li>";
		}
		$icons .= "</ul>";
		return $icons;
	}
	function home(){
		echo "<div id='body-content'>";
		echo "Hello, and welcome to ".websiteName().".";
		slideshow();
		echo "</div>";
	}
	function slideshow(){
		$allfilesslides = glob(SITE_ROOT."/img/slideshow_slide*.png");
		$file_num_slide = count($allfilesslides)+1;
		if($file_num_slide > 0){
			echo '<script type="text/javascript">
				$(window).load(function() {
					$(".bxslider").bxSlider({
						touchEnabled: true,
						maxSlides: '.$allfileslides.',
						moveSlides: 1
					});
				});
			</script>';
			echo '<div class="slider"><ul class="bxslider">';
			
			for($i = 1; $i < $file_num_slide; $i++){
				echo "<li><a href='img/slideshow_slide$i.png'><img src='img/slideshow_slide$i.png' /></a></li>";
			}
			echo "</ul></div>";
		} else{
			echo "";
		}
	}
	function not_found(){
		header('HTTP/1.0 404 Not Found');
		echo "<h1>404 Not Found</h1>";
		echo "<div>The page that you have requested could not be found. If you typed the url into the address bar, please check the spelling. If you followed a link from another site it can be an old link. The page could have moved or changed it's name.</div>";
	}
	function nav(){
		echo "<div class='right'>".socialIcons()."</div>";
		echo "<div class='logo'><h1>".websiteLogo()." ".websiteName()."</h1></div>";
		echo "<div id='top-menu' class='menu'><ul>";
		echo "<li><a href='index.php'>Home</a></li>";
		$pages = nav_pages();
		if($pages->num_rows != 0 || $pages->num_rows != 1){
			while($page = $pages->fetch_assoc()){
				if($page['in_nav'] == 1){
					if($page['use_page'] != 1){
						echo "<li><a href='page.php?id={$page['id']}'>{$page['name']}</a></li>";
					} else{
						echo "<li><a href='{$page['page']}'>{$page['name']}</a></li>";
					}
				}
			}
		} elseif($pages->num_rows == 1){
			$page = $pages->fetch_assoc();
			if($page['in_nav'] == 1){
				if($page['use_page'] != 1){
					echo "<li><a href='page.php?page={$page['name']}'>{$page['name']}</a></li>";
				} else{
					echo "<li><a href='pages/{$page['page']}'>{$page['name']}</a></li>";
				}
			}
		}
		echo "</ul></div><div id='content'>"; 
	}
	function title($page){
		global $mysqli;
		if($page === "home"){
			echo "<title>Home - ".websiteName()."</title>";
		} elseif($page === "404"){
			echo "<title>Page Not Found - ".websiteName()."</title>";
		} else{
			$res = $mysqli->query("SELECT name FROM pages WHERE id = '$page'")->fetch_row()[0];
			echo "<title>$res - ".websiteName()."</title>";
		}
	}
	function content($page){
		global $mysqli;
		$res = $mysqli->query("SELECT content FROM pages WHERE id = '$page'");
		if($res->num_rows != 0){
			return $res->fetch_row()[0];
		} else{
			return "0 con";
		}
	}
	function footer(){
		echo "</div>";
		echo "<div class='menu' id='footer'><ul>";
		echo "<li class='right'><span>".websiteName()." &copy; ".date("Y")."</span></li>";
		if(getInfo("useFeedback") == 1){
			echo "<li class='right'><span>Send Feedback</span></li>";
		}
		echo "</div>";
	}
	function themeDir(){
		return "themes/".theme();
	}
?>