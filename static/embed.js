class Comments {
	constructor (embedCode, postId = '') {
		this.embedCode = embedCode;
		this.postId = postId;
		this.apiBase = "http://localhost";
		this.config = window.komoduConfig || {};
	}
	
	init(container) {
		if (!container) {
			container = document.getElementById("komodu-comments");
			if (!container) {
				console.error("no comments container");
				return;
			}
		}

		const iframe = document.createElement("iframe");
		const params = new URLSearchParams({
			code: this.config.site || this.embedCode,
			theme: this.config.theme || "light",
			postId: this.config.postId || "",
		}).toString();

		iframe.src = `${this.apiBase}/iframe.php?${params}`;
		iframe.style.width = "100%";
		iframe.style.minHeight = "400px";
		iframe.style.border = "none";
		iframe.style.borderRadius = "10px";
		iframe.style.overflow = "hidden";
		iframe.onload = () => {
			const resizeObserver = new ResizeObserver(entries => {
				iframe.style.height = entries[0].target.scrollHeight + "px";
			})

			resizeObserver.observe(iframe.contentDocument.body);
		}

		container.appendChild(iframe);
	}

}

window.addEventListener("load", () => {
	if (window.komoduConfig) {
		const comments = new Comments(window.komoduConfig.site);
		comments.init();
	}
})
