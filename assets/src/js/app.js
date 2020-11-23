import validateInput from "./validity.js";
import  './booking.js';

document.addEventListener("focusout", validateInput);
document.addEventListener("change", validateInput);