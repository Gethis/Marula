﻿<?php 
if(!isset($_SESSION['logged_in')){ echo "Not Allowed"; exit() }
if(is_readable($_GET['file'])){
	unlink($_GET['file']);
} else{
	echo "File Not Found.";
}