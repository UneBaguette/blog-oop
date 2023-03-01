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
            imgDisplay.className = "img-display";
            img.src = imgPath + i.filename;
            img.alt = i.alt;
            imgText.textContent = i.filename;
            imgContainer.appendChild(imgDisplay);
            imgDisplay.appendChild(img);
            imgDisplay.appendChild(imgText);
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

        actions.appendChild(buttonConfirm);

        popup.appendChild(actions);

        showImgOverlay();
    };

    function showImgOverlay() {
        if (!imgOverlay.classList.contains("show")) {
            imgOverlay.classList.toggle("show");
            setTimeout(() => {
                imgOverlay.classList.toggle("transition");
                setTimeout(() => {
                    return popup.classList.toggle("show");
                }, 50)
            }, 100);
        } else {
            popup.classList.toggle("show");
            setTimeout(() => {
                imgOverlay.classList.toggle("transition");
                setTimeout(() => {
                    imgOverlay.classList.toggle("show");
                    popup.innerHTML = "";
                    return imgOverlay.remove();
                }, 100)
            }, 100);
        }
    }

    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("overlay-container")) {
            showImgOverlay();
        };
    });

    const add = document.querySelector(".btn.add");

    add.addEventListener("click", imageOverlay);

    async function getAllImages(){
        const res = await fetch("/admin/images/all").catch(console.error);
        const data = await res.json();
        return data;
    }

})();