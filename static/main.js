function showDemo() {
	const demoContainer = document.createElement('div');
	demoContainer.id = "komodu-demo";
	document.body.appendChild(demoContainer);

	new Comments("demo-123").init(demoContainer);
}

function copySnippet(siteId = "your-site-id") {
	const snippet = `&lt;div id="komodu-comments"&gt;&lt;/div&gt;
			
	&lt;script&gt;
		window.komoduConfig = {
			site: 'your-site-id',
			postId: 'unique-post-id', // you make it yourself!
			theme: 'light'
		};
	&lt;/script&gt;
	&lt;script src="https://cdn.komodu.tech/embed.js"&gt;&lt;/script&gt;`;

	navigator.clipboard.writeText(snippet);
	alert("code copied!");
}
