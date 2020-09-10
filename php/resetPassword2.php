<?php
	session_start();
	require_once("config.php");

	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../PHPMailer-master/src/Exception.php';
    require '../PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/src/SMTP.php';

	// Get data off the web: ?? How many pieces? Get or Post? MD5?
	$Email = $_GET["Email"];
	
	//Connect to DB
	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if(!$con){
		//print "Database connect failed: ".mysqli_connect($con);
		$_SESSION["Message"] = "Database connect failed: ".mysqli_connect($con);
		$_SESSION["RegState"] = -1;
        echo json_encode($_SESSION);
		exit();
	}
	//print "Database connected <br>";

	//Build query to verify if $Email in the database
	//"select * from Users where Email = '$Email';""
	$query = "Select * from Users where Email='$Email';";
	$result = mysqli_query($con, $query);
	if(!$result){
		//print "Select query failed: ".mysqli_error($con);
		$_SESSION["Message"] = "Select query failed: ".mysqli_error($con);
		$_SESSION["RegState"] = -2;
        echo json_encode($_SESSION);
		exit();
	}
	//print "Email in database <br>";

	//Verify if mysqli_num_rows($results) == 1?? If not, report failure
	if(mysqli_num_rows($result) != 1){
		print "Email or acode not match. Authentication failed. ";
		$_SESSION["Message"] = "Email or acode not match. Authentication failed.";
		$_SESSION["RegState"] = -3;
        echo json_encode($_SESSION);
		exit();
	}
	//print "Authentication succeeded! <br>";

	//$Acode = rand();
	$Acode = rand();

	//Update DB: Update Users set Acode = '$Acode' where Email = '$Email';
	$query = "Update Users set Acode = '$Acode' where Email = '$Email';";
	$result = mysqli_query($con, $query);

	//Check for $result, report error if failure
	if(!$result){
		//print  "Update query failed: ".mysqli_error($con);
		$_SESSION["Message"] = "Update query failed: ".mysqli_error($con);
		$_SESSION["RegState"] = -4;
        echo json_encode($_SESSION);
		exit();
	}
	//  print "Update query succeeded <br>";

	//Build email message to allow the user to reset password
	//Take the register2.php code segment for this part
	$mail= new PHPMailer(true);
    try { 
        $mail->SMTPDebug = 0; // Wants to see all errors
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
        $msg = "Please click the link to reset your password:".
            "http://cis-linux2.temple.edu/~tuf91473/2305/final/php/authenticate.php?".
            "Email=$Email&Acode=$Acode";
        $mail->addAddress($Email,"$FirstName $LastName");
        $mail->Subject = "Reset Password for CV Tracker";
        $mail->Body = $msg;
        $mail->send();
        //print "Reset password email sent ... <br>";
        $_SESSION["RegState"] = 6;
        $_SESSION["Message"] = "Reset password email sent.";
        echo json_encode($_SESSION);
        //header("location:../index.php");
        exit();
    } catch (phpmailerException $e) {
        $_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
        $_SESSION["RegState"] = -4;
        //print "Mail send failed: ".$e->errorMessage;
        echo json_encode($_SESSION);
    }
    //header("location:../index.php");
    exit();

?>
