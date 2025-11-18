<?php

header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer files
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// Only allow POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

// Collect form data
$name    = trim($_POST['name']);
$email   = trim($_POST['email']);
$subject = trim($_POST['subject']);
$message = trim($_POST['message']);

// Validation
if (!$name || !$email || !$subject || !$message) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Invalid email address."]);
    exit;
}

$mail = new PHPMailer(true);

try {
    // SMTP Settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;

    // Gmail login
    $mail->Username   = 'ahmedmush1234@gmail.com';       // <-- CHANGE THIS
    $mail->Password   = 'neru drop xjdn exoa';          // <-- CHANGE THIS (App Password)

    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Email headers
    $mail->setFrom($email, $name);
    $mail->addAddress('your-email@gmail.com');        // <-- RECEIVING EMAIL (Same as above)

    // Email content
    $mail->Subject = $subject;
    $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    // Send email
    $mail->send();

    echo json_encode(["status" => "success", "message" => "Your message has been sent. Thank you!"]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Mailer Error: {$mail->ErrorInfo}"]);
}
?>
