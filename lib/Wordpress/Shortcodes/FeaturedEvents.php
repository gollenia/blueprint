<?php

namespace Contexis\Wordpress\Shortcodes;

class FeaturedEvents extends \Contexis\Wordpress\Shortcode {

    public $shortcodeName = "featured_events";

    public function __construct() {
        parent::__construct();
    }

    private function query() {

    }

    public function render($props) {

        $attributes = shortcode_atts( array(
            'title' => "News",
            'limit' => 4,
            'more' => '',
            'cols' => '2'
         ), $props );
        
        return "<h1>Bruuuuuhuhuhuhuha</h1>";
    }
}

