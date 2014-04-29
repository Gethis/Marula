<?php
include("cms.php");
if(isset($_GET['key'])){
	$key = $_GET['key'];
	$num = strval(intval($key));
	if($num == "1"){
		$title = substr($key, strlen($num));
		deleteRow("notifications", "num", $key);
		deleteRow("todo", "title", $title);
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
} else{
	exit();
}