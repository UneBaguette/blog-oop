// Version 0.2

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

    const imgAdd = document.querySelector("input[type=file]");

    imgAdd.addEventListener("dragenter", (ev) => {
        ev.dataTransfer.dropEffect = "copy";
        imgAdd.parentNode.firstChild.style.opacity = "0";
    });

    imgAdd.addEventListener("dragleave", (ev) => {
        imgAdd.parentNode.firstChild.style.opacity = "1";
        imgAdd.parentNode.classList.remove("drag");
    });





})();