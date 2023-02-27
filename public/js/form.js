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

    const imageOverlay = (title = null, id = null) => {
        const span = document.createElement("span");
        const h3 = document.createElement("h3");
        const text = document.createElement("p");
        const actions = document.createElement("div");
        const buttonCancel = document.createElement("button");
        const buttonConfirm = document.createElement("button");
        document.body.appendChild(imgOverlay);
        
        popup.className = "popup";

        imgOverlay.classList.add("overlay-container");
        imgOverlay.prepend(popup);
        
        span.addEventListener("click", showImgOverlay);

        popup.prepend(span);

        popup.appendChild(h3);

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

    add.addEventListener("click", (e) => {
        e.preventDefault();
        imageOverlay();
    });

})();