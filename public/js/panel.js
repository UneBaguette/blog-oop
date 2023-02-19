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

    document.querySelector(".actions-overlay #cancel").addEventListener("click", toggleOverlay);

    confirmOverlay.addEventListener("click", () => {
        const itemId = confirmOverlay.dataset.id;
        
        fetch(window.location.pathname + "/delete/" + itemId, {
            method: "POST"
        }).then((res) => {
            if (res.ok){
                const tr = document.querySelectorAll("tr .id");
                tr.forEach((id) => {
                    if (id.textContent === itemId) {
                        id.parentNode.remove();
                    };
                });
                toggleOverlay();
            }
        }).catch((err) => {
            console.error(err);
        });
        
    });

})();