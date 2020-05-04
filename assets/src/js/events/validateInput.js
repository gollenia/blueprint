export default function validateInput (event) {
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