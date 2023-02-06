// Version 1.0

(() => {
    'use strict';

    const imgs = Array.from(document.querySelectorAll(".img-container li"));

    // OVERLAY
    const overlay = document.querySelector(".overlay");
    const overlayImg = document.querySelector(".overlay img");

    imgs.forEach((imgl) => {
        imgl.addEventListener("click" ,() => {
            const img = imgl.children[0];
            if (overlay.children.length <= 0) {
                appendImg();
            }
            
        });
    });


    function appendImg() {
        imgs.forEach((img) => {
            
        });
    };

})();