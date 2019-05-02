<?php

include('framework/init.php');

if ( isset( $_REQUEST ) && !empty( $_REQUEST ) ) {
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $message = $_REQUEST['message'];
}

$message_body  = '<html>';
$message_body .= '<head>';
$message_body .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
$message_body .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
$message_body .= '<title>King Mharkley F. Baga Website</title>';
$message_body .= '</head>';
$message_body .= '<body>';
$message_body .= '<div>';
$message_body .= '<h3>Name : '.$name.'</h3>';
$message_body .= '<p>Email : '.$email.'</p>';
$message_body .= '<p>Message Body: <br>'.$message.'</p>';
$message_body .= '</div>';
$message_body .= '</body>';
$message_body .= '</html>';




$mail = new PHPMailer;
$mail->FromName = $name;
$mail->isHTML(true);
$mail->Subject = 'CONTACT FORM @ kingmharkleybaga.com';
$mail->addCustomHeader('X-Nonspam', 'Whitelist');
$mail->Body = $message_body;
            
if(filter_var('kingkeiem@gmail.com', FILTER_VALIDATE_EMAIL)){

	$mail->addAddress('kingkeiem@gmail.com', $name);

	if(!$mail->send()){
                   
       echo 'Message could not be sent. Mail Error: '.$mail->ErrorInfo.' Please try again.';
                   
   } else {
        
        echo 'Success!';
   }
}


?>