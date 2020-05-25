import UIkit from 'uikit';

import './../scss/app.scss';
window.UIkit = UIkit;



import addTicketLabel from './events/addTicketLabel';
import validateInput from './events/validateInput';
import textareaResize from './extras/textareaResize';
import contactFormInvalid from './contact/contactFormInvalid';



UIkit.util.on('#mobile-menu', 'beforeshow', function (event) {
    if(event.target.id == "mobile-menu") {
        document.getElementById('hamburger').classList.add("is-active");
    }
});

UIkit.util.on('#events-filter', 'afterFilter', function (event) {
    console.log(event);
});


UIkit.util.on('#mobile-menu', 'beforehide', function (event) {
    if(event.target.id == "mobile-menu") {
        document.getElementById('hamburger').classList.remove("is-active");
    }
});


document.addEventListener("focusout", validateInput);
document.addEventListener("change", validateInput);
document.addEventListener("change", addTicketLabel);
document.addEventListener("wpcf7invalid ", function(event) {
    UIkit.notification(event.detail.apiResponse.message, {status:'danger'});
});
document.addEventListener("wpcf7spam", function(event) {
    UIkit.notification(event.detail.apiResponse.message, {status:'danger'});
});
document.addEventListener("wpcf7mailsent", function(event) {
    UIkit.notification(event.detail.apiResponse.message, {status:'success'});
});
document.addEventListener("wpcf7mailfailed", function(event) {
    UIkit.notification(event.detail.apiResponse.message, {status:'danger'});
});
document.addEventListener("wpcf7submit", function(event) {
    UIkit.notification(event.detail.apiResponse.message, {status:'danger'});
});


document.addEventListener("em_booking_success", function(event) {
    console.log(event);
});

document.addEventListener("em_booking_error", function(event) {
    console.log(event);
});

document.addEventListener("em_booking_complete", function(event) {
    console.log(event);
});

document.addEventListener("em_booking_ajax_error", function(event) {
    console.log(event);
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






