// Version 0.2

(() => {
    'use strict';

    const imgAdd = document.querySelector("input[type=file]");

    imgAdd.addEventListener("dragenter", (ev) => {
        ev.dataTransfer.dropEffect = "copy";
        imgAdd.parentNode.firstChild.style.opacity = "0";
    });

    imgAdd.addEventListener("dragleave", (ev) => {
        imgAdd.parentNode.firstChild.style.opacity = "1";
        imgAdd.parentNode.classList.remove("drag");
    });

    const inputImg = document.querySelector(".img-add");
    const imgContent = document.querySelector(".img-content");
    const imgInfos = document.querySelector(".img-infos");
    const imgPreview = document.createElement("img");
    const imgText = document.createElement("p");
    const imgDelete = document.createElement("button");
    const imgEdit = document.createElement("button");
    const parentEl = document.getElementById("img-container");
    
    imgPreview.id = "img-preview";
    imgText.className = "uploaded-filename";
    imgEdit.className = "img-edit";
    imgDelete.className = "img-trash";
    imgEdit.textContent = "Edit";
    imgDelete.textContent = "Delete";

    const loadFile = (ev) => {
        let reader = new FileReader();

        imgInfos.innerHTML = "";

        parentEl.prepend(imgContent);
        imgContent.prepend(imgInfos);
        imgInfos.appendChild(imgPreview);
        imgInfos.appendChild(imgText);
        imgInfos.appendChild(imgEdit);
        imgInfos.appendChild(imgDelete);

        imgInfos.style.display = "none";

        const output = document.getElementById('img-preview');

        reader.onload = function(){
            output.src = reader.result;
            imgInfos.style.display = "flex";
        };
        imgText.textContent = ev.target.files[0].name;
        reader.readAsDataURL(ev.target.files[0]);

        const deleteImg = function(e) {
            e.preventDefault();
            const noImage = document.createElement("p");
            noImage.textContent = "No image uploaded";

            imgInfos.innerHTML = "";

            if (inputImg.value.length){
                inputImg.value = "";
                imgInfos.prepend(noImage);
                imgDelete.removeEventListener('click', deleteImg);
                imgEdit.removeEventListener('click', editImg);
            }
        }
        const editImg = function(e) {
            e.preventDefault();
            //flemme
        }

        imgDelete.addEventListener('click', deleteImg);
        imgEdit.addEventListener('click', editImg);
    };

    inputImg.addEventListener("change", loadFile);

})();