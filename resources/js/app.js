/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.addEventListener("load", ready);

function ready() {
    setupDropdowns();
    setupExpands();
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

function setupExpands() {
    const expands = document.querySelectorAll(".expand");

    if (expands.length > 0) {
        expands.forEach(expand => {
            const trigger = expand.querySelector(".expand-trigger");

            if (trigger == null) {
                return;
            }

            trigger.addEventListener("click", () => {
                expand.classList.toggle("open");
            });
        });
    }
}
