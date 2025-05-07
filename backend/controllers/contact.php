<?php
require_once '../../backend/controllers/init.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $comment = strip_tags(trim($_POST["comment"]));

    $to = "randomeventsinfo@gmail.com";
    $subject = "New contact message from your website";

    $body = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body { font-family: sans-serif; line-height: 1.6; }
            .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0; border-radius: 5px; }
            h2 { color: #333; margin-top: 0; }
            p { margin-bottom: 10px; }
            strong { font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>New Contact Message</h2>
            <p><strong>Name:</strong> ' . htmlspecialchars($name) . '</p>
            <p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>';
    if (!empty($phone)) {
        $body .= '<p><strong>Phone Number:</strong> ' . htmlspecialchars($phone) . '</p>';
    }
    $body .= '<p><strong>Comment:</strong><br>' . nl2br(htmlspecialchars($comment)) . '</p>
        </div>
    </body>
    </html>';

    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        $_SESSION['message'] = "Message sent successfully. We will reply as soon as possible.";
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = "There was a problem sending your message. Please try again later.";
        $_SESSION['message_type'] = 'error';
    }

    header("Location: ../../frontend/static/contact.php");
    exit;
}
?>