<?php
require 'db_connect.php';

try {
    // Example data to insert manually
    $fullName = "Test User";
    $email = "testuser@example.com";
    $phone = "09123456789";
    $username = "testuser";
    $passwordHash = password_hash("password123", PASSWORD_BCRYPT);

    // Prepare insert query
    $stmt = $conn->prepare("INSERT INTO users 
        (FullName, Email, PasswordHash, PhoneNumber, Username, AccountCreatedDate, Status)
        VALUES (:fullname, :email, :passwordHash, :phone, :username, NOW(), 'Active')");

    // Bind parameters
    $stmt->bindParam(':fullname', $fullName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':passwordHash', $passwordHash);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':username', $username);

    // Execute query
    if ($stmt->execute()) {
        echo "<h3>✅ Test user inserted successfully!</h3>";
    } else {
        echo "<h3>❌ Insert failed!</h3>";
        print_r($stmt->errorInfo());
    }

} catch (PDOException $e) {
    echo "<h3>❌ Database Error:</h3> " . $e->getMessage();
}
?>
