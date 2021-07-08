<?php
/**
 * Special Controller for the EM-Events-Plugin. 
 * 
 * @since 1.0.0
 */
namespace Contexis\Controllers;


use Timber\{
    Timber,
    Post,
    PostQuery
};

use Contexis\Wordpress\Breadcrumbs;


class Event extends \Contexis\Core\Controller {

    private $event = false;

    /**
    * construct function collects information for page rendering
    * 
    * @param \Contexis\Core\Site $site Object
    * @param string $template 
    * @since 1.0.0
    */
    public function __construct($site, $template = false) {
        parent::__construct($site);
        $this->setTemplate('pages/event.twig'); 
        $post = Timber::get_post();

        if(class_exists("\EM_Events")) {
            $this->event = \EM_Events::get(['post_id' => $post->id])[0];    
        }
        
        $this->addToContext([
            "booking" => $this->get_booking_form(),
            "events" => $this->get_related_events($post),
            "event" => $this->event,
            'currency' => $this->get_currency(),
            "price" =>$this->lowest_price(),
            "bookings" => $this->remaining_spaces(),
            "breadcrumbs" => Breadcrumbs::generate(),
            "content" => do_blocks($post->post_content)
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
        $post = Timber::get_post();
        $content = apply_filters( 'the_content', $post->post_content );
        return $content;
    }

    /**
     * Retrive remaining booking spaces for event
     * 
     * @return integer
     * @since 1.2.0
     */
    private function remaining_spaces() {
        if(!class_exists("\EM_Bookings")) {
            return 0;
        }
        $booking = new \EM_Bookings($this->event);
        
        return $booking->get_available_spaces();
        
    }

    private function get_currency() {
        $currency = get_option("dbem_bookings_currency");
        if ($currency == "EUR") {
            return "€";
        }
        return $currency;
    }

    private function lowest_price() {
        $booking = new \EM_Bookings($this->event);
        $tickets = $booking->get_tickets();
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
     * @param Post $post current Post determines category and exclusion
     * @param int $limit max posts to fetch
     * @return PostQuery Object containing events
     * @since 1.0.0
     */
    private function get_related_events(Post $post, int $limit = 5) {

        $categories = $post->terms('event-categories');

        if(empty($categories)) {
            return false;
        }

        return new PostQuery([
            'post_type' => 'event',
            'orderby' => '_event_start_date',
            'order' => 'ASC',
            'posts_per_page' => $limit,
            'post__not_in' => [$post->ID],
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
        ]);
    }

}