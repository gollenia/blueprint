<?php

namespace Contexis\Wordpress;

/**
 * Generates an Array with parent Pages
 * Needs rewrite because Timbewr is missing
 * Move to Bricks
 * 
 * @since 1.0.0
 */
Class Breadcrumbs {

    private array $breadcrumbs = [];

    private $post;

    public static function generate(bool $add_current_page = true) {

        $instance = new static();

        if(method_exists($instance, 'generate_' . get_post_type())) {
            call_user_func([$instance, 'generate_' . get_post_type()]);
        }

        if (!$add_current_page || is_front_page()) {
            return $instance->breadcrumbs;
        }
        
        array_push($instance->breadcrumbs, [
            "title" => $instance->post->post_title,
            "url" => $instance->post->slug
        ]);

        return $instance->breadcrumbs;
    } 

    function generate_event() {
        $this->breadcrumbs = [
            [
                "title" => ucFirst(get_option("dbem_cp_events_slug")),
                "url" => "/" . get_option("dbem_cp_events_slug")
            ]
        ];

        if($this->post->terms) {
            array_push($this->breadcrumbs, [
                "title" => $this->post->terms[0]->name,
                "url" => "/" . get_option("dbem_cp_events_slug") . "/#" . $this->post->terms[0]->slug
            ]);
        }
    }

    function generate_page() {
        if ( is_front_page() ) {
            return;
        }
    
        if ( !$this->post->parent ) 
        {
            return;
        }

        $parent = $this->post->parent;
        
        while ($parent) {
            array_unshift($this->breadcrumbs, ["title" => $parent->title,"url" => $parent->link]);
            $parent = $parent->parent;
        }
        
    }

    function generate_post() {
        if ( is_single() ) {
            
            $slug = explode("/", ltrim(get_option("permalink_structure"), '/'))[0];
            if($this->post->terms) {
                array_push($this->breadcrumbs, ["title" => $this->post->terms[0]->name, "url" => get_category_link($this->post->terms[0]->id)]);
            }
            
            array_unshift($this->breadcrumbs, ["title" => ucfirst($slug),"url" => $slug]);
        }
        
    }

    function generate_category() {   
        if ( is_category()) {
            $this->breadcrumbs = get_ancestors($this->post->ID);
        }
        
    }
}