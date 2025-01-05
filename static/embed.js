class Comments {
	constructor (embedCode, postId = '') {
		this.embedCode = embedCode;
		this.postId = postId;
		this.apiBase = "http://localhost";
	}

	init(container) {
		if (!container) throw new Error("container required!");

		const iframe = document.createElement("iframe");
		const params = new URLSearchParams({
			code: this.embedCode,
			theme: this.config.theme || "light",
		});
		iframe.src = `${this.apiBase}/iframe.php?code=${params}`;
		iframe.style.width = "100%";
		iframe.style.height = "500px";
		iframe.style.border = "none";
		iframe.style.borderRadius = "10px";
		iframe.onload = () => this.adjustHeight(iframe);

		container.appendChild(iframe);
	}

	adjustHeight(iframe) {
		iframe.style.height = iframe.contentWindow.document.body.scrollHeight + "px"
	}
}