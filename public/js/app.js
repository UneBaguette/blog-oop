// Version 0.1 WIP

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

    document.querySelector('.change-theme').addEventListener('click', changeTheme);

    /**
     * Change le thème ouah!
     * @param {string} ev ZEOIKJZEIOKJT
     * @returns vide
     */
    function changeTheme(ev) {
        return localStorage.setItem("blog-theme", localStorage.getItem("blog-theme") === 'dark' ? 'light' : 'dark');
    } 

})();