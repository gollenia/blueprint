import validateInput from "./validity.js";
import  './booking.js';
import  './menu.js';



document.addEventListener("focusout", validateInput);
document.addEventListener("change", validateInput);


document.addEventListener('click', (event) => {
    document.querySelectorAll('.menu__item--has-dropdown').forEach((element) => {
        element.classList.remove("menu__item--open");
    });
})



