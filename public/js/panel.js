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

    const actionsBtn = document.querySelectorAll(".actions .btn");

    actionsBtn.forEach((btn) => {
        if (btn.id === "delete") {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                const response = fetch("/admin/posts/delete/" + btn.dataset.id);
                console.log(response);
            });
        }
        else {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                const response = fetch("/admin/posts/edit/" + btn.dataset.id + "?onpage=false", {
    
                })
            });
        }
    });


})();