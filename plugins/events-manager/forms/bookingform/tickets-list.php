<?php 
/* 
 * This file generates a tabular list of tickets for the event booking forms with input values for choosing ticket spaces.
 * If you want to add to this form this, you'd be better off hooking into the actions below.
 */
/* @var $EM_Event EM_Event */
global $allowedposttags;
$EM_Tickets = $EM_Event->get_bookings()->get_tickets(); //already instantiated, so should be a quick retrieval.
EM_Bookings::enqueue_js();
/*
 * This variable can be overridden, by hooking into the em_booking_form_tickets_cols filter and adding your columns into this array.
 * Then, you should create a em_booking_form_tickets_col_arraykey action for your collumn data, which will pass a ticket and event object.
 */
$columns = $EM_Tickets->get_ticket_columns(); //array of column type => title
?>
<table class="em-tickets mt-4 w-full bg-default-darker" cellspacing="0" cellpadding="0">
	<tr>
		<?php 
		foreach($columns as $type => $name) {
			echo '<th class="text-' . ($type == 'type' ? 'left' : 'right') . ' em-bookings-ticket-table-' . $type . '">' . $name . '</th>';
		}
		?>
	</tr>
	<?php foreach( $EM_Tickets->tickets as $EM_Ticket ): /* @var $EM_Ticket EM_Ticket */ ?>
		<?php if( $EM_Ticket->is_displayable() ): ?>
			<?php do_action('em_booking_form_tickets_loop_header', $EM_Ticket); //do not delete ?>
			<tr class="em-ticket" id="em-ticket-<?php echo $EM_Ticket->ticket_id; ?>">
				<?php foreach( $columns as $type => $name ): ?>
					<?php
					//output column by type, or call a custom action 
					
					switch($type){
						case 'type':
							?>
							<td class="py-2 em-bookings-ticket-table-type"><?php echo wp_kses_data($EM_Ticket->ticket_name); ?><?php if(!empty($EM_Ticket->ticket_description)) :?><br><span class="ticket-desc"><?php echo wp_kses($EM_Ticket->ticket_description,$allowedposttags); ?></span><?php endif; 
							if($EM_Ticket->get_price(false) == 0) {
								echo '<span class="bg-green-500 text-white px-2 py-1 rounded-tl-lg rounded-br-lg ml-4">gratis</span>';
							}
							
							?></td>
							<?php
							break;
						case 'price':
								// dirty hack, but since we need only 2 currencies at the moment, it's ok
								$currency = (get_option('dbem_bookings_currency') == "EUR") ? "€" : "Fr.";
								echo '<td class="py-2 em-bookings-ticket-table-price text-right ">';
								echo '<span>' . $currency . ' </span><span class="inline-block" x-text="(ticketCount' . $EM_Ticket->ticket_id . ' * ' . $EM_Ticket->get_price(false) . ').toFixed(2)"></span>';
								echo '</td>';
							
							break;
						case 'spaces':
							?>
							<td class="text-right">
							<div class="number-picker">
							<?php							 
									$min=0;
									$max = ($EM_Ticket->ticket_max > 0) ? $EM_Ticket->ticket_max:get_option('dbem_bookings_form_max');
									if( $EM_Ticket->get_event()->event_rsvp_spaces > 0 && $EM_Ticket->get_event()->event_rsvp_spaces < $max ) $max = $EM_Ticket->get_event()->event_rsvp_spaces;
									if($EM_Ticket->is_required()) { $min = 1; }
									$default = !empty($_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']) ? $_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']:0;
									$spaces_options = '<button 
										:class="{\'bg-gray-200\': ticketCount' . $EM_Ticket->ticket_id . ' <= ' . $min . ', \'bg-primary text-white\': ticketCount' . $EM_Ticket->ticket_id . ' > ' . $min . '}" 
										class="rounded-tl-xl rounded-br-none font-bold text-large py-1 px-2" 
										x-bind:disabled="ticketCount' . $EM_Ticket->ticket_id . ' <= ' . $min . '" 
										@click.prevent="ticketCount' . $EM_Ticket->ticket_id . '--"></button>';
									$spaces_options .= '<input class="w-8 p-1 bg-gray-100 text-center" x-on:load="ticketCount' . $EM_Ticket->ticket_id . ' = ' . $min . '" type="text" min="' . $min . '" max="' . $max . '" name="em_tickets[' . $EM_Ticket->ticket_id . '][spaces]" class="em-ticket-select" x-model="ticketCount' . $EM_Ticket->ticket_id . '" id="em-ticket-spaces-' . $EM_Ticket->ticket_id . '">';
									$spaces_options .= '<button 
										:class="{\'bg-gray-200\': ticketCount' . $EM_Ticket->ticket_id . ' >= ' . $max . ', \'bg-primary text-white\': ticketCount' . $EM_Ticket->ticket_id . ' < ' . $max . '}" 
										class="rounded-br-xl rounded-tl-none font-bold text-large py-1 px-2" 
										x-bind:disabled="ticketCount' . $EM_Ticket->ticket_id . ' >= ' . $max . '" 
										@click.prevent="ticketCount' . $EM_Ticket->ticket_id . '++"></button>';
									echo ( $spaces_options ) ? $spaces_options:"<strong>".__('N/A','events-manager')."</strong>";
								?>
							</div>
							</td>
							<?php
							break;
						default:
							do_action('em_booking_form_tickets_col_'.$type, $EM_Ticket, $EM_Event);
							
							break;
					}
					?>
				<?php endforeach; ?>
			</tr>		
			<?php do_action('em_booking_form_tickets_loop_footer', $EM_Ticket); //do not delete ?>
		<?php endif; ?>
	<?php endforeach; ?>
	

</table>
<?php

echo '<div class="mt-4 pt-4 border-t-4 justify-between border-dotted border-gray-400 flex"><div class="font-bold" colspan="2">Gesamtpreis</div><div class="text-right"><span class="inline-block text-right font-bold" x-text="(';
		$firstLoop = true;
		foreach( $EM_Tickets->tickets as $key => $EM_Ticket ) {
					
			if(!$firstLoop) {
			  echo ' + ';	
			}
			echo '(ticketCount' . $EM_Ticket->ticket_id . ' * ' . $EM_Ticket->get_price(false) . ')';
			$firstLoop = false;
		}
		echo ').toFixed(2)"></span></div></div>'
	
	?>