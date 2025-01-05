function showAddSiteModal() { document.getElementById('addSiteModal').style.display = 'flex'; }
function hideAddSiteModal() { document.getElementById('addSiteModal').style.display = 'none'; }
function showThemeModal() { document.getElementById('themeModal').style.display = "flex"; }
function hideThemeModal() { document.getElementById('themeModal').style.display = "none"; }

async function addSite(e) {
	e.preventDefault();
	const formData = new FormData(e.target);
	try {
		const response = await fetch('/embed-gen.php', {
			method: 'POST',
			body: formData,
		});
		
		if (!response.ok) throw new Error("HTTP error! " + response.status);

		const text = await response.text();
		console.log("raw: ", text);
		const data = await response.json();
		console.log("data: ", data);

		if (data.success) {
			hideAddSiteModal();
			location.reload();
		} else {
			alert('Error: ' + data.error);
		}
	} catch (err) {
		console.error(err.message)
		alert("Error: " + err.message);
	}
}

async function addTheme(e) {
	e.preventDefault();
	const formData = new FormData(e.target);
	try {
		const response = await fetch("api/theme.php", {
			method: "POST",
			body: formData
		});

		const data = await response.json();
		if (data.success) location.reload();
		else alert("Error: ", data.error);
	} catch (err) {
		alert("Error: " + err.message);
	}
}

