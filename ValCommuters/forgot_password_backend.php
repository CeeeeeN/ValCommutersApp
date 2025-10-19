<?php
session_start(); // Assuming sessions are used for feedback messages

include("db_connect.php");

// Validate and sanitize email
if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
    $_SESSION['error'] = "Email is required.";
    header("Location: forgot-password.php");
    exit();
}

$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
    header("Location: forgot-password.php");
    exit();
}

// Check if user exists using prepared statement
$sql = $conn->prepare("SELECT * FROM users WHERE Email = ?");
$sql->execute([$email]);
$row = $sql->fetch(PDO::FETCH_ASSOC);

if ($row) {
    // Generate secure token
    $token = bin2hex(random_bytes(32)); // Increased length for security

    // Update the user's reset_token (assumes reset_token column exists)
    $update_sql = $conn->prepare("UPDATE users SET reset_token = ? WHERE Email = ?");
    $update_sql->execute([$token, $email]);

    // Email contents
    $reset_link = "http://localhost/ValCommuters/reset-password.php?token=" . urlencode($token);
    $message = 'Click the link below to reset your password: <br/> <a href="' . $reset_link . '">Click Here</a>';
    $subject = 'ValCommuters Password Reset';

    // Email headers for HTML content
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: noreply@valcommuters.com" . "\r\n"; // Set a proper from address

    $EmailSent = mail($email, $subject, $message, $headers);

    if ($EmailSent) {
        $_SESSION['success'] = "Password reset email sent. Check your inbox.";
        header("Location: login.php");
    } else {
        $_SESSION['error'] = "Failed to send email. Please try again.";
        header("Location: forgot-password.php");
    }
} else {
    // Don't reveal if email exists for security
    $_SESSION['success'] = "If the email exists, a reset link has been sent.";
    header("Location: login.php");
}

exit();
?>
