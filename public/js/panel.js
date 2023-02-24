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

    function deleteItem() {
        //TODO: Fix not working on tag/posts pages
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
    };

    const toggleOverlay = (mode = null, title = null) => {
        const overlay = document.querySelector(".overlay-container");
        const popup = document.querySelector(".popup");

        if (!overlay.classList.contains("show")) {
            overlay.classList.toggle("show");
            setTimeout(() => {
                overlay.classList.toggle("transition");
                setTimeout(() => {
                    return popup.classList.toggle("show");
                }, 50)
            }, 100);
        }
        else {
            popup.classList.toggle("show");
            setTimeout(() => {
                overlay.classList.toggle("transition");
                setTimeout(() => {
                    return overlay.classList.toggle("show");
                }, 100)
            }, 100);
        }
        switch (mode) {
            // DELETE MODE
            case 0:
                document.querySelector(".popup-title").textContent = title.textContent;
                confirmOverlay.addEventListener("click", deleteItem);
                break;
            //EDIT MODE
            case 1:

                break;
            default:
                break;
        }
    };

    [document.querySelector(".actions-overlay #cancel"), document.querySelector(".popup > span")].forEach((el) => {
        el.addEventListener("click", toggleOverlay);
    });

    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("overlay-container")) {
            toggleOverlay();
        };
    });

    const edit = (e) => {
        e.preventDefault();
        window.location.href =  window.location.pathname + "/edit/" + e.target.dataset.id;
    };

    const del = (e) => {
        e.preventDefault();
        document.querySelector(".actions-overlay #confirm").setAttribute("data-id", e.target.dataset.id);
        toggleOverlay(0, e.target.parentNode.parentNode.children[1]);
    };

    document.querySelectorAll(".actions #edit").forEach((btn) => {
        btn.addEventListener("click", edit);
    });
    document.querySelectorAll(".actions #delete").forEach((btn) => {
        btn.addEventListener("click", del);
    });

})();