<?php
/**
 * Special Controller for the EM-Events-Plugin. 
 * 
 * @since 1.0.0
 */
namespace Contexis\Controllers;

use Contexis\Core\Color\Utils;
use Timber\Timber;

use WP_Error;

class Event extends \Contexis\Core\Controller {

    private $event = false;
    private $booking;

    public string $template = 'pages/event.twig';

    /**
    * construct function collects information for page rendering
    * 
    * @since 1.0.0
    */
    public function __construct() {
        
        if(!class_exists("\EM_Events") || !class_exists("\EM_Bookings")) {
            return new WP_Error( 'broke', __( "Event Manager Plugin not installed", "kids-team" ) );
        }
        
        parent::__construct();

        $events = \EM_Events::get(['post_id' => $this->context['post']->id]);

        if(empty($events)) {
            $this->template ="pages/404.twig";
            return;
        }

        $this->event = $events[0];
        $this->booking = new \EM_Bookings($this->event);
        

        \Contexis\Core\Utilities::debug($this->event);

        $this->add_to_context([
            
            "events" => $this->get_related_events(),
            "location" => $this->event->location_id != null ? \EM_Locations::get($this->event->location_id)[0] : false,
            "event" => $this->event,
            'currency' => em_get_currency_symbol(true,get_option("dbem_bookings_currency")),          
            "price" =>$this->lowest_price(),
            "bookings" => $this->booking->get_available_spaces(),
            "has_tickets" => $this->event->get_bookings()->get_available_tickets(),
            "speaker" => $this->get_speaker(),
            "booking" => \EM_Booking_Api::get_booking_form($this->event)
        ]);
        
    }

    

    
    /**
     * Render the content, which should only contain the booking form
     * This is not good stuff and should be changed
     * 
     * @return string HTML-Text with booking-form
     * @since 1.0.0
     */
    private function get_booking_form() {
        ob_start();
        em_locate_template('placeholders/bookingform.php', true, array('EM_Event'=>$this->event));
        return ob_get_clean();
    }

    private function get_speaker() {

        if($this->event->speaker_id == 0) {
            return false;
        }
        $args = [
            'p' => $this->event->speaker_id,
            'post_type' => 'event-speaker'
        ];

        $speaker = Timber::get_posts( $args );
        
        if ($speaker) {
            return $speaker[0];
        }

        return false;
    }

    /**
     * Get lowest price
     * 
     * @return float Price
     * @since 1.2.0
     */
    private function lowest_price() {
        $tickets = $this->booking->get_tickets();
        if(empty($tickets->tickets)) {
            return 0;
        }

        $price_array = [];
        foreach($tickets as $ticket) {
            array_push($price_array, floatval($ticket->ticket_price));
        }
        if(max($price_array) == 0) {
            return 0;
        }
        return min($price_array);
    }

    /**
     * Collect events from the same category as the current event 
     * 
     * @param int $limit max posts to fetch
     * @return Object containing events
     * @since 1.0.0
     */
    private function get_related_events(int $limit = 5) {

        $categories = $this->context['post']->terms('event-categories');

        if(empty($categories)) {
            return false;
        }

        $args = [
            'post_type' => 'event',
            'orderby' => '_event_start_date',
            'order' => 'ASC',
            'posts_per_page' => $limit,
            'post__not_in' => [$this->context['post']->ID],
            'tax_query' => [
                [
                    'taxonomy' => 'event-categories',
                    'field' => 'slug',
                    'terms' => $categories[0]->slug,
                ]
            ],
            'meta_query' => [
                [
                  'key' => '_event_start_date',
                  'value' => date('Y-m-d'),
                  'compare' => '>=',
                ]
            ]
        ];

        return Timber::get_posts( $args );
        
    }

}