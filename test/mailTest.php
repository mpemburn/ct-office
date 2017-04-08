<?php

$file_name = "mark_pemburn.pdf";
$file_path = "../../data/";

$to =	 'mark@pemburn.com';
$subject = "Your Contract with Century Termite and Pest";
$bound_text =	"ct-office";
$bound =	"--".$bound_text."\r\n";
$bound_last =	"--".$bound_text."--\r\n";
 	 
$headers =	"From: support@centurytermite.com\r\n";
$headers .=	"MIME-Version: 1.0\r\n"	. "Content-Type: multipart/mixed; boundary=\"$bound_text\"";
 	 
$message = "";
$message .=	"If you can see this MIME, then your client doesn't accept MIME types.\r\n" . $bound;
 	 
$message .=	"Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
 	."Content-Transfer-Encoding: 7bit\r\n\r\n"
 	."Dear Mr. Nunn,\r\n<br /><br />"
 	."Here is a copy of your signed contract with Century Termite and Pest.  Thank You! \r\n\r\n<br /><br />"
 	."Regards,\r\n<br />"
 	."The Century Termite and Pest Team\r\n"
 	.$bound;
 	 
//$file =	file_get_contents($file_path . $file_name);
 	 
$message .=	"Content-Type: application/pdf; name=\"$file_name\"\r\n"
 	."Content-Transfer-Encoding: base64\r\n"
 	."Content-disposition: attachment; file=\"$file_name\"\r\n"
 	."\r\n"
 	.$bound_last;

if (mail($to, $subject, $message, $headers)) 
{
     echo 'MAIL SENT'; 
} 
else 
{ 
     echo 'MAIL FAILED';
}

//*** END OF FILE mailTest.php