<?php
require 'db_connect.php'; // Database connection

$message = "";
$statusColor = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($password !== $confirmPassword) {
        $message = "Passwords do not match!";
        $statusColor = "red";
    } else {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $conn->prepare("INSERT INTO users (FullName, Email, PhoneNumber, Username, PasswordHash)
                                    VALUES (:fullname, :email, :phone, :username, :passwordHash)");

            $stmt->bindParam(':fullname', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':passwordHash', $passwordHash);

            if ($stmt->execute()) {
                $message = "Signup successful! Redirecting to login...";
                $statusColor = "green";

                // 🔁 Redirect after 2 seconds
                echo "<meta http-equiv='refresh' content='2;url=login.php'>";
            } else {
                $message = "Signup failed. Please try again.";
                $statusColor = "red";
            }
        } catch (PDOException $e) {
            $message = "Database Error: " . $e->getMessage();
            $statusColor = "red";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Val Commuters</title>
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
                <h2>Create Account</h2>
                <p class="subtitle">Sign up to start your journey</p>

                <form class="signup" method="POST" action="signup.php">
                    <p>Full Name</p>
                    <div class="box-input">
                        <img class="icon" src="img/User.png" alt="User Icon">
                        <input type="text" name="fullname" placeholder="Full Name" required>
                    </div>

                    <p>Email</p>
                    <div class="box-input">
                        <img class="icon" src="img/Mail.png" alt="Mail Icon">
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>

                    <p>Phone Number</p>
                    <div class="box-input">
                        <img class="icon" src="img/Phone.png" alt="Phone Icon">
                        <input type="tel" name="phone" placeholder="+63 912 345 6789" required>
                    </div>

                    <p>Username</p>
                    <div class="box-input">
                        <img class="icon" src="img/User.png" alt="User Icon">
                        <input type="text" name="username" placeholder="Choose a username" required>
                    </div>

                        <p>Password</p>
                        <div class="box-input">  <!-- input field for creating a password -->
                            <img class="icon" src="img\Lock.png">
                            <input type="password" name="password" id="createPassword" placeholder="Create a password" required>
                            <img class="toggle-password" src="img\eyeClose.png" data-target="createPassword">
                        </div>

                        <p>Confirm Password</p>
                        <div class="box-input">  <!-- input field for confirming password -->
                            <img class="icon" src="img\Lock.png">
                            <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm your password" required>
                            <img class="toggle-password" src="img\eyeClose.png" data-target="confirmPassword">
                        </div>

                    <div class="terms-of-service">
                        <label>
                            <input type="checkbox" required>
                            I agree to the
                            <a href="#" class="terms-of-service-links">Terms & Conditions</a> and
                            <a href="#" class="terms-of-service-links">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="main-btn">Sign Up</button>

                    <p class="login-text-container">
                        Already have an account?
                        <a href="login.php" class="login-link">Login</a>
                    </p>
                </form>
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
</
body>
</html>
