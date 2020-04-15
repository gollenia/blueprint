<?php

namespace Contexis\Wordpress\Shortcodes;

class HelloWorld extends \Contexis\Wordpress\Shortcode {

    public $shortcodeName = "hello_world";

    public function __construct() {
        parent::__construct();
    }

    private function query() {

    }

    public function init($props) {
        $attributes = shortcode_atts( array(
            'title' => "Hallo",
            'href' => "www.test.de",
         ), $props );

         return $this->render($attributes);
    }

    public function render($attributes) {
        $template = '<a href={{attributes.href}}>{{attributes.title}}</a>';
        return \Timber\Timber::compile_string($template, array("attributes" => $attributes));
    }
}

