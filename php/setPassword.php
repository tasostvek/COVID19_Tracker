<?php
    session_start();
    require_once("config.php");
    
    //get data off the web
    $Password = md5($_POST["Password"]);
    $Email = $_SESSION["Email"];
    
    $con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
    if(!$con)
    {
        $_SESSION["RegState"] = -1;
        $_SESSION["Message"] = "Database connecton failed: " 
            .mysqli_error($con);
        echo json_encode($_SESSION);
        //header("location:../index.php");
        exit();
    }
    
    //print "Database connected <br>";
    

    //set Password -> update query
    $query = "Update Users set Password='$Password' where Email='$Email';";
    $result = mysqli_query($con, $query);
    if(!$result)
    {
        $_SESSION["RegState"] = -5;
        //print "Update query failed: ".mysqli_error($con);
        $_SESSION["Message"]= "Insert query failed: ".mysqli_error($con);
        echo json_encode($_SESSION);
        //header("location:../index.php");
        exit();
    }
    //State password set successfully
    $_SESSION["Message"] = "Password set! <br> Please log in";
    $_SESSION["RegState"] = 6;
    echo json_encode($_SESSION);
    //header("location:../index.php");
    exit();
?>
