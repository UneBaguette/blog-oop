// Version 0.4 WIP

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
    
    const confirmOverlay = document.querySelector(".actions-overlay #confirm");

    [document.querySelector(".actions-overlay #cancel"), document.querySelector(".popup > span")].forEach((el) => {
        el.addEventListener("click", toggleOverlay);
    });

    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("overlay-container")) {
            toggleOverlay();
        };
    });

    confirmOverlay.addEventListener("click", () => {
        const itemId = confirmOverlay.dataset.id;
        const error = document.createElement("div");
        error.className = "msg error";
        
        fetch(window.location.pathname + "/delete/" + itemId, {
            method: "DELETE"
        })
        .then((res) => res.json())
        .then((data) => {
            //TODO: Show error
            if (Number.isInteger(data.error)){
                document.querySelector(".container").prepend(error);
                
            }
            const tr = document.querySelectorAll("tr .id");
            tr.forEach((id) => {
                if (id.textContent === itemId) {
                    id.parentNode.remove();
                };
            });
            toggleOverlay();
        })
        .catch(console.error);
        
    });

})();