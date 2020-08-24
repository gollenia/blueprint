

import UIkit from 'uikit';

import './../scss/app.scss';
window.UIkit = UIkit;




import textareaResize from './extras/textareaResize';
import  './events/bookingForm';
import  './contact/contactForm';
import  './icons';
import  './search';


UIkit.util.on('#mobile-menu', 'beforeshow', function (event) {
    if(event.target.id == "mobile-menu") {
        document.getElementById('hamburger').classList.add("is-active");
    }
});

UIkit.util.on('#mobile-menu', 'beforehide', function (event) {
    if(event.target.id == "mobile-menu") {
        document.getElementById('hamburger').classList.remove("is-active");
    }
});





textareaResize("textarea");


// var form  = document.getElementsByTagName('form')[0];
// form.addEventListener("change", function(event) {
//     var submitButton = document.querySelectorAll('input[type="submit"]');
//     console.log(event);
//     if(event.target.validity.valid){
//         submitButton[0].disabled = false;
//         return;
//     }
//     submitButton[0].disabled = true;
// });






