<?php

header ("X-Frame-Options: ALLOWALL");
require_once "config/db.php";

$site_code = $_GET["code"];
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
	<link rel="stylesheet" href="static/iframe.css">
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
			<input type="text" name="name" placeholder="Your username..." required >
			<textarea name="content" placeholder="Your comment..." required></textarea>
			<button type="submit">Post</button>
		</form>
	</div>

	<div id="comments">
	<?php
	$stmt = $conn->prepare("select * from comments where site_code = ? and parent_id = ?");
	$stmt->bind_param("s", $site_code);
	$stmt->execute();
	$result = $stmt->get_result();

	while ($comment = $result->fetch_assoc()) {
		echo '<div class="comment">';
		echo '<h4>' . htmlspecialchars($comment['author_name']) . '</h4>';
		echo '<p>' . htmlspecialchars($comment['content']) . '</p>';
		echo '<div class="vote-btns">';
		echo '<button onclick="vote(' . $comment['id'] . ', 1)">↑ ' . $comment['upvotes'] . '</button>';
		echo '<button onclick="vote(' . $comment['id'] . ', -1)">↓ ' . $comment['downvotes'] . '</button>';
		echo '</div></div>';
	}
	?>
	</div>

	<script src="static/iframe.js"></script>
</body>
</html>
