async function vote(commentId, value) {
	const response = await fetch("/api/vote.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify([commentId, value]),
	});
	if (response.ok) location.reload();
}

document.getElementById("commentForm").onsubmit = async (e) => {
	e.preventDefault();

	const formData = new FormData(e.target);
	const response = await fetch("/api/comment.php", {
		method: "POST",
		body: formData,
	});
	if (response.ok) location.reload();
}
