<?php
header ("X-Frame-Options: ALLOWALL");
require_once "config/db.php";

$site_code = $_GET["code"];
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="static/iframe.css" >
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
