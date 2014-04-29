<?php
	require(dirname(__FILE__) . "/config.php");
	$host = $config['db']['host'];
	$username = $config['db']['username'];
	$password = $config['db']['password'];
	$database = $config['db']['name'];
	
	$mysqli = new mysqli($host, $username, $password, $database);