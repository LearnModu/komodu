<?php

session_start();
require_once "config/db.php";

function checkRateLimit($ip) {
	if (isset($_SESSION["login_attempts"]["ip"])) {
		if ($_SESSION["login_attempts"]["ip"]["count"] > 5 &&
		time() - $_SESSION["login_attempts"][$ip]["time"] < 300) {
			return false;
		}
	}
	return true;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
	$ip = $_SERVER['REMOTE_ADDR'];
	if (!checkRateLimit($ip)) {
		die(json_encode(['success' => false, 'message' => 'Too many attempts']));
	}

	$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
	$password = $_POST["password"];

	$stmt = $conn->prepare("SELECT id, passhash FROM users WHERE email = ?");
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($user = $result->fetch_assoc()) {
		if (password_verify($password, $user["passhash"])) {
			$_SESSION["user_id"] = $user["id"];
			$_SESSION["csrf_token"] = bin2hex(random_bytes(32));
			echo json_encode(["success" => true]);
			exit;
		}
	}

	if (!isset($_SESSION['login_attempts'][$ip])) {
		$_SESSION['login_attempts'][$ip] = ['count' => 0, 'time' => time()];
	}
	$_SESSION['login_attempts'][$ip]['count']++;

	echo json_encode(["success" => false, "message" => "Invalid credentials"]);
}

?>
