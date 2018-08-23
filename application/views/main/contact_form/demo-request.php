<?php

    require("class.phpmailer.php");
    $from = $_POST["email"];
    $fullname = $_POST["full_name"];
    $mobile=$_POST["mobile"];
    $age=$_POST["age"];
    $date=$_POST["date"];
    $service=$_POST["service"];
    $PHPMailer = new PHPMailer();
    $emailcontent = "Name:".$fullname."<br>Mobile:".$mobile."<br>Email:".$from."<br>Age:".$age."<br>Date".$date."<br>Service".$service;
    $PHPMailer->From = $from;
    $PHPMailer->FromName = $_POST["full_name"];
	//change where to mail sent 
    $PHPMailer->AddAddress('abduravoof@gmail.com');
    $PHPMailer->Subject = "Pentafin Booking";
    $PHPMailer->MsgHTML($emailcontent);
    if ($PHPMailer->Send()) {
        $success=true;
    } else {
        $success=false;
    }
    $json_data = array('success' => $success);
    echo json_encode($json_data);
    exit();

?>