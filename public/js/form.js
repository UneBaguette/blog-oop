// Version 0.1

(() => {
    'use strict';

    const tags = document.querySelectorAll('.tag');

    tags.forEach((tag) => {
        const box = tag.getElementsByClassName("box");
        if (tag.classList.contains("active")){
            tag.parentNode.prepend(tag);
        }
        tag.addEventListener('click' , () => {
            box.item(0).checked = !box.item(0).checked;
            if (box.item(0).checked){
                tag.classList.add("active");
                return tag.parentNode.prepend(tag);
            }
            tag.classList.remove("active");
            return tag.parentNode.append(tag);
        });
    });

    const imgOverlay = document.createElement("div");
    const popup = document.createElement("div");

    const imageOverlay = async (e) => {
        e.preventDefault();
        const span = document.createElement("span");
        const h3 = document.createElement("h3");
        const imgContainer = document.createElement("section");
        const actions = document.createElement("div");
        const buttonCancel = document.createElement("button");
        const buttonConfirm = document.createElement("button");
        const imgPath = "/public/images/";
        const images = await getAllImages();
        let selectedImages = [];
        
        document.body.appendChild(imgOverlay);

        popup.className = "popup";

        imgOverlay.classList.add("overlay-container");
        imgOverlay.prepend(popup);
        
        span.addEventListener("click", showImgOverlay);

        popup.prepend(span);

        h3.textContent = "Sélectionner une ou plusieurs image(s). Total: " + images.length;

        popup.appendChild(h3);

        imgContainer.className = "img-container";

        popup.appendChild(imgContainer);

        images.forEach((i) => {
            const imgDisplay = document.createElement("div");
            const img = document.createElement("img");
            const imgText = document.createElement("p");
            const input = document.createElement("input");
            imgDisplay.className = "img-display";
            img.src = imgPath + i.filename;
            img.alt = i.alt;
            imgText.textContent = i.filename;
            input.type = "checkbox";
            input.value = i.id;
            input.name = "media[]";
            imgContainer.appendChild(imgDisplay);
            imgDisplay.appendChild(img);
            imgDisplay.appendChild(imgText);
            imgDisplay.appendChild(input);
            input.addEventListener("change", (e) => {
                const value = e.target.value;
                if (e.target.checked){
                    if (!selectedImages.includes(value)) {
                        selectedImages.push(value);
                    }
                } else {
                    selectedImages = selectedImages.filter(i => i !== value);
                }
            });
        });

        actions.className = "actions-overlay";

        buttonCancel.className = "btn";
        buttonCancel.id = "cancel";
        buttonCancel.textContent = "Annuler";
        buttonCancel.addEventListener("click", showImgOverlay);

        actions.prepend(buttonCancel);

        buttonConfirm.className = "btn danger";
        buttonConfirm.id = "confirm";
        buttonConfirm.textContent = "Confirmer";
        buttonConfirm.addEventListener("click", () => {
            
        });

        actions.appendChild(buttonConfirm);

        popup.appendChild(actions);

        showImgOverlay();
    };

    function showImgOverlay() {
        showOverlay(imgOverlay, popup);
    }

    const loading = document.createElement("div");
    const loader = document.createElement("div");

    function loadingOverlay() {
        loading.className = "loading-overlay";
        loader.className = "lds-dual-ring";
        loading.appendChild(loader);
        document.body.appendChild(loading);
        showOverlay(loading, loader);
    }
    

    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("overlay-container")) {
            showImgOverlay();
        };
    });

    const add = document.querySelector(".btn.add");

    add.addEventListener("click", imageOverlay);

    function showOverlay(parent, child){
        if (!parent.classList.contains("show")) {
            parent.classList.toggle("show");
            setTimeout(() => {
                parent.classList.toggle("transition");
                setTimeout(() => {
                    return child.classList.toggle("show");
                }, 50)
            }, 100);
        } else {
            child.classList.toggle("show");
            setTimeout(() => {
                parent.classList.toggle("transition");
                setTimeout(() => {
                    parent.classList.toggle("show");
                    child.innerHTML = "";
                    return parent.remove();
                }, 100)
            }, 100);
        }
    }

    async function getAllImages(){
        loadingOverlay();
        const res = await fetch("/admin/images/all").catch((err) => {
            console.error(err);
            showOverlay(loading, loader);
        }).finally(() => {showOverlay(loading, loader);});
        const data = await res.json();
        return data;
    }

})();