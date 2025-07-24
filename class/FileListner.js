export default class FileListner {
    constructor(filesLocation, className, infoSpaceId) {
        this.selfName = "list-info";
        this.filesLocation = filesLocation;
        this.itemsName = className;
        this.infoSpaceId = infoSpaceId;
        this.infoSpace = document.getElementById(infoSpaceId);
    }

    init() {
        this.items = document.getElementsByClassName(this.itemsName);
        if (this.items.length === 0) {
            console.error("No items found with class name:", this.itemsName);
            return;
        }
        Array.from(this.items).forEach(element => {
            element.addEventListener("mouseenter", async () => {
                this.infoSpace.style.display = "flex";

                const path = element.getAttribute("link");
                const data = await this.getInfo(path);

                const nameLabel = document.createElement("label");
                nameLabel.innerText = "Name:";
                const nameValue = document.createElement("span");
                nameValue.innerText = data.name;

                const parentLabel = document.createElement("label");
                parentLabel.innerText = "Parent:";
                const parentValue = document.createElement("span");
                parentValue.innerText = data.parent;

                const sizeLabel = document.createElement("label");
                sizeLabel.innerText = "Size:";
                const sizeValue = document.createElement("span");
                sizeValue.innerText = data.size;

                const lastModifiedLabel = document.createElement("label");
                lastModifiedLabel.innerText = "Last Modified:";
                const lastModifiedValue = document.createElement("span");
                lastModifiedValue.innerText = data.lastModified;

                const creationLabel = document.createElement("label");
                creationLabel.innerText = "Creation:";
                const creationValue = document.createElement("span");
                creationValue.innerText = data.creation;

                this.infoSpace.innerHTML = '';
                this.infoSpace.appendChild(nameLabel);
                this.infoSpace.appendChild(nameValue);
                this.infoSpace.appendChild(parentLabel);
                this.infoSpace.appendChild(parentValue);
                this.infoSpace.appendChild(sizeLabel);
                this.infoSpace.appendChild(sizeValue);
                this.infoSpace.appendChild(lastModifiedLabel);
                this.infoSpace.appendChild(lastModifiedValue);
                this.infoSpace.appendChild(creationLabel);
                this.infoSpace.appendChild(creationValue);
            });
            element.addEventListener("mouseleave", () => {
                this.infoSpace.innerHTML = "";
                this.infoSpace.style.display = "none";
            });
        });
    }

    async getInfo(path) {
        const response = await fetch(this.filesLocation + "?path=" + path);
        const data = await response.json();
        return data;
    }

}