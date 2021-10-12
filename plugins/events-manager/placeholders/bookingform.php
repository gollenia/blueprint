<?php  


/* @var $EM_Event EM_Event */   
global $EM_Notices;
//count tickets and available tickets
$tickets_count = count($EM_Event->get_bookings()->get_tickets()->tickets);
$available_tickets_count = count($EM_Event->get_bookings()->get_available_tickets());
//decide whether user can book, event is open for bookings etc.
$can_book = is_user_logged_in() || (get_option('dbem_bookings_anonymous') && !is_user_logged_in());
$show_tickets = true;
$multiple_tickets = $show_tickets && ($can_book || get_option('dbem_bookings_tickets_show_loggedout')) && ($tickets_count > 1 || get_option('dbem_bookings_tickets_single_form'));
$single_ticket = $show_tickets && $available_tickets_count == 1 && !get_option('dbem_bookings_tickets_single_form');
$EM_Tickets = $EM_Event->get_bookings()->get_tickets();
?>

<div class="">
<?php echo $EM_Notices; ?>
</div>

<div  
	@booking-modal.window="showModal = true" 
    @keyup.escape.window="showModal = false"
    @bookingsuccess.window="bookingSuccess = true"
    @bookingpending.window="bookingPending = true"
    @bookingerror.window="bookingError = true"
    :class="{'bg-gray-100 overflow-y-auto': !bookingSuccess, 'bg-red-500 text-white': bookingError,  }"
    class="modal modal--fullscreen"
    style="display: none"
    <?php 
        echo ' x-data="{bookingPending: false, bookingError: false, bookingSuccess: false, showModal: false, ';
            foreach( $EM_Tickets->tickets as $EM_Ticket ) {
                echo "ticketCount";
                echo $EM_Ticket->ticket_id;
                echo ' : ';
                echo $EM_Ticket->is_required() ? '1, ' : '0, ';
                echo "ticketPrice";
                echo $EM_Ticket->ticket_id;
                echo ' : 0, ';
            }
            echo '}"';
        
    ?>
    x-show="showModal" id="em-booking"
>
    <div class="modal__dialog" :class="{'overflow-auto': !bookingSuccess || !bookingError }">
	
       
		<?php if( $tickets_count > 0) : ?>
			
			<div class="modal__header">
                <button class="close" @click="showModal = false"></button>
                <div class="modal__title">
                    <h2 :class="{'px-4 lg:px-8': !bookingSuccess }" class="text-2xl py-8 lg:text-5xl"><?php echo __("Booking for", "em-pro") . " " . $EM_Event->name; ?></h2>
                </div>
            </div>
            <div x-show="bookingPending && !bookingSuccess" class="absolute inset-0" style="background: #ffffffbb">
                Bite warten
            </div>
            <form class="modal__content em-booking-form grid xl:grid--columns-2 gap-12" name='booking-form' method='post' action='<?php echo apply_filters('em_booking_form_action_url',''); ?>#em-booking'>
                <div class="bg-white p-4 rounded-tl-lg lg:p-8">
                    <h3 class="py-3"><?php _e("Select your tickets first", "em-pro") ?></h4>
                    <?php do_action('em_booking_form_header', $EM_Event); ?>
                    <input type='hidden' name='action' value='booking_add'/>
                    <input type='hidden' name='event_id' value='<?php echo $EM_Event->get_bookings()->event_id; ?>'/>
                    <input type='hidden' name='_wpnonce' value='<?php echo wp_create_nonce('booking_add'); ?>'/>
                    <?php 
                        if( $multiple_tickets ){ 
                            do_action('em_booking_form_before_tickets', $EM_Event);
                            em_locate_template('forms/bookingform/tickets-list.php',true, array('EM_Event'=>$EM_Event));
                            do_action('em_booking_form_after_tickets', $EM_Event); //do not delete
                            $show_tickets = false;
                        } else {
                            do_action('em_booking_form_before_tickets', $EM_Event); //do not delete
                            $EM_Ticket = $EM_Event->get_bookings()->get_available_tickets()->get_first();
                            em_locate_template('forms/bookingform/ticket-single.php',true, array('EM_Event'=>$EM_Event, 'EM_Ticket'=>$EM_Ticket));
                            do_action('em_booking_form_after_tickets', $EM_Event); //do not delete
                        }
                    ?>
                </div>
				
                <div class='em-booking-form-details bg-white p-4 lg:p-8'>
                <h3 class="py-3"><?php _e("Tell us, who you are", "em-pro") ?></h4>
                    <?php
                        do_action('em_booking_form_before_user_details', $EM_Event);
                        apply_filters('em_booking_form_custom', $EM_Event); //do not delete
                        do_action('em_booking_form_after_user_details', $EM_Event);
                    ?>
                    <?php do_action('em_booking_form_footer', $EM_Event); //do not delete ?>
                    <div class="text-right em-booking-buttons">
                        <input x-show="!bookingPending" x-ref="submitButton" type="submit" class="invalid <?php if(is_admin()) echo 'button bg-primary '; ?>em-booking-submit" id="em-booking-submit" value="<?php echo esc_attr(get_option('dbem_bookings_submit_button')); ?>" />							
                        
                    </div>
                    <?php do_action('em_booking_form_footer_after_buttons', $EM_Event); //do not delete ?>
                </div>
				
			</form>	
            </div>
            <div class="text-right pt-10 mx-auto max-w-screen-xl" x-show="bookingSuccess"><a href="#" @click="showModal = false" class="px-4 py-2 border-2 border-white text-white text-lg">Schließen</a></div>
            <div class="text-right pt-10 mx-auto max-w-screen-xl" x-show="bookingError"><a href="#" @click="showModal = false" class="px-4 py-2 border-2 border-white text-white text-lg">Schließen</a></div>

		<?php endif; ?>

	<?php
	do_action('em_booking_form_bottom', $EM_Event);
	?>
</div>
