<?php 
/* 
 * This file generates the input fields for an event with a single ticket and settings set to not show a table for single tickets (default setting)
 * If you want to add to this form this, you'd be better off hooking into the actions below.
 */
/* @var $EM_Ticket EM_Ticket */
/* @var $EM_Event EM_Event */
global $allowedposttags;
do_action('em_booking_form_ticket_header', $EM_Ticket); //do not delete
/*
 * This variable can be overridden, by hooking into the em_booking_form_tickets_cols filter and adding your collumns into this array.
 * Then, you should create a em_booking_form_ticket_field_arraykey action for your collumn data, which will pass a ticket and event object.
 */

$columns = $EM_Event->get_tickets()->get_ticket_columns(); //array of column type => title

foreach( $columns as $type => $name ): ?>
	<?php
    if(!$EM_Ticket) { continue; }
	//output collumn by type, or call a custom action 
	switch($type){
		case 'type':
			if(!empty($EM_Ticket->ticket_description)){ //show description if there is one
				?><p class="ticket-desc"><?php echo wp_kses($EM_Ticket->ticket_description,$allowedposttags); ?></p><?php
			}
			break;
		case 'price':
			?><div class="flex justify-between"><label><?php echo $name; ?></label><strong><?php echo $EM_Ticket != false ? $EM_Ticket->get_price(true) : 0; ?></strong></div><?php
			break;
		case 'spaces':
			if( $EM_Ticket->get_available_spaces() > 1 && ( empty($EM_Ticket->ticket_max) || $EM_Ticket->ticket_max > 1 ) ): //more than one space available ?>				
				<div class="flex justify-between">
					<label for='em_tickets'><?php echo $name; ?></label>
					<div class="py-2 text-right em-bookings-ticket-table-spaces flex justify-end">
					<?php 
						$min=0;
						$max = ($EM_Ticket->ticket_max > 0) ? $EM_Ticket->ticket_max:get_option('dbem_bookings_form_max');
						if( $EM_Ticket->get_event()->event_rsvp_spaces > 0 && $EM_Ticket->get_event()->event_rsvp_spaces < $max ) $max = $EM_Ticket->get_event()->event_rsvp_spaces;
						if($EM_Ticket->is_required()) { $min = 1; }
						$default = !empty($_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']) ? $_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']:0;
						$spaces_options = '<button :class="{\'bg-primary border-gray-200\': ticketCount' . $EM_Ticket->ticket_id . ' <= ' . $min . '}" class="rounded-tl-xl rounded-br-none font-bold text-large py-1 px-2 border-gray-200 text-large bg-gray-200" x-bind:disabled="ticketCount' . $EM_Ticket->ticket_id . ' <= ' . $min . '" @click.prevent="ticketCount' . $EM_Ticket->ticket_id . '--"><i class="material-icons">remove</i></button>';
						$spaces_options .= '<input class="w-8 p-1 border-2 border-gray-100 bg-gray-100 text-center" x-on:load="ticketCount' . $EM_Ticket->ticket_id . ' = ' . $min . '" type="text" min="' . $min . '" max="' . $max . '" name="em_tickets[' . $EM_Ticket->ticket_id . '][spaces]" class="em-ticket-select" x-model="ticketCount' . $EM_Ticket->ticket_id . '" id="em-ticket-spaces-' . $EM_Ticket->ticket_id . '">';
						$spaces_options .= '<button class="rounded-br-xl rounded-tl-none font-bold text-large py-1 px-2 text-large py-1 px-2 bg-gray-200" x-bind:disabled="ticketCount' . $EM_Ticket->ticket_id . ' >= ' . $max . '" @click.prevent="ticketCount' . $EM_Ticket->ticket_id . '++"><i class="material-icons">add</i></button>';
						echo ( $spaces_options ) ? $spaces_options:"<strong>".__('N/A','events-manager')."</strong>";
					?>
					</div>
				</div>
				<div class="flex justify-between"> 
					<?php
					echo '<span class="inline-block">' . __('Endprice') . '</span><span class="inline-block" x-text="(ticketCount' . $EM_Ticket->ticket_id . ' * ' . $EM_Ticket->get_price(false) ? $EM_Ticket->get_price(false) : "0" . ').toFixed(2)"></span>';
					?>
				</div>
				<?php do_action('em_booking_form_ticket_spaces', $EM_Ticket); //do not delete ?>
			<?php else: //if only one space or ticket max spaces per booking is 1 ?>
				<input type="hidden" name="em_tickets[<?php echo $EM_Ticket->ticket_id ?>][spaces]" value="1" class="em-ticket-select" />
				<?php do_action('em_booking_form_ticket_spaces', $EM_Ticket); //do not delete ?>
			<?php endif;
			break;
		default:
			do_action('em_booking_form_ticket_field_'.$type, $EM_Ticket, $EM_Event);
			break;
	}
endforeach; ?>
<?php do_action('em_booking_form_ticket_footer', $EM_Ticket); //do not delete ?>