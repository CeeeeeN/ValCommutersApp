<?php
require 'db_connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $fullName = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
        exit;
    }

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
            echo "Signup successful!";
        } else {
            print_r($stmt->errorInfo());
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
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
</head>
<body>
    <div class="container">
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

                <form class="signup" method="POST" action="">
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
                    <div class="box-input">
                        <img class="icon" src="img/Lock.png" alt="Lock Icon">
                        <input type="password" id="createPassword" name="password" placeholder="Create a password" required>
                        <img class="toggle-password" src="img/eyeClose.png" data-target="createPassword" alt="Toggle Password">
                    </div>

                    <p>Confirm Password</p>
                    <div class="box-input">
                        <img class="icon" src="img/Lock.png" alt="Lock Icon">
                        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required>
                        <img class="toggle-password" src="img/eyeClose.png" data-target="confirmPassword" alt="Toggle Password">
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
                        <a href="login.html" class="login-link">Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
