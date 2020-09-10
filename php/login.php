<?php
	session_start();
	require_once("config.php"); 

	//Get Data off the web
	$Email = $_POST["Email"];
	$Password = md5($_POST["Password"]);
	$RememberMe = $_POST["RememberMe"];
	// print "Web data ($Email) ($Password) ($RememberMe) <br>";
	// $RememberMe == 'remember-me' if clicked. Otherwise, it is ''
	//Connect to DB
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if(!con){
		$_SESSION["RegState"] = -1;
		//print "Database connection failed: ".mysqli_error($con);
		$_SESSION["Message"] = "Database connection failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		// header("location:../index.php");
		exit();
	}
	// print "Database connected <br>";

	$query = "Select * from Users where Email='$Email' and Password='$Password';";
	$result = mysqli_query($con, $query);
	if(!$result){
		$_SESSION["RegState"] = -2;
		// print "Login query failed: ".mysqli_error($con);
		$_SESSION["Message"] = "Login query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		// header("location:../index.php");
		exit();
	}
	//print "Query worked! <br>";
	if(mysqli_num_rows($result) != 1){
		$_SESSION["RegState"] = -7;
		$_SESSION["Message"] = "Either email or password not match. Try again.";
		echo json_encode($_SESSION);
		// header("location:../index.php");
		exit();
	}
	//Now the user is authenticated and logged in
	$_SESSION["RegState"] = 4;
	$_SESSION["Message"] = "Logged in";
	echo json_encode($_SESSION);
	// header("location:../timertab.php");
	exit();
?>
