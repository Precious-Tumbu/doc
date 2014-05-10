<?php

//require_once("settings.php");

class Email {
	
	public function sendMail($email, $subject, $message, $from = EMAIL_SYSTEM) {
		mail($email , $subject, $message, "From: \"Social Music Guru\" <$from>\r\n". 
		"Reply-To: ".EMAIL_NOTIFY."\r\n" . 
		"X-Mailer: PHP/" . phpversion());
	}
}

?>