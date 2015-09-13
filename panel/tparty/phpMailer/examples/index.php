<?php
/**
 * This example shows making an SMTP connection with authentication.
 */
 
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');
 
//wajib ada karena ini digunakan untuk mengeload plugin PHPMailernya
require 'PHPMailerAutoload.php';
 
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
//pilih 0 jika siap digunakan, pilihan 2 merupakan debug mode, nanti bakalan akan tampil log pengiriman email.
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
 
//Set the hostname of the mail server
//untuk gmail bisa menggunakan alamat url berikut :
$mail->Host = "ssl://smtp.googlemail.com";
//Set the SMTP port number - likely to be 25, 465 or 587
//karena dalam tutorial ini hostnya menggunakan ssl, maka portnya 465 (untuk smtp yang lain silakan sesuaikan, biasanya di pengaturan e-mailnya diberikan info mengenai hal ini)
$mail->Port = 465;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
//isikan username kamu, harus valid sesuai dengan username yang ada di google
$mail->Username = "indra.ramadha1993@gmail.com";
//Password to use for SMTP authentication
$mail->Password = "Laknadh08031993";
 
//Set who the message is to be sent from
$mail->setFrom('yourname@example.com', 'Beasiswa Online UNINUS');
//Set an alternative reply-to address
$mail->addReplyTo('replyto@example.com', 'Beasiswa Online UNINUS');
 
//Set who the message is to be sent to
$mail->addAddress('indra08031993@gmail.com', 'Indra');
//Set the subject line
$mail->Subject = 'Reset Password';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//bisa juga langsung dituliskan pesannya 
$mail->msgHTML("<h1>tes2</h1>");
 
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
 
//Attach an image file
//jika ingin attach file, jika tidak ya di hapus saja
//$mail->addAttachment('images/phpmailer_mini.png');
 
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}