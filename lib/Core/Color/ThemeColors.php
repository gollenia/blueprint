<?php
/**
 * Functions to get an array of theme colors.
 * 
 * @since 1.5.0
 */

namespace Contexis\Core\Color;

use Timber\Timber;

class ThemeColors {

    public static function get() {
        $colors = array_merge(self::get_base_colors(), self::get_custom_colors());
        apply_filters( 'create_color_array', $colors );
        return $colors;
    }

    private static function get_base_colors() {
        $base_colors = get_option('ctx_base_color_options');
        $colors = [];
        foreach ($base_colors as $slug => $color) {
            $brightness = \Contexis\Core\Color\Utils::get_brightness($color) < 170 ? "dark" : "light";
            array_push($colors, [
                    "slug" => $slug,
                    "name" => __(ucfirst($slug) . ' Color', 'ctx-theme'),
                    "color" => $color,
                    "brightness" => $brightness,
                    "contrast" => $brightness == "dark" ? "#ffffff" : "#000000"
            ]);
        }
        return $colors;
    }

    private static function get_custom_colors() {
        $args = [
            'post_type' => 'ctx-color-palette'
        ];

        $color_posts = Timber::get_posts( $args );
        
        $colors = [];
        foreach ($color_posts as $color) {
            $brightness = $color->meta('brightness') == "auto" && $color->meta('computed_brightness') ? $color->meta('computed_brightness') : $color->meta('brightness');
            array_push($colors, [
                    "slug" => $color->post_name,
                    "name" => $color->post_title,
                    "color" => $color->meta('color'),
                    "brightness" => $brightness,
                    "contrast" => $brightness == "dark" ? "#ffffff" : "#000000"
            ]);
        }
        
        return $colors;
    }

}
    

    
	

