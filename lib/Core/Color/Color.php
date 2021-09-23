<?php

namespace Contexis\Core\Color;

class Color {

    public $colors;

    public static function register() {
        PostType::register();
        Options::register();

        

        PageOptions::register();

        
    }    

    public static function get() {
        return array_merge(Options::get(), PostType::get());
        
    }


    public static function swap_page_colors($colors) {
        
        global $post;

        $color_meta = get_post_meta( $post->ID, 'page_colors' );

        if(isset($color_meta['primary_color'])) {
            $colors[0]['color'] = $color_meta['primary_color'];
            $colors[0]['brightness'] = isset($color_meta['primary_color_brightness']) ? $color_meta['primary_color_brightness'] : (\Contexis\Core\Color\Utils::get_brightness($colors[0]['color']) < 170 ? "dark" : "light");
            $colors[0]['contrast'] = $colors[0]['brightness'] == "dark" ? "#ffffff" : '#000000';
        }
        
        if(isset($color_meta['secondary_color'])) {
            $colors[1]['color'] = $color_meta['secondary_color'];
            $colors[1]['brightness'] = isset($color_meta['secondary_color_brightness']) ? $color_meta['secondary_color_brightness'] : (\Contexis\Core\Color\Utils::get_brightness($colors[1]['color']) < 170 ? "dark" : "light");
            $colors[1]['contrast'] = $colors[0]['brightness'] == "dark" ? "#ffffff" : '#000000';
        }

        return $colors;

    }
}