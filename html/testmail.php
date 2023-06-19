<?php
$to = "lololertrololer@gmail.com";
$subject = "Test email";
$message = "This is a test email.";
$headers = "From: el pepe";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully";
} else {
    echo "Failed to send email";
}
?>
