<?php
session_start();
if (isset($_SESSION['username'])) {
	header('Location: dashboard');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'templates/header.php' ?>
	<title>Login - Team Management System</title>
	<link rel="stylesheet" href="assets/css/login.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">

<body class="login">
	<?php include 'templates/loading_screen.php' ?>
	<img class="wave" src="assets/img/wave.png">
	<div class="login-container">

	<div class="d-flex justify-content-center mt-5">
		<a routerLink="/" class="logo d-flex align-items-center mb-3 w-auto">
			<img src="assets/img/gc-logo.png" alt="">

			<img src="public/assets/img/Final LOGO (2) (1).png" alt="">

			<img src="public/assets/img/20by20_Logo_admin_version2 (2) (3).png" alt="">

		</a>
	</div>
	

	<div class="d-flex justify-content-center mt-5>
		<?php if (isset($_SESSION['message'])) : ?>
			<div class="alert alert-<?= $_SESSION['success']; ?> <?= $_SESSION['success'] == 'danger' ? 'bg-danger text-light' : null ?>" role="alert">
				<?= $_SESSION['message']; ?>
			</div>
			<?php unset($_SESSION['message']); ?>
		<?php endif ?>

	<div class="d-flex justify-content-center mt-5">
		<div class="login-form">
			<form method="POST" action="model/login.php">
			<h1 class="text-center">Log-In to Your Account</h1>
		<p class="text-center">Enter your username & password to login</p>
		<div style="max-width: 300px; margin: auto;">
					<div class="form-group form-floating-label">
						<input id="username" name="username" type="text" class="form-control input-border-bottom" required>
						<label for="username" class="placeholder">Username</label>
					</div>
					<div class="form-group form-floating-label">
						<input id="password" name="password" type="password" class="form-control input-border-bottom" required>
						<label for="password" class="placeholder">Password</label>
						<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					</div>
					<center>
						<div class="form-action mb-2 mt-4">
							<button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
						</div>
					</center>
				</div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="assets/js/main.js"></script>
</div>


	<?php include 'templates/footer.php' ?>

</body>

</html>




	