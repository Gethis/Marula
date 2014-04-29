<?php
require(dirname(__FILE__) . "/../connect.php");
session_start();
$p = $_POST;
define('SITE_ROOT', realpath(dirname(dirname(__FILE__))));
define('12332331332', 'ui');
if(!isset($_SERVER['HTTP_REFERER'])){
	$_SERVER['HTTP_REFERER'] = $_SERVER['PHP_SELF'];
}
$_SERVER['NO_QS'] = preg_replace("/\?(.*)?/", "", $_SERVER['PHP_SELF']);
$_SERVER['NO_HASH'] = preg_replace("/\#(.*)?/", "", $_SERVER['PHP_SELF']);
$_SERVER['NO_HQ'] = preg_replace("/\#(.*)?/", "", $_SERVER['NO_QS']);
$mysqli->query("ALTER TABLE notifications ADD PRIMARY KEY(body)");
$mysqli->query("ALTER TABLE info ADD PRIMARY KEY(type)");
	function is_html($string){
		return preg_match("/<[^<]+>/",$string,$m) != 0;
	}
	function runSQL($script_path, $file){
		global $config;
		$comm = 'mysql'
			. ' --host=' . $config['db']['host']
			. ' --user=' . $config['db']['username']
			. ' --password=' . $config['db']['password']
			. ' --database=' . $config['db']['name']
			. ' --execute="SOURCE ' . $script_path
		;
		$output1 = shell_exec($comm . $file);
	}
	function toPNG($file){
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		if($ext == "png"){
			$source = imagecreatefrompng($file);
		} elseif($ext == "jpg"){
			$source = imagecreatefromjpeg($file);
		} elseif($ext == "gif"){
			$source = imagecreatefromgif($file);
		} else{
			$source = imagecreatefromstring(file_get_contents($file));
		}
		imagejpeg($source);
	}
	function setInfo($type="name", $val=null){
		global $mysqli;
		$stmt = $mysqli->prepare("INSERT INTO info (type, value) VALUES (?, ?) ON DUPLICATE KEY UPDATE value=?;");
		$stmt->bind_param("sss", $type, $val, $val);
		$stmt->execute();
		$stmt->close();
		header("Location: ".$_SERVER['PHP_SELF']);
	}
	function getInfo($type="name"){
		global $mysqli;
		$res = $mysqli->query("SELECT value FROM info WHERE type='$type';");
		if($res == true || $res->num_rows > 0){
			return $res->fetch_row()[0];
		} else{
			return null;
		}
	}
	function hasInfo($type="name"){
		global $mysqli;
		$res = $mysqli->query("SELECT value FROM info WHERE type='$type';");
		if($res == true || $res->num_rows > 0){
			return true;
		} else{
			return false;
		}
	}
	function countRows($table){
		global $mysqli;
		$res = $mysqli->query("SELECT * FROM $table");
		return $res->num_rows;
	}
	function allThemes(){
		return glob("../themes/*", GLOB_ONLYDIR);
	}
	function websiteName($addon=""){
		global $mysqli;
		$res = $mysqli->query("SELECT value FROM info WHERE type='name'");
		if($res){
			return $res->fetch_row()[0].$addon;
		} else{
			return "My Website".$addon;
		}
	}
	function addPost($title, $body){
		global $mysqli;
		$time = date("Y-m-d H:i:s");
		$stmt = $mysqli->prepare("INSERT INTO posts (title, body, date) Values(?, ?, ?);");
		$stmt->bind_param("sss", $title, $body, $time);
		$stmt->execute();
		$stmt->close();
		header("Location: ".$_SERVER['PHP_SELF']);
	}
	
	function addToDo($title, $body, $for){
		global $mysqli;
		$stmt = $mysqli->prepare("INSERT INTO todo (title, body, date) VALUES (?, ?, ?);");
		$stmt->bind_param("sss", $title, $body, $for);
		$stmt->execute();
		$stmt->close();
		header("Location: ".$_SERVER['PHP_SELF']);
	}
	function addNotification($body, $num){
		global $mysqli;
		$date = date("Y-m-d");
		$stmt = $mysqli->prepare("INSERT IGNORE INTO notifications (body, num) VALUES (?, ?);");
		$stmt->bind_param("ss", $body, $num);
		$stmt->execute();
		$stmt->close();
	}
	function deleteRow($table, $name, $value){
		global $mysqli;
		$stmt = $mysqli->prepare("DELETE FROM $table WHERE $name=?");
		$stmt->bind_param("s", $value);
		$stmt->execute();
		$stmt->close();
	}
	function allPosts($limit=10000000, $order="date", $by="asc"){
		global $mysqli;
		if($by == "asc" || $by == "desc"){
			$by = strtoupper($by);
		} else{
			echo "Only <i><b>asc</b></i> or <i><b>desc</b></i> are allowed for the third parameter of the function <i><b>allToDos</b></i>";
			die();
			return false;
		}
		$res = $mysqli->query("SELECT * FROM posts ORDER BY $order $by LIMIT $limit");
		if($res->num_rows != 0){
			while($a = $res->fetch_assoc()){
				echo "<h3 class='post_title'>{$a['title']}</h3><p class='post_date'>{$a['date']}</p><p class='post_body'>{$a['body']}</p>";
			}
		} else{
			echo "No to do's were found.";
			return false;
		}
	}
	function allToDos($limit=10000000, $order="date", $by="desc"){
		global $mysqli;
		if($by == "asc" || $by == "desc"){
			$by = strtoupper($by);
		} else{
			echo "Only <i><b>asc</b></i> or <i><b>desc</b></i> are allowed for the third parameter of the function <i><b>allToDos</b></i>";
			die();
			return false;
		}
		$res = $mysqli->query("SELECT * FROM todo ORDER BY $order $by LIMIT $limit");
		if($res->num_rows != 0){
			while($a = $res->fetch_assoc()){
				if(strtotime($a['date']) < strtotime(date("Y-m-d"))){
					if($_SERVER['HTTP_REFERER'] != $_SERVER['PHP_SELF']){
						addNotification("The following to do note is still in your to do list: <b><i>{$a['title']}</i></b>. Have you completed it yet? <br> <a href='done.php?key=1{$a['title']}'>Yes?</a> <a href='delete.php?table=notifications&key=num&val=1{$a['title']}'>No?</a>", "1{$a['title']}");
					}
				}
				echo "<h3 class='todo_title'>{$a['title']}</h3><p class='todo_date'>{$a['date']}</p><p class='todo_body'>{$a['body']}</p><a href='delete.php?table=todo&key=title&val={$a['title']}' class='remove_note'>Remove</a>";
			}
		} else{
			echo "<p>You have no to do notes.</p>";
			return false;
		}
	}
	function allNotifications($limit=10000000){
		global $mysqli;
		$res = $mysqli->query("SELECT * FROM notifications LIMIT $limit");
		if($res->num_rows != 0){
			while($a = $res->fetch_assoc()){
				echo "<p class='notifications_body'>{$a['body']}</p>";
			}
		} else{
			echo "<p>You have no notifications.<p>";
			return false;
		}
	}
	function websiteLogo($src="img/logo.png"){
		return "<img src='$src' />";
	}
	function theme(){
		global $mysqli;
		$theme = $mysqli->query("SELECT value FROM info WHERE type='theme'")->fetch_array()[0];
		if($theme){
			return $theme;
		} else{ 
			return "mainly-red";
		}
	}
	function clearTable($table){
		global $mysqli;
		$mysqli->query("TRUNCATE TABLE $table");
	}
	function clearData(){
		global $mysqli;
		$mysqli->query("SELECT 'TRUNCATE TABLE ' || table_name || ';' 
  FROM INFORMATION_SCHEMA.TABLES;");
	} 
	function changeTheme($to){
		global $mysqli;
		$mysqli->query("INSERT INTO info (type, value) VALUES ('theme', '$to') ON DUPLICATE KEY UPDATE value='$to'");
	}
	function downloadFile($url, $path){
		$newfname = $path;
		$file = fopen($url, "rb");
		if($file){
			$newf = fopen($newfname, "wb");

			if($newf){
				while(!feof($file)) {
					fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
				}
			}
		}

		if($file){
			fclose($file);
		}

		if($newf){
			fclose($newf);
		}
	}
	function addPage($name, $body, $in_nav, $use_page, $page, $id=null){
		global $mysqli;
		if($in_nav == true || $in_nav == 1){
			$in_nav = 1;
		} else{
			$in_nav = 0;
		}
		if($use_page == true || $use_page == 1){
			$use_page = 1;
		} else{
			$use_page = 0;
		}
		if($id == null){
			$id = $mysqli->query("SELECT * FROM pages")->num_rows + 1;
		}
		$stmt = $mysqli->prepare("INSERT INTO pages (name, content, in_nav, use_page, page_name, id) VALUES (?, ?, '$in_nav', '$use_page', ?, '$id') ON DUPLICATE KEY UPDATE name=?, content=?, in_nav='$in_nav', use_page='$use_page', page_name=?");
		$stmt->bind_param("ssssss", $name, $body, $page, $name, $body, $page);
		$stmt->execute();
		$stmt->close();
		header("Location: ".$_SERVER['PHP_SELF']);
	}
	function pageLoad($page){
		$time = microtime();
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;		
		file_get_contents($page);
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		return 'Page generated in '.$total_time.' seconds.';
		
	}
	function hasRow($row, $val, $table){
		global $mysqli;
		$found = $mysqli->query("SELECT $row FROM $table WHERE $row = '$val'");
		if($found){
			return true;
		} else{ 
			return false;
		}
	}
	function fetchData($row, $row2, $val, $table){
		global $mysqli;
		$found = $mysqli->query("SELECT $row2 FROM $table WHERE $row = '$val'");
		if($found){
			return $found->fetch_row()[0];
		} else{ 
			return false;
		}
	}
	function pages(){
		global $mysqli;
		$theme = $mysqli->query("SELECT * FROM pages");
		if($theme){
			return $theme;
		} else{ 
			return null;
		}
	}
	function nav_pages(){
		global $mysqli;
		$theme = $mysqli->query("SELECT * FROM pages WHERE in_nav='1'");
		if($theme){
			return $theme;
		} else{ 
			return null;
		}
	}
	function addInfo($type, $value){
		global $mysqli;
		$mysqli->query("INSERT INTO info (type, value) VALUES ('$type', '$value') ON DUPLICATE KEY UPDATE value='$value'");
	}
	
if(isset($_GET['clearToDos'])){
	clearTable("todo");
	header("Location: {$_SERVER['NO_HQ']}");
}