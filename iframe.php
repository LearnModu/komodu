<?php

session_start();

header ("X-Frame-Options: ALLOWALL");
require_once "config/db.php";
error_reporting (E_ALL);
ini_set ("display_errors", 1);

if (!isset($_SESSION["csrf_token"])) $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

$site_code = $_GET["code"] ?? null;
if (empty($site_code)) die("No site code provided");
$theme = $_GET["theme"] ?? "light";

$custom_css = "";
if (strpos($theme, "custom_") === 0) {
	$themeId = substr($theme,7);
	$stmt = $conn->prepare("select css from themes where id = ?");
	$stmt->bind_param("i", $themeId);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($themeData = $result->fetch_assoc()) $custom_css = $themeData["css"];
}

?>

<!DOCTYPE html>
<html>
<head>
	<base href="http://localhost">
	<link rel="stylesheet" href="/static/iframe.css">
	<?php if ($theme === 'dark'): ?>
	<style>
		body { background: #1a1a1a; color: #fff; }
		.comment { border-color: #333; }
		input, textarea { background: #333; color: #fff; border-color: #444; }
		button { background: #444; color: #fff; }
	</style>
	<?php endif; ?>
	<?php if ($custom_css): ?>
	<style><?php echo $custom_css; ?></style>
	<?php endif; ?>
</head>
<body>
	<div class="comment-form">
		<form id="commentForm">
			<input type="hidden" name="site_code" value="<?php echo htmlspecialchars($site_code); ?>">
			<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
			<input type="text" name="name" placeholder="Your name" required>
			<textarea name="content" placeholder="Write your comment..." required></textarea>
			<button type="submit">Post Comment</button>
		</form>
	</div>

	<div id="comments">
	<?php
	$stmt = $conn->prepare("select * from comments where site_code = ? order by created_at desc");
	if (!$stmt) die("Prepare failed: " . $conn->error);
	$stmt->bind_param("s", $site_code);
	$success = $stmt->execute();
	if (!$success) die("Execute failed: ". $stmt->error);
	$result = $stmt->get_result();
	if (!$result) die("Error loading comments: " . $stmt->error);

	while ($comment = $result->fetch_assoc()) {
		echo '<div class="comment">';
		echo '<h4>' . htmlspecialchars($comment['author_name']) . '</h4>';
		echo '<p>' . htmlspecialchars($comment['content']) . '</p>';
		echo '<div class="vote-btns">';
		echo '<button onclick="vote(' . $comment['id'] . ', 1)">↑ ' . ($comment['upvotes'] ?? 0) . '</button>';
		echo '<button onclick="vote(' . $comment['id'] . ', -1)">↓ ' . ($comment['downvotes'] ?? 0) . '</button>';
		echo '</div></div>';
	}
	?>
	</div>

	<script src="static/iframe.js"></script>
</body>
</html>
