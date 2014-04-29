<?php 
session_start();
$_SESSION[$_POST['name']] = $_POST['value'];
