<!DOCTYPE html>
<html lang="en">
<?php
    $website_count = 69;
?>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./static/styles.css">
    <title>Komodu by LearnModu - Comments made simple!</title>
</head>
<!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.  -->
<body>
    <nav class="nav">
        <ul class="nav-list">
        <li><a href="#" class="nav-link">Home</a></li>
        <li><a href="https://learnmodu.org" target="_blank" class="nav-link">LearnModu</a></li>
      </ul>
    </nav>
    <header>
        <h1>Welcome to Komodu</h1>
        <p class="sub">A powerful, embeddable, customizable and open source commenting system, made by the LearnModu team.</p>
        <div class="hero-btns">
            <a class="prim" href="/register.php">Start Now - It's free!</a>
            <button onclick="showDemo()" class="sec">Show Demo</button>
        </div>
    </header>

    <section id="features">
		<h2>Integration is simple! Click to copy:</h2>
		<div class="example" style="position: relative;" onclick="copySnippet()">
			<pre><code>
			&lt;div id="komodu-comments"&gt;&lt;/div&gt;
			
			&lt;script&gt;
				window.komoduConfig = {
					site: 'your-site-id',
                    postId: 'unique-post-id', // you make it yourself!
					theme: 'light'
				};
			&lt;/script&gt;
			&lt;script src="https://komodu.tech/static/embed.js"&gt;&lt;/script&gt;
			</code></pre>
		</div>
	</section>

    <section id="f-grid">
        <div class="f-card">
            <h3>Beautiful Themes</h3>
            <p>Various styles to match your brand, and you can make your own with Komodu.conf</p>
        </div>
        <div class="f-card">
            <h3>Blazingly Fast</h3>
            <p>Made in PHP and JavaScript for GREAT performance.</p>
        </div>
        <div class="f-card">
            <h3>Spam Protected</h3>
            <p>It's built in!</p>
        </div>
        <div class="f-card">
            <h3>It's Open Source!</h3>
            <p>Komodu is available on our GitHub!</p>
        </div>
    </section>

    <section class="cta">
        <h2>Get your people talking 🗣️</h2>
        <p>Join a total of <?php echo $website_count ?> websites that use Komodu</p>
        <button class="prim">Get Started</button>
    </section>

    <footer>
        <p>&copy; LearnModu 2025</p>
    </footer>

    <script src="static/main.js"></script>
</body>
</html>