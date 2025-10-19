<?php
session_start(); // Assuming sessions for feedback

include("db_connect.php");

if (isset($_POST['token']) && !empty($_POST['token'])) {
    $token = trim($_POST['token']);

    // Validate token using prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPass = $_POST['newPassword'] ?? '';
            $confirmNewPass = $_POST['ConfirmNewPassword'] ?? '';

            // Validate passwords
            if (empty($newPass) || empty($confirmNewPass)) {
                $_SESSION['error'] = "Both password fields are required.";
                header("Location: reset-password.php?token=" . urlencode($token));
                exit();
            }

            if (strlen($newPass) < 8) {
                $_SESSION['error'] = "Password must be at least 8 characters long.";
                header("Location: reset-password.php?token=" . urlencode($token));
                exit();
            }

            if ($newPass !== $confirmNewPass) {
                $_SESSION['error'] = "Passwords do not match.";
                header("Location: reset-password.php?token=" . urlencode($token));
                exit();
            }

            // Hash the new password
            $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);

            // Update password and clear token
            $updStmt = $conn->prepare("UPDATE users SET PasswordHash = ?, reset_token = NULL WHERE reset_token = ?");
            if ($updStmt->execute([$hashedNewPass, $token])) {
                $_SESSION['success'] = "Password updated successfully. Please log in.";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error'] = "Failed to update password. Please try again.";
                header("Location: reset-password.php?token=" . urlencode($token));
                exit();
            }
        } else {
            // Show form if not POST
            // Assuming reset-password.php handles the form display
            header("Location: reset-password.php?token=" . urlencode($token));
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid or expired token.";
        header("Location: forgot-password.php");
        exit();
    }
} else {
    $_SESSION['error'] = "No token provided.";
    header("Location: forgot-password.php");
    exit();
}

$conn = null;
?>
