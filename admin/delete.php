<?php
include("cms.php");
if(isset($_GET['table']) && isset($_GET['key']) && isset($_GET['val'])){
	deleteRow($_GET['table'], $_GET['key'], $_GET['val']);
	header("Location: ".$_SERVER['HTTP_REFERER']);
}
?>