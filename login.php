<?php

session_start();
require_once "config/db.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$password = $_POST['password'];
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Invalid email format";
	}
	
	if (empty($errors)) {
		$stmt = $conn->prepare("SELECT id, username, passhash FROM users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($user = $result->fetch_assoc()) {
			if (password_verify($password, $user['passhash'])) {
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
				header("Location: dashboard.php");
				exit;
			}
		}
		$errors[] = "Invalid credentials";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Komodu</title>
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
		<h1>Welcome Back!</h1>
		
		<?php if (!empty($errors)): ?>
			<div class="error">
				<?php foreach($errors as $error): ?>
					<p><?php echo htmlspecialchars($error); ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<form method="POST" action="">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" id="email" name="email" required
					value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" id="password" name="password" required>
			</div>

			<button type="submit" class="prim">Login</button>
		</form>

		<p style="margin-top: 20px; text-align: center;">
			Don't have an account? <a href="register.php">Register here</a>
		</p>
	</div>
</body>
</html>