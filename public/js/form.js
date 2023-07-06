// Version 0.5

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
        const imgPath = await getPathImages();
        const images = await getAllImages();
        const imgError = images.error;
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

        if (imgError){
            return console.error(images.error);
        }

        images.forEach((i) => {
            const imgDisplay = document.createElement("div");
            const img = document.createElement("img");
            const imgText = document.createElement("p");
            const input = document.createElement("input");
            const panelSelect = document.createElement("span");
            imgDisplay.className = "img-display";
            img.src = (imgPath ?? "/public/images/") + i.filename;
            img.alt = i.alt;
            imgText.textContent = window.start_and_end(i.filename, 80);
            document.querySelectorAll(".img-content > input").forEach((imageId) => {
                if (+(imageId.value) === i.id) {
                    input.checked = true;
                    selectedImages.push(i.id);
                    imgDisplay.appendChild(panelSelect);
                }
            });
            input.type = "checkbox";
            input.value = i.id;
            input.name = "media[]";
            panelSelect.className = "checkmark";
            imgContainer.appendChild(imgDisplay);
            imgDisplay.appendChild(img);
            imgDisplay.appendChild(imgText);
            imgDisplay.appendChild(input);
            imgDisplay.addEventListener('click', function() {
                const inputValue = input.value;
                input.checked = !input.checked; 
                if (input.checked){
                    if (!selectedImages.includes(inputValue)) {
                        selectedImages.push(+(inputValue));
                        imgDisplay.appendChild(panelSelect);
                    }
                } else {
                    selectedImages = selectedImages.filter(i => i !== +(inputValue));
                    panelSelect.remove();
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
            const parentEl = document.getElementById("img-container");
            let hasImg = false;
            parentEl.innerHTML = "";
            images.forEach((i) => {
                const image = i.id;
                if (selectedImages.includes(image)){
                    hasImg = true;
                    addImg(parentEl, i.id, i.alt, i.filename, imgPath)
                }
            })
            if (!hasImg) {
                placeholderImg(parentEl);
            }
            showImgOverlay();
        });

        actions.appendChild(buttonConfirm);

        popup.appendChild(actions);
        popup.classList.add("img");

        showImgOverlay();
    };

    function placeholderImg(parent) {
        const imgContent = document.createElement("div");
        const imgInfos = document.createElement("div");
        const noImage = document.createElement("p");
        imgContent.className = "img-content";
        imgInfos.className = "img-infos";
        noImage.textContent = "No image uploaded";

        imgInfos.innerHTML = "";

        imgInfos.appendChild(noImage);

        imgContent.appendChild(imgInfos);

        parent.prepend(imgContent);
    }

    function addImg(parent, id, alt, filename, src){
        const imgContent = document.createElement("div");
        const imgInfos = document.createElement("div");
        const imgPreview = document.createElement("img");
        const imgText = document.createElement("p");
        const actions = document.createElement("div");
        const imgEdit = document.createElement("button");
        const imgDelete = document.createElement("button");
        const inputImg = document.createElement("input");

        inputImg.id = "media";
        inputImg.name = "media[]";
        inputImg.type = "text";
        inputImg.style.display = "none";
        inputImg.value = id;

        imgContent.className = "img-content";
        imgInfos.className = "img-infos";
        imgText.className = "uploaded-filename";
        actions.className = "actions";
        imgEdit.className = "img-edit";
        imgDelete.className = "img-trash";

        imgPreview.id = id;
        imgPreview.alt = alt;
        imgPreview.src = src + filename;

        imgText.textContent = filename;

        imgEdit.textContent = "Edit";
        imgDelete.textContent = "Delete";

        imgInfos.appendChild(imgPreview);
        imgInfos.appendChild(imgText);

        actions.appendChild(imgEdit);
        actions.appendChild(imgDelete);
        
        imgInfos.appendChild(actions);

        imgContent.appendChild(imgInfos);
        imgContent.appendChild(inputImg);

        parent.prepend(imgContent);
    }

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
        }).finally(() => {
            setTimeout(() => {
                showOverlay(loading, loader);
            }, 250)}
        );
        return await res.json();
    }

    async function getPathImages(){
        const res = await fetch('/admin/images/fullpath').catch(err => console.error(err));
        const data = await res.json();
        return data.thumb.small ?? data.path;
    }

})();