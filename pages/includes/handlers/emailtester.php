<?php

session_start();

if(isset($_SESSION['username'])){
	//receipient
	$to = 'ict@igsl.asia';

	//subject
	$subject = 'Supplies Request';

	//message
	$message = 'I have made a supplies request. Item(s) in this request can be found at Request Supplies section of the Outlet Module.';

	//headers
    $headers .= 'From: SAMS IGSL <no-reply@igsl.online>'."\r\n";
    $headers .= 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/plain; charset=iso-8859-1'."\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: smail-PHP ".phpversion()."\r\n";
	
    $returnpath = '-f ict@igsl.asia';

	//send mail
	mail($to, $subject, $message, $headers, $returnpath);
	echo "A notification email has been sent!";

}