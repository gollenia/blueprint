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
<div  
	@booking-modal.window="showModal = true" 
	x-on:keydown.escape="showModal = false"
    class="fixed inset-0 bg-lightgray-lighter overflow-y-auto h-screen em-booking"
    <?php 
        echo ' x-data="{showModal: false, ';
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
    <div class="overflow-auto">
	<span @click="showModal=false" class="fixed right-0 top-0">
		X
	</span>

	
        <?php echo $EM_Notices; 
                     
        ?>
		<?php if( $tickets_count > 0) : ?>
			
			<div class="max-w-screen-xl mt-4 mx-auto flex flex-col content-center">
            <div>
                <h2 class="pl-8"><?php echo __("Booking for", "em-pro") . " " . $EM_Event->name; ?></h2>
            </div>
            <form class="em-booking-form grid lg:grid-cols-2 mt-16 gap-8" name='booking-form' method='post' action='<?php echo apply_filters('em_booking_form_action_url',''); ?>#em-booking'>
                <div class="bg-white p-8">
                    <h3 class="font-script"><?php _e("Select your tickets first", "em-pro") ?></h4>
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
				
                <div class='em-booking-form-details bg-white p-8'>
                <h3 class="font-script"><?php _e("Tell us, who you are", "em-pro") ?></h4>
                    <?php
                        do_action('em_booking_form_before_user_details', $EM_Event);
                        do_action('em_booking_form_custom', $EM_Event); //do not delete
                        do_action('em_booking_form_after_user_details', $EM_Event);
                    ?>
                    <?php do_action('em_booking_form_footer', $EM_Event); //do not delete ?>
                    <div class="em-booking-buttons">
                        <input  x-ref="submitButton" type="submit" class="invalid <?php if(is_admin()) echo 'button-primary '; ?>em-booking-submit" id="em-booking-submit" value="<?php echo esc_attr(get_option('dbem_bookings_submit_button')); ?>" />							
                    </div>
                    <?php do_action('em_booking_form_footer_after_buttons', $EM_Event); //do not delete ?>
                </div>
				
			</form>	
			</div>

		<?php endif; ?>

	<?php
	do_action('em_booking_form_bottom', $EM_Event);
	?>
</div>
</div>