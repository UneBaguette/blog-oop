// Version 0.5

(() => {
    'use strict';

    function deleteItem(e) {
        const itemId = e.target.dataset.id;
        const error = document.createElement("div");
        error.className = "msg error";
        
        fetch(window.location.pathname + "/delete/" + itemId, {
            method: "DELETE"
        })
        .then((res) => res.json())
        .then((data) => {
            if (data.error) {
                console.warn(data.msg);
            }
            const tr = document.querySelectorAll("tr .id");
            tr.forEach((id) => {
                if (id.textContent === itemId) {
                    id.parentNode.remove();
                };
            });
            showDeleteOverlay();
        })
        .catch(console.error);
    };

    const delOverlay = document.createElement("div");
    const popup = document.createElement("div");

    const deleteOverlay = (title = null, id = null) => {
        const span = document.createElement("span");
        const h3 = document.createElement("h3");
        const text = document.createElement("p");
        const actions = document.createElement("div");
        const buttonCancel = document.createElement("button");
        const buttonConfirm = document.createElement("button");
        document.body.appendChild(delOverlay);
        
        popup.className = "popup";

        delOverlay.classList.add("overlay-container");
        delOverlay.prepend(popup);
        
        span.addEventListener("click", showDeleteOverlay);

        popup.prepend(span);

        h3.innerHTML = `Supprimer "${title.textContent}" ?`;

        popup.appendChild(h3);

        text.className = "popup-text";
        text.textContent = "Vous ne pourrez pas revenir en arrière.";

        popup.appendChild(text);

        actions.className = "actions-overlay";

        buttonCancel.className = "btn";
        buttonCancel.id = "cancel";
        buttonCancel.textContent = "Annuler";
        buttonCancel.addEventListener("click", showDeleteOverlay);

        actions.prepend(buttonCancel);

        buttonConfirm.className = "btn danger";
        buttonConfirm.id = "confirm";
        buttonConfirm.dataset.id = id;
        buttonConfirm.textContent = "Confirmer";
        buttonConfirm.addEventListener("click", deleteItem);

        actions.appendChild(buttonConfirm);

        popup.appendChild(actions);

        showDeleteOverlay();
    };

    function showDeleteOverlay() {
        if (!delOverlay.classList.contains("show")) {
            delOverlay.classList.toggle("show");
            setTimeout(() => {
                delOverlay.classList.toggle("transition");
                setTimeout(() => {
                    return popup.classList.toggle("show");
                }, 50)
            }, 100);
        } else {
            popup.classList.toggle("show");
            setTimeout(() => {
                delOverlay.classList.toggle("transition");
                setTimeout(() => {
                    delOverlay.classList.toggle("show");
                    popup.innerHTML = "";
                    return delOverlay.remove();
                }, 100)
            }, 100);
        };
    };

    window.start_and_end = function(str,maxlength = 35) {
        if (str.length > maxlength) {
            return str.substring(0, 25) + ' ... ' + str.substr(str.length - 10, str.length);
        }
        return str;
    };

    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("overlay-container")) {
            showDeleteOverlay();
        };
    });

    const edit = (e) => {
        e.preventDefault();
        window.location.href =  window.location.pathname + "/edit/" + e.target.dataset.id;
    };

    const del = (e) => {
        e.preventDefault();
        deleteOverlay(e.target.parentNode.parentNode.children[1], e.target.dataset.id);
    };

    document.querySelectorAll(".actions #edit").forEach((btn) => {
        btn.addEventListener("click", edit);
    });
    document.querySelectorAll(".actions #delete").forEach((btn) => {
        btn.addEventListener("click", del);
    });

    document.querySelectorAll("td").forEach((t) => {
        if (!t.className.length) {
            t.textContent = window.start_and_end(t.textContent, 35);
        }
    });

})();