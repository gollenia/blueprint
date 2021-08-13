<?php
/**
 * Controller for EM-Events-Plugin to list all Events.
 * 
 * @since 1.0.0
 */

namespace Contexis\Controllers;

use Timber\Timber;

class Events extends \Contexis\Core\Controller {

    public string $template = 'pages/events.twig';
    
    public function __construct($template = false) {
        parent::__construct();
        $this->add_to_context([
            'events' => $this->get_events(),
            'terms' => $this->get_event_terms(),
            'slug' => get_option("dbem_cp_events_slug"),
        ]);
        
    }

    private function get_events() {
        
        $args = [
            'post_type' => 'event',
            'orderby' => '_event_start_date',
            'order' => 'ASC',
            'post_status' => ['publish'],
            'meta_query' => [
                [
                  'key' => '_event_start_date',
                  'value' => date('Y-m-d'),
                  'compare' => '>='
                ]
            ]
        ];

        return Timber::get_posts( $args );
    }

    private function get_event_terms() {
        return get_terms( array(
            'taxonomy' => 'event-categories',
            'hide_empty' => true,
        ) );
    }

}