/*
*   simple event dispatcher that will forward  the jQuery em-booking-events to standars JavaScript Events
*
*
*/

export default (function() {

    var consentCheckbox = document.querySelector(".input-field-data_privacy_consent input");
    if(consentCheckbox) {
        var spanElement = document.createElement('span')
        spanElement.classList.add("checkbox-element");
        consentCheckbox.insertAdjacentHTML('afterend', "<span></span>");
    }

    jQuery(document).on('em_booking_error', function(event, message){
        var event = new CustomEvent('bookingerror', {
            bubbles: true,
            cancelable: true,
            detail: { message: message },
        });
        
        window.dispatchEvent(event);
    });

    jQuery(document).on('em_booking_success', function(event, message){
        var event = new CustomEvent('bookingsuccess', {
            bubbles: true,
            cancelable: true,
            detail: { message: message },
        });
        
        window.dispatchEvent(event);
        //UIkit.notification(EM.bb_booked, {status:'success'});
    });
})();