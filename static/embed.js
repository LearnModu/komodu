class Comments {
    constructor (embedCode) {
        this.embedCode = embedCode;
        this.apiBase = "https://komodu.tech";
    }

    init(container) {
        if (!container) throw new Error("container required!");

        const iframe = document.createElement("iframe");
        iframe.src = `${this.apiBase}/iframe.php?code=${this.embedCode}`;
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