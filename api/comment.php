<?php

session_start();
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) die (json_encode(["success" => false, "error" => "invalid token!"]));

	$name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
	$content = filter_var($_POST["content"], FILTER_SANITIZE_STRING);
	$site_code = $_POST["site_code"];

	$site_check = $conn->prepare("select id from sites where embed_code = ?");
	$site_check->bind_param("s", $site_code);
	$site_check->execute();
	if (!$site_check->get_result()->num_rows) die(json_encode(['success' => false, 'error' => 'Invalid site code']));

	$stmt = $conn->prepare("insert into comments (site_code, author_name, content) values (?, ?, ?)");
	$stmt->bind_param("sss", $site_code, $name, $content);

	if ($stmt->execute()) echo json_encode(["success" => true]);
	else echo json_encode(["success" => false, "error" => $conn->error]);
}

?>