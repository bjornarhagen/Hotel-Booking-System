/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.addEventListener("load", ready);

function ready() {
    setupDropdowns();
}

function setupDropdowns() {
    const dropdowns = document.querySelectorAll(".dropdown");

    if (dropdowns.length > 0) {
        dropdowns.forEach(dropdown => {
            const trigger = dropdown.querySelector(".dropdown-trigger");
            trigger.addEventListener("click", () => {
                dropdown.classList.toggle("open");
            });
        });
    }
}
