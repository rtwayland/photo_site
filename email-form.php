<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'libs/PHPMailer/PHPMailerAutoload.php';
require_once 'email-credentials.php';

// Collect form inputs
$firstName = $lastName = $from = $messageContent = $phone = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $firstName = test_input($_POST['first-name']);
  $lastName = test_input($_POST['last-name']);
  $from = test_input($_POST['email']);
  $messageContent = test_input($_POST['message']);

  if (isset($_POST['phone'])) {
    $phone = test_input($_POST['phone']);
  }
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Set up email info
$to = "amandasniderphotography@yahoo.com";
$subject = 'Photo Shoot Inquiry';
$customerName = $firstName . " " . $lastName;

if (isset($phone)) {
  $message = $messageContent . "\r\n" . " - " . $customerName . " — " . $phone;
} else {
  $message = $messageContent . "\r\n" . " - " . $customerName;
}

$message = wordwrap($message, 70, "\r\n");



$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'smtp.mail.yahoo.com; smtp.gmail.com; smtp.aol.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                                             // Enable SMTP authentication
$mail->Username = $username;                                        // SMTP username
$mail->Password = $password;                                        // SMTP password
$mail->SMTPSecure = 'tls';                                          // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                                  // TCP port to connect to

$mail->setFrom($username);
$mail->addAddress($to);     // Add a recipient
$mail->addReplyTo($from);

$mail->Subject = 'Photo Shoot Inquiry';
$mail->Body    = $message;
// $mail->AltBody = $message;

if($mail->send()) {
    header("location: email-confirmation.html");
} else {
  header("location: email-failure.html");
  // echo 'Mailer Error: ' . $mail->ErrorInfo;
}

?>
