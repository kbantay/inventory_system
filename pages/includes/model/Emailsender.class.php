<?php

class Emailsender {

   public function sendemail($receiver, $subject, $message){
    $headers = 'From: SAMS IGSL <no-reply@igsl.online>'."\r\n";
    $headers .= 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/plain; charset=iso-8859-1'."\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: smail-PHP ".phpversion()."\r\n";
    $returnpath = '-f ict@igsl.asia';

	mail($receiver, $subject, $message, $headers, $returnpath);
   }

}