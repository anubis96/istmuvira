<?php

$name = $_POST['name'];
$visitor_email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$email_from = 'info@yourbrowser.com';
$email_subject = 'New Form Submission';
$email_body = "Nom: $name.\n".
                "Email: $visitor_email.\n".
                "Sujet: $subject.\n".
                "Message: $message.\n";

$to = 'moiserukabo@gmail.com';
$headers = "De: $email_from\r\n";
$headers .= "Reply-To: $visitor_email\r\n";

mail($to, $email_subject, $email_body, $headers);

header("Location: contact.html")

?>