<?php

    require("class.phpmailer.php");
    $from = $_POST["email"];
    $fullname = $_POST["full_name"];
    $subject=$_POST["subject"];
    $message=$_POST["message"];
    $PHPMailer = new PHPMailer();
    $emailcontent = "Name:".$fullname."<br>Email:".$from."<br>Subject:".$subject."<br>Subject".$message;
    $PHPMailer->From = $from;
    $PHPMailer->FromName = $_POST["full_name"];
	//change where to mail sent 
    $PHPMailer->AddAddress('abduravoof@gmail.com');
    $PHPMailer->Subject = "Fedrex Contact";
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