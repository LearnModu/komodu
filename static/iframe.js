async function vote(commentId, value) {
	try {
		const response = await fetch("/api/vote.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify([commentId, value]),
		});
		const data = response.json();
		if (data.success) location.reload();
		else throw new Error(data.error | "Vote failed");
	} catch (err) {
		console.error("Vote error: ", err);
		alert("Error voting: " + err.message);
	}
}

document.getElementById("commentForm").onsubmit = async (e) => {
	e.preventDefault();
	const form = e.target;
	const formData = new FormData(form);
	
	try {
		console.log("Submitting comment...");
		const response = await fetch("/api/comment.php", {
			method: "POST",
			body: formData,
			credentials: 'include',
		});
		
		const text = await response.text();
		console.log("Raw response:", text);
		
		try {
			const data = JSON.parse(text);
			console.log("Parsed data:", data);
			
			if (data.success) {
				form.reset();
				location.reload();
			} else {
				throw new Error(data.error || "Error posting comment!");
			}
		} catch (parseError) {
			console.error("Parse error:", parseError);
			console.log("Raw response was:", text);
			throw new Error("Invalid server response");
		}
	} catch (err) {
		console.error("Error:", err);
		alert('Error posting comment: ' + err.message);
	}
};
