class Comments {
    constructor (embedCode) {
        this.embedCode = embedCode;
        this.apiBase = "https://komodu.tech/api";
    }

    async init(container) {
        const iframe = document.createElement("iframe");
        iframe.src = `${this.apiBase}/embed/${this.embedCode}`;
        iframe.style.width = "100%";
        iframe.style.height = "500px";
        iframe.style.border = "none";

        container.appendChild(iframe);
    }
}