export default function validateInput (event) {
    var errorMessage = event.target.parentElement.querySelector(".error-message");
    if(errorMessage != undefined) {
        errorMessage.remove();
    }
    if(!event.target.required) {
        return;
    }
    if(event.target.validity.valid) {
        event.target.parentElement.classList.remove("error");
        return;
    }

    event.target.parentElement.classList.add("error");

    let span = document.createElement("span");
    span.classList.add("error-message");
    
    span.innerText = event.target.validationMessage;
    if(event.target.getAttribute("data-text-error")) {
        span.innerText = event.target.getAttribute("data-text-error");
    }
    
    event.target.parentNode.append(span);
    return;
}