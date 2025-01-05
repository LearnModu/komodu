<?php

session_start();
require_once "config/db.php";

if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
	exit;
}

$stmt = $conn->prepare("SELECT * FROM sites WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$sites = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $conn->prepare("SELECT site_code, COUNT(*) as count FROM comments WHERE site_code IN (SELECT embed_code FROM sites WHERE user_id = ?) GROUP BY site_code");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$comments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard - Komodu</title>
	<link rel="stylesheet" href="./static/styles.css">
	<style>
		
	</style>
</head>
<body>
	<nav class="nav">
		<ul class="nav-list">
			<li><a href="/" class="nav-link">Home</a></li>
			<li><a href="#" class="nav-link active">Dashboard</a></li>
			<li><a href="logout.php" class="nav-link">Logout</a></li>
		</ul>
	</nav>

	<div class="dashboard">
		<h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

		<div class="stats">
			<div class="stat-card">
				<h3>Total Sites</h3>
				<p><?php echo count($sites); ?></p>
			</div>
			<div class="stat-card">
				<h3>Total Comments</h3>
				<p><?php echo array_sum(array_column($comments, 'count')); ?></p>
			</div>
			<div class="stat-card">
				<h3>Active Today</h3>
				<p>Coming soon</p>
			</div>
		</div>

		<h2>Your Sites</h2>
		<button onclick="showAddSiteModal()" class="prim" style="margin-bottom: 20px;">Add New Site</button>
		
		<div class="sites-grid">
			<?php foreach($sites as $site): ?>
			<div class="site-card">
				<h3><?php echo htmlspecialchars($site['site_url']); ?></h3>
				<p>Embed Code: <code><?php echo htmlspecialchars(string: $site['embed_code']); ?></code></p>
				<select onchange="updateTheme('<?php echo $site['embed_code']; ?>', this.value)">
					<option value="light" <?php echo $site['theme'] === 'light' ? 'selected' : ''; ?>>Light</option>
					<option value="dark" <?php echo $site['theme'] === 'dark' ? 'selected' : ''; ?>>Dark</option>
					<?php
					$themes = $conn->query("SELECT id, name FROM themes WHERE user_id = " . $_SESSION['user_id']);
					while ($theme = $themes->fetch_assoc()):
					?>
					<option value="custom_<?php echo $theme['id']; ?>" 
						<?php echo $site['theme'] === 'custom_'.$theme['id'] ? 'selected' : ''; ?>>
						<?php echo htmlspecialchars($theme['name']); ?>
					</option>
					<?php endwhile; ?>
				</select>
				<button onclick="copySnippet('<?php echo $site['embed_code']; ?>')" class="sec">Copy Code</button>
			</div>
			<?php endforeach; ?>
		</div>

		<div id="themeModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5);">
			<div style="background: white; padding: 20px; border-radius: 10px; max-width: 600px; width: 100%; margin: 50px auto;">
				<h2>Create Custom Theme</h2>
				<form onsubmit="createTheme(event)">
					<div class="form-group">
						<label>Theme Name</label>
						<input type="text" name="name" required>
					</div>
					<div class="form-group">
						<label>Custom CSS</label>
						<textarea name="css" required rows="10" style="width: 100%; font-family: monospace;">.komodu-comments {
							/* Your custom CSS here */
							--bg-color: #fff;
							--text-color: #333;
							--border-color: #ddd;
						}</textarea>
					</div>
					<button type="submit" class="prim">Save Theme</button>
					<button type="button" class="sec" onclick="hideThemeModal()">Cancel</button>
				</form>
			</div>
		</div>
	</div>

	<div id="addSiteModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
		<div style="background: white; padding: 20px; border-radius: 10px; max-width: 400px; width: 100%;">
			<h2>Add New Site</h2>
			<form onsubmit="addSite(event)">
				<div class="form-group">
					<label>Site URL</label>
					<input type="url" name="site_url" required placeholder="https://example.com">
				</div>
				<button type="submit" class="prim">Add Site</button>
				<button type="button" class="sec" onclick="hideAddSiteModal()">Cancel</button>
			</form>
		</div>
	</div>

	<script src="static/dashboard.js"></script>
</body>
</html>
