<?php

namespace Contexis\Wordpress;

use Timber\{
    Post,
    Term
};

/**
 * Generates an Array with parent Pages
 * 
 * @since 1.0.0
 */
Class Breadcrumbs {
    public static function generate() {
    
        if ( is_home() && is_front_page() || is_paged() ) {
            return false;
        }
    
        $post = new Post();

        $breadcrumbs = [];
        
        if ( is_category()) {
            $breadcrumbs = get_ancestors($post->ID);
        }

    
        if ( is_single() ) {
            $term = $post->terms[0];
            
            $slug = explode("/", ltrim(get_option("permalink_structure"), '/'))[0];

            $breadcrumbs = [];

            if($post->terms) {
                array_push($breadcrumbs, ["title" => $post->terms[0]->name, "url" => $post->terms[0]->slug]);
            }
            
            while($term->parent) {
                $term = new Term($term->parent);
                array_unshift($breadcrumbs, ["title" => $term->name,"url" => $term->slug]);
            }

            array_unshift($breadcrumbs, ["title" => ucfirst($slug),"url" => $slug]);
                       

            array_push($breadcrumbs, ["title" => $post->name, "url" => $post->link]);
        }
        if ( is_page() && !$post->parent ) 
        {
            $breadcrumbs = [[
                "title" => $post->title,
                "url" => $post->link
            ]];
        } 
        
        if ( is_page() && $post->post_parent ) {
            $parent = $post->parent;

            $breadcrumbs = [[
                "title" => $post->title,
                "url" => $post->link
            ]];
            
            while ($parent) {
                array_unshift($breadcrumbs, ["title" => $parent->title,"url" => $parent->link]);
                $parent = $parent->parent;
            }
        }

        if( is_singular('event') ) {
            $breadcrumbs = [
                [
                    "title" => ucFirst(get_option("dbem_cp_events_slug")),
                    "url" => "/" . get_option("dbem_cp_events_slug")
                ],
                [
                    "title" => $post->title,
                    "url" => $post->link
                ]
            ];
        }

        return $breadcrumbs;
    } 
}