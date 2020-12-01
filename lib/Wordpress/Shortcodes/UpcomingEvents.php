<?php
/**
 * Example Shortcode Class for displaying upcoming events
 * 
 * 
 * @since 1.0.0
 */

namespace Contexis\Wordpress\Shortcodes;

use Timber\{
    Timber,
    PostQuery
};

class UpcomingEvents extends \Contexis\Wordpress\Shortcode {

    public $shortcodeName = "ctx-upcoming-events";

    public array $attributes = [
        'categories' => false,
        'audience' => false,
        'tags' => false,
        'limit' => 12,
        'tags' => '',
        'order' => 'asc',
        'largecolumns' => 1,
        'mediumcolumns' => 1,
        'smallcolumns' => 1,
    ];

    public function __construct() {
        parent::__construct();
    }


    public function init($props) {
        $this->attributes = shortcode_atts( $this->attributes, $props );


        $twig_data = [
            "events" => $this->get_events($this->attributes['limit']),
            "attributes" => $this->attributes
        ];
        
        return $this->render($twig_data);
    }

    private function get_events() {
        
        
        $categories = $this->attributes['categories'] ? preg_split("/[\s,|;]+/", $this->attributes['categories']) : false;
        $tags = $this->attributes['tags'] ? preg_split("/[\s,|;]+/", $this->attributes['tags']) : false;
        $audience = $this->attributes['audience'] ? preg_split("/[\s,|;]+/", $this->attributes['audience']) : false;
        
        $taxonomy = array();
        if($categories) {
            array_push($taxonomy, [
                'taxonomy' => 'event-categories',
                'field' => 'slug',
                'terms' => $categories
            ]);
        }

        if($tags) {
            array_push($taxonomy, [
                'taxonomy' => 'event-tags',
                'field' => 'slug',
                'terms' => $tags
            ]);
        }

        if($audience) {
            array_push($taxonomy, [
                'taxonomy' => 'event-tags',
                'field' => 'slug',
                'terms' => $audience
            ]);
        }
        
        return new PostQuery([
            'post_type' => 'event',
            'orderby' => '_event_start_date',
            'order' => strtoupper($this->attributes["order"]),
            'posts_per_page' => $this->attributes["limit"],
            'tax_query' => $taxonomy,
            'meta_query' => array(
                array(
                  'key' => '_event_start_date',
                  'value' => date('Y-m-d'),
                  'compare' => '>=',
                )
              )
        ]);
    }

    private function get_categories(string $categories) {
        
    }

    private function get_template() {
        return <<<EOD
            <div class="grid gap-8 grid-cols-{{attributes.smallcolumns}} md:grid-cols-{{attributes.mediumcolumns}} xl:grid-cols-{{attributes.largecolumns}}">
                {% for item in events %}
                    <a class="mb-4 flex {% for term in item.get_terms() %}{{term.slug}} {% endfor %}" href="/aktuell/{{item.post_name}}">
                        
                        <img src="{{ item.thumbnail.src('qsmall') }}" width="100px" class="rounded-tl-md rounded-br-md w-24 h-24">
                        
                        <div class="pl-4">
                            <h5 class="font-bold">{{item.title}}</h5>
                            <div class="text-mediumgray">{{item._event_start_date|date("j. F Y")}}</div>
                            {% if item.post_excerpt is not empty %}
                                <span>{{item.post_excerpt|excerpt(20)}}</span><br/>
                            {% endif %}
                            
                        </div>
                    </a>
                {% endfor %}
            </div>
        EOD;
    }

    public function render($context) {
        return Timber::compile_string($this->get_template(), $context);
    }
}

