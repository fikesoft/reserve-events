<?php
require_once '../../backend/controllers/init.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $comment = $_POST["comment"] ?? "";

    $to = "randomeventsinfo@gmail.com";
    $subject = "New contact message from your website";

    $body = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .container {
                max-width: 650px;
                margin: 30px auto;
                padding: 40px;
                border: 1px solid #e0e0e0;
            }
            h2 {
                color: #4d194d;
                border-bottom: 3px solid #B44CB4;
            }
            .info-line {
                padding: 10px 0;
                border-bottom: 1px dashed #ddd;
            }
            .comment-section {
                margin-top: 30px;
                padding: 20px;
                border: 1px solid #d4d4d4;
                background-color: #f9f9f9;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>New Contact Message</h2>
            <div class="info-line"><strong>Name:</strong> <span>' . htmlspecialchars($name) . '</span></div>
            <div class="info-line"><strong>Email:</strong> <span>' . htmlspecialchars($email) . '</span></div>';
    if (!empty($phone)) {
        $body .= '<div class="info-line"><strong>Phone number:</strong> <span>' . htmlspecialchars($phone) . '</span></div>';
    }
    $body .= '<div class="comment-section">
                <p><strong>Message:</strong></p>
                <p>' . nl2br(htmlspecialchars($comment)) . '</p>
            </div>
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