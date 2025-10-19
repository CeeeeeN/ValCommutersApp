<?php
require 'db_connect.php';
session_start();

$message = "";
$statusColor = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $loginInput = $_POST['login_input'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        // Allow login using Email, PhoneNumber, or Username
        $stmt = $conn->prepare("SELECT * FROM users WHERE Email = :input OR PhoneNumber = :input OR Username = :input LIMIT 1");
        $stmt->bindParam(':input', $loginInput);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['PasswordHash'])) {
            // Correct credentials — start session
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['fullname'] = $user['FullName'];

            $message = "Login successful! Redirecting to home...";
            $statusColor = "green";

            //  Redirect to home.html after 2 seconds
            echo "<meta http-equiv='refresh' content='2;url=home.html'>";
        } else {
            $message = "Invalid email/phone/username or password.";
            $statusColor = "red";
        }
    } catch (PDOException $e) {
        $message = "Database Error: " . $e->getMessage();
        $statusColor = "red";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Val Commuters</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        .debug-message {
            margin: 20px auto;
            padding: 12px 18px;
            border-radius: 8px;
            width: fit-content;
            font-family: Arial, sans-serif;
            color: white;
            font-weight: bold;
            background-color: <?php echo $statusColor ?: 'gray'; ?>;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($message)): ?>
            <div class="debug-message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="container-top">
                <div class="logo">
                    <img src="img/Val Commuters Logo.png" alt="Val Commuters Logo">
                    <h1>VAL COMMUTERS</h1>
                </div>
                <p class="tagline">Your travel companion</p>
            </div>

            <div class="container-bottom">
                <h2>Welcome Back</h2>
                <p class="subtitle">Login to continue your journey</p>

                <!-- Form now points to this PHP file -->
                <form class="login" method="POST" action="login.php">
                    <p>Email / Phone / Username</p>
                    <div class="box-input">
                        <img class="icon" src="img/Mail.png">
                        <input type="text" name="login_input" placeholder="Enter your email, phone, or username" required>
                    </div>

                    <p>Password</p>
                    <div class="box-input">
                        <img class="icon" src="img/Lock.png">
                        <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required>
                        <img class="toggle-password" src="img/eyeClose.png" data-target="loginPassword">
                    </div>

                    <div class="login-remember">
                        <label>
                            <input type="checkbox"> Remember me
                        </label>
                        <a href="forgot-password.php" class="forgot-password-link">Forgot Password?</a>
                    </div>

                    <button type="submit" class="main-btn">Login</button>
                </form>

                <p class="signup-text-container">
                    Don't have an account? <a href="signup.php" class="signup-link">Sign Up</a>
                </p>
            </div>
        </div>
    </div>
	<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleIcons = document.querySelectorAll('.toggle-password');

    toggleIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            const targetId = icon.dataset.target;
            const passwordInput = document.getElementById(targetId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.src = 'img/eyeOpen.png'; // Show open eye
            } else {
                passwordInput.type = 'password';
                icon.src = 'img/eyeClose.png'; // Show closed eye
            }
        });
    });
});
</script>
</body>
</html>
