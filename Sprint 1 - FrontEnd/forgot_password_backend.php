<?php
include("db_connect.php");

$email = isset($_POST['email']);

$sql = $conn->prepare("Select * from Users where Email = $email");
$sql->execute();
$row = $sql->fetch();

if ($row) {
    //show message

    //generate Token
    $token = bin2hex(random_bytes(16));

    //insert token and email into table
    $insert_token = "Insert into users (reset_token)
    Values ('$token')";
    $conn->exec($insert_token);

    //Email Contents
    $reset_link = "http://localhost/ValCommuters/reset-password.php?token=" . $token;
    $message = 'Click the link below to reset your password: <br/> <a href="' . $reset_link . '"> Click Here </a>';
    $subject = 'ValCommuters Password Reset';
    $EmailSent = mail($email, $subject, $message);

    if ($EmailSent) {
        header("Location: login.html");
    }
}

?>