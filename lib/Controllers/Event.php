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
use EM_Events;
use EM_Event;
use EM_Bookings;


class Event extends \Contexis\Core\Controller {

    
    private EM_Event $event;

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

        $this->event = EM_Events::get(['post_id' => $post->id])[0];
        
        $this->addToContext([
            "booking" => $this->get_booking_form(),
            "events" => $this->get_events($post),
            "event" => EM_Events::get(['post_id' => $post->id])[0],
            "bookings" => $this->remaining_spaces(),
            "breadcrumbs" => Breadcrumbs::generate(),
            "content" => do_blocks($post->post_content)
        ]);
    }

    


    private function get_booking_form() {
        $post = Timber::get_post();
        
        $content = apply_filters( 'the_content', $post->post_content );
        
        return $content;
        
    }

    private function remaining_spaces() {
        $booking = new EM_Bookings($this->event);
        return $booking->get_available_spaces();
    }

    /**
     * Collect events from the same category as the current event 
     * 
     * @param array $options Array with ACF Fields and Pages
     * @since 1.0.0
     */
    private function get_events(Post $post, int $limit = 5) {

        $categories = $post->terms('event-categories');

        if(empty($categories)) {
            return false;
        }

        
        
        return new PostQuery([
            'post_type' => 'event',
            'orderby' => '_event_start_date',
            'order' => 'ASC',
            'post__not_in' => [$post->ID],
            'tax_query' => array(
                array (
                    'taxonomy' => 'event-categories',
                    'field' => 'slug',
                    'terms' => $categories[0]->slug,
                )
            ),
            'meta_query' => array(
                array(
                  'key' => '_event_start_date',
                  'value' => date('Y-m-d'),
                  'compare' => '>=',
                )
              )
        ]);
    }

}