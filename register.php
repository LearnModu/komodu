<?php

session_start();
require_once "config/db.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
	$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	if (strlen($username) < 3) $errors[] = "Username must be at least 3 characters long";
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
	if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters long";
	if ($password !== $confirm_password) $errors[] = "Passwords do not match";

	if (empty($errors)) {
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		
		$check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
		$check->bind_param("ss", $email, $username);
		$check->execute();
		
		if ($check->get_result()->num_rows > 0) {
			$errors[] = "username/email already exists";
		} else {
			$stmt = $conn->prepare("INSERT INTO users (username, email, passhash) VALUES (?, ?, ?)");
			$stmt->bind_param("sss", $username, $email, $password_hash);
			
			if ($stmt->execute()) {
				$_SESSION['user_id'] = $stmt->insert_id;
				$_SESSION['username'] = $username;
				$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
				header("Location: dashboard.php");
				exit;
			} else {
				$errors[] = "registration failed!";
			}
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register - Komodu</title>
	<link rel="stylesheet" href="./static/styles.css">
</head>
<body>
	<nav class="nav">
		<ul class="nav-list">
			<li><a href="/" class="nav-link">Home</a></li>
			<li><a href="https://learnmodu.org" target="_blank" class="nav-link">LearnModu</a></li>
		</ul>
	</nav>

	<div class="register-form">
		<h1>Create Account</h1>
		
		<?php if (!empty($errors)): ?>
			<div class="error">
				<?php foreach($errors as $error): ?>
					<p><?php echo htmlspecialchars($error); ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<form method="POST" action="">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" id="username" name="username" required 
					value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
			</div>

			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" id="email" name="email" required
					value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" id="password" name="password" required>
			</div>

			<div class="form-group">
				<label for="confirm_password">Confirm Password</label>
				<input type="password" id="confirm_password" name="confirm_password" required>
			</div>

			<button type="submit" class="prim">Create Account</button>
		</form>

		<p style="margin-top: 20px; text-align: center;">
			Already have an account? <a href="login.php">Login here</a>
		</p>
	</div>
</body>
</html>