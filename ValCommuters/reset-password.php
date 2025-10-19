<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password | Val Commuters</title>
        <link rel="stylesheet" href="style.css" />
    </head>

    <body>
		<div class="container">  <!-- outer wrapper -->
			<div class="card">  <!-- inner wrapper, content area -->
				<div class="container-top"> <!-- Logo and Name -->
                    <div class="logo">
                        <img src="img/Val Commuters Logo.png">
                        <h1>VAL COMMUTERS</h1>
                    </div>
                    <p class="tagline">Your travel companion</p>
                </div>

				<div class="container-bottom">  <!-- Main Content -->
                    <h2>Reset Password</h2>
                    <p class="subtitle">Create a new password to continue your journey</p>

                    <form class="reset" method="POST" action="update_password.php">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                        <p>New Password</p>
                        <div class="box-input">  <!-- input field for New Password -->
                            <img class="icon" src="img\Lock.png">
                            <input type="password" name="newPassword" id="newPassword" placeholder="Create new password" required>
                            <img class="toggle-password" src="img\eyeClose.png" data-target="newPassword">
                        </div>

                        <p>Confirm New Password</p>
                        <div class="box-input">  <!-- input field for Confirming New Password -->
                            <img class="icon" src="img\Lock.png">
                            <input type="password" name="ConfirmNewPassword" id="confirmPassword" placeholder="Confirm new password" required>
                            <img class="toggle-password" src="img\eyeClose.png" data-target="confirmPassword">
                        </div>

                        <button type="submit" class="main-btn">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>