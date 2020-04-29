import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

import boy from '../img/icons/boy.svg';
import calendar from '../img/icons/calendar.svg';


UIkit.use(Icons);


UIkit.icon.add("boy", boy);
UIkit.icon.add("calendar", calendar);



import './../scss/app.scss';
window.UIkit = UIkit;


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

function addTicketLabel(event) {
    [].forEach.call(document.querySelectorAll('.attendee-label'),function(e){
        e.parentNode.removeChild(e);
      });

    if(!event.target.classList.contains("em-ticket-select")) {
        return;
    }
    var attendees = document.getElementsByClassName("em-attendee-fields");
    if (attendees == undefined) {
        return;
    }
    for (let index = 0; index < attendees.length; index++) {
        let span = document.createElement("span");
        span.classList.add("attendee-label");
        span.innerText = index + 1 + ". Teilnehmer/in";
        attendees[index].prepend(span);
    }
}

function validateInput (event) {
    var errorMessage = this.querySelector(".error");
    if(errorMessage != undefined) {
        errorMessage.remove();
    }
    if(!event.target.required) {
        return;
    }
    if(event.target.validity.valid) {
        event.target.classList.remove("uk-form-danger");
        event.target.classList.add("uk-form-success");
        return;
    }

    event.target.classList.add("uk-form-danger"); 
    event.target.classList.remove("uk-form-success");
    
    let span = document.createElement("span");
    span.classList.add("error")
    span.innerText = event.target.validationMessage;
    event.target.parentNode.append(span);
    return;
}

var form  = document.getElementsByTagName('form')[0];
form.addEventListener("change", function(event) {
    var submitButton = document.querySelectorAll('input[type="submit"]');
    console.log(event);
    if(event.target.validity.valid){
        submitButton[0].disabled = false;
        return;
    }
    submitButton[0].disabled = true;
});


    document.querySelectorAll('textarea').forEach(function (element) {
      element.style.boxSizing = 'border-box';
      var offset = element.offsetHeight - element.clientHeight;
      document.addEventListener('input', function (event) {
        event.target.style.height = 'auto';
        event.target.style.height = event.target.scrollHeight + offset + 'px';
      });
      element.removeAttribute('data-autoresize');
    });


