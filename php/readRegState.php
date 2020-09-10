<?php
	session_start();
	if(!isset($_SESSION["RegState"])) $_SESSION["RegState"]=0;
	$myjson->name="RegState";
	$myjson->value=$_SESSION["RegState"];
	echo json_encode($myjson);
	exit();
?>