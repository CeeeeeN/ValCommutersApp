<?php
include("db_connect.php");

if(isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("Select * from password_reset_tokens where token=$token");
    $conn->exec($stmt);
    $row = $stmt->fetch();

    if($row) {

        $NewPass = isset($_POST['newPassword']);
        $ConfirmNewPass = isset($_POST['ConfirmNewPassword']);

        if ($NewPass == $ConfirmNewPass) {
            $HashedNewPass = password_hash($NewPass, PASSWORD_DEFAULT);
            $UpdStmt = $conn->prepare("UPDATE users SET PasswordHash='$HashedNewPass', reset_token=NULL where token='$token'");
            $conn->exec($UpdStmt);

            $conn = null;
            header("Location: login.html");
        }

    }

} else {
    $token = null;
    echo "Error: No Token Found";
    die;
}
?>