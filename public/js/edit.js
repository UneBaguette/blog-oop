// 0.1


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
    const imgContent = document.createElement("div");
    const imgInfos = document.createElement("div");
    const imgPreview = document.createElement("img");
    const imgText = document.createElement("p");
    const imgDelete = document.createElement("button");
    const parentEl = document.getElementById("img-container");

    imgContent.className = "img-content";
    imgInfos.className = "img-infos";
    imgPreview.id = "img-preview";
    imgText.className = "uploaded-filename";
    imgText.style.width = "100%";
    imgText.style.textAlign = "center";
    imgDelete.className = "img-trash";
    imgDelete.textContent = "Delete";

    const loadFile = (ev) => {
        let reader = new FileReader();

        parentEl.children[0].remove();

        parentEl.prepend(imgContent);
        imgContent.appendChild(imgInfos);
        imgInfos.appendChild(imgPreview);
        imgInfos.appendChild(imgText);
        imgInfos.appendChild(imgDelete);

        reader.onload = function(){
            let output = document.getElementById('img-preview');
            output.src = reader.result;
        };
        imgText.textContent = ev.target.files[0].name;
        reader.readAsDataURL(ev.target.files[0]);

        imgDelete.addEventListener('click', (e) => {
            e.preventDefault();
            const noImage = document.createElement("p");
            noImage.textContent = "No image uploaded";
            if (inputImg.value.length){
                inputImg.value = "";
                imgInfos.remove();
                imgContent.prepend(noImage);
            }
        });
    };

    inputImg.addEventListener("change", loadFile);

})();