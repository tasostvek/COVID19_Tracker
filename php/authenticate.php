<?php
	session_start();
	require_once("config.php");

	//Get data from web: Acode + Email
	$Email = $_GET["Email"];
	$Acode = $_GET["Acode"];
	print "Data off web ($Email)($Acode) <br>";

	//Connect to database
	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if(!$con){
		print "Database connect failed: ".mysqli_connect($con);
		$_SESSION["Message"] = "Database connect failed: ".mysqli_connect($con);
		$_SESSION["RegState"] = -1;
        header("location:../index.html");
		exit();
	}
	print "Database connected <br>";

	//Build a "select" query
	$query = "select * from Users where Acode='$Acode' and Email='$Email'";


	//Run the selection query
	$result = mysqli_query($con, $query);


	//Check results, if not match, report error, ret
	if(!$result){
		print "Select query failed: ".mysqli_error($con);
		$_SESSION["Message"] = "Select query failed: ".mysqli_error($con);
        //echo json_encode($_SESSION);
		$_SESSION["RegState"] = -2;
        header("location:../index.html");
		exit();
	}
	//print "Query worked <br>";

	if(mysqli_num_rows($result) != 1){
		//print "Email or acode not match. Authentication failed. ";
		$_SESSION["Message"] = "Email or acode not match. Authentication failed.";
        //echo json_encode($_SESSION);
		$_SESSION["RegState"] = -3;
        header("location:../index.html");
		exit();
	}
	print "Authentication succeeded <br>";

	//Get Adatetime
	$Adatetime = date("Y-m-d h:i:s");


	//Get a new Acode
	$Acode = rand();


	//Create an "update" query to change Acode and A datetime for email
	$query = "Update Users set Acode='$Acode', Adatetime='$Adatetime' where Email='$Email';";
	$result = mysqli_query($con, $query);

	//Check results, if not work, report error and return?
	if(!$result){
        print  "Update query failed: ".mysqli_error($con);
		$_SESSION["Message"] = "Update query failed: ".mysqli_error($con);
        //echo json_encode($_SESSION);
		$_SESSION["RegState"] = -4;
        header("location:../index.html");
		exit();
	}

	//Return reg_state = ??. Return?
	//print "Authentication success, Please set password <br>";
	$_SESSION["Message"] = "Authentication success, Please set password <br>";
    //echo json_encode($_SESSION);
	$_SESSION["RegState"] = 7;
	$_SESSION["Email"] = $Email; //Saved to set password
	header("location:../setPassword.html");
	exit();
?>
