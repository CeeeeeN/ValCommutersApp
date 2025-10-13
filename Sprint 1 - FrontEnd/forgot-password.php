<?
include("db_connect.php");
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Forgot Password | Val Commuters</title>
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

				<div class="container-bottom"> <!-- Main Content -->
					<h2>Forgot Password</h2>
					<p class="subtitle">Forgot your password? Let’s get you back on track</p>

					<form class="forgot" method="POST" action="forgot_password_backend.php">
						<p>Email</p> 
							<div class="box-input"> <!-- input field for requesting email address -->
								<img class="icon" src="img\Mail.png">
								<input type="email" name="email" placeholder="Enter email address" required>
							</div>

						<button type="submit" class="main-btn">Request reset link</button>
					</form>

                    <p class="login-text-container"><a href="login.html" class="back-login">Back to Login</a></p>
				</div>
			</div>
		</div>
		<script src="script.js"></script>
	</body>
</html>