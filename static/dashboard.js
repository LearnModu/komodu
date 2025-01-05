function showAddSiteModal() {
	document.getElementById('addSiteModal').style.display = 'flex';
}

function hideAddSiteModal() {
	document.getElementById('addSiteModal').style.display = 'none';
}

async function addSite(e) {
	e.preventDefault();
	const formData = new FormData(e.target);
	const response = await fetch('embed-gen.php', {
		method: 'POST',
		body: formData
	});
	const data = await response.json();
	if (data.success) {
		location.reload();
	} else {
		alert('Error: ' + data.error)1;
	}
}