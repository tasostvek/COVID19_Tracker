<?php
    session_start();
    require_once("config.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../PHPMailer-master/src/Exception.php';
    require '../PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/src/SMTP.php';
    
    //Get data off the web
    $FirstName = $_GET["FirstName"];
    $LastName = $_GET["LastName"];
    $Email = $_GET["Email"];
    //print "Got data ($FirstName $LastName $Email) <br>";
    
    // Connect to DB
    $con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
    if(!$con){
        $_SESSION["RegState"] = -1;
        //print "Database connection failed: ".mysqli_error($con);
        $_SESSION["Message"] = "Database connection failed: "
            .mysqli_error($con);
        echo json_encode($_SESSION);
        //header("location:../index.php");
        exit();
    }
    //print "Database connected <br>";
    
    //Get new Acode
    $Acode = rand();
    
    //Get date and times
    $Rdatetime = date("Y-m-d h:i:s");
    //print "Got data ($FirstName $LastName $Email $Acode $Rdatetime) <br>";

    //Make query to database
    $query = "insert into Users (FirstName, LastName, Email, Acode, Rdatetime, Status)".
        "values ('$FirstName', '$LastName', '$Email', '$Acode', '$Rdatetime', 1)";
    $result = mysqli_query($con, $query);
    if(!$result){
        $_SESSION["RegState"] = -2;
        //print "Query failed: ".mysqli_error($con);
        $_SESSION["Message"] = "Query connection failed: "
            .mysqli_error($con);
        echo json_encode($_SESSION);
        //header("location:../index.php");
        exit();
    }
    //print "Registration worked! <br>";

    // Build email to send
    // Build the PHPMailer 
    $mail= new PHPMailer(true);
    try { 
        $mail->SMTPDebug = 0; //2: Wants to see all errors
        $mail->IsSMTP();
        $mail->Host="smtp.gmail.com";
        $mail->SMTPAuth=true;
        $mail->Username="cis105223053238@gmail.com";
        $mail->Password = 'g+N3NmtkZWe]m8"M';
        $mail->SMTPSecure = "ssl";
        $mail->Port=465;
        $mail->SMTPKeepAlive = true;
        $mail->Mailer = "smtp";
        $mail->setFrom("tuf91473@temple.edu", "Tasos Tzivekis");
        $mail->addReplyTo("tuf91473@temple.edu", "Tasos Tzivekis");
        $msg = "Please click the link to complete registration process:".
            "http://cis-linux2.temple.edu/~tuf91473/2305/final/php/authenticate.php?".
            "Email=$Email&Acode=$Acode";
        $mail->addAddress($Email,"$FirstName $LastName");
        $mail->Subject = "Welcome to CV Tracker!";
        $mail->Body = $msg;
        $mail->send();
        //print "Email sent ... <br>";
        $_SESSION["RegState"] = 6;
        $_SESSION["Message"] = "Email sent!";
        echo json_encode($_SESSION);
        //header("location:../index.php");
        exit();
    } catch (phpmailerException $e) {
        $_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
        $_SESSION["RegState"] = -4;
        echo json_encode($_SESSION);
        //print "Mail send failed: ".$e->errorMessage;
    }
    //header("location:../index.php");
    exit();
    
?>
