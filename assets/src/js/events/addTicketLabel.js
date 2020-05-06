import calculatePrice from './calculatePrice';

export default function addTicketLabel(event) {
    

    if(!event.target.classList.contains("em-ticket-select")) {
        return;
    }

    [].forEach.call(document.querySelectorAll('.attendee-label'),function(e){
        e.parentNode.removeChild(e);
    });

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

    calculatePrice();
}
