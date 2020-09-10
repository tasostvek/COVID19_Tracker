<?php
	session_start();
    require_once("config.php");
    
    //Get data off the web
    $Email = $_GET["Email"];
    $FirstName = $_GET["FirstName"];
    $LastName = $_GET["LastName"];
    //print "Webdata ($Email) ($FirstName) ($LastName) <br>";
    
    // Connect to DB
    $con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
    if(!$con){
        $_SESSION["RegState"] = -1;
        $_SESSION["Message"] = "Database connection failed: ".mysqli_error($con);
        echo json_encode($_SESSION);
        //header("location:../index.php");
        exit();
    }
    //print "Database connected <br>";
    //Get Acode
    $Acode = rand();
    
    //Get Rdatetime
    $Rdatettime = datte("Y-m-d h:i:s");
    
    //Build INSERT query (FirstName, LastName, Email)
    
?>
