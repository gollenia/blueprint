import UIkit from 'uikit';
import addTicketLabel from './addTicketLabel';
import validateInput from './validateInput';

export default (function() {
	
	if (document.getElementsByClassName("em-tickets").length === 0) {
		return;
	}

	var ticketInfo = document.createElement("tr");
	ticketInfo.innerHTML = '<td colspan="3"><h4 class="ctx-font-script">Sag uns zuerst, wer mitfährt</h4></td>';
	document.getElementsByClassName('em-tickets')[0].prepend(ticketInfo);

	var personInfo = document.createElement("div");
	personInfo.innerHTML = '<h4 class="ctx-font-script">Gib dann deine Bestelldaten an</h4>';
	document.getElementsByClassName('em-booking-form-details')[0].prepend(personInfo);

	document.addEventListener("focusout", validateInput);
	document.addEventListener("change", validateInput);
	document.addEventListener("change", addTicketLabel);

	// We need old jQuery since jQuery-Events are not seen by vanilla JavaScript
	jQuery(document).on('em_booking_error', function(error){
		UIkit.notification(EM.bb_error, {status:'danger'});
	});

	jQuery(document).on('em_booking_success', function(error){
		UIkit.modal("#booking-modal").hide();
		UIkit.notification(EM.bb_booked, {status:'success'});
	}); 
})();