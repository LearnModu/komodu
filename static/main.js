function showDemo() {
	const demoContainer = document.createElement('div');
	demoContainer.id = "komodu-demo";
	document.body.appendChild(demoContainer);

	new Comments("demo-123").init(demoContainer);
}

function copySnippet(siteId = "your-site-id") {
	const snippet = `<div id="komodu-comments"></div>
	<script>
		window.komoduConfig = {
			site: '${siteId}',
			theme: 'light'
		};
	</script>
	<script src="https://cdn.komodu.tech/embed.js"></script>`;

	navigator.clipboard.writeText(snippet);
	alert("code copied!");
}
