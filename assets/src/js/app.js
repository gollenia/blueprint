import validateInput from "./validity.js";
import  './booking.js';

const event = new Event('manualvalid');

document.addEventListener("focusout", validateInput);
document.addEventListener("change", validateInput);

