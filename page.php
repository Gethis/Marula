<?php
require "pages/main.php";
head();
title($_GET['id']);
nav();

$content = content($_GET['id']);
if($content != "0 con"){
	echo $content; 
} elseif($content == "0 con"){
	not_found();
}

footer();