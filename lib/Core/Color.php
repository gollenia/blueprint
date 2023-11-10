<?php
/**
 * Color Management Class
 * 
 * @since 1.6.0
 */

namespace Contexis\Core;

use Contexis\Core\Color\PageOptions;
use Contexis\Core\Color\PostType;

class Color {

    public $post_types = ['post', 'page', 'event'];

    /**
     * Create an instance. This is the static constructor method.
     *
     * @return Contexis\Core\Color
     *
     */
    public static function register() {
        $instance = new self;
		add_action('rest_api_init', array($instance, 'register_meta') );
		add_action('wp_head', [$instance, 'add_color_css']);
		add_action('admin_head', [$instance, 'add_color_css']);
        return $instance;
    }

	/**
	 * Add color settings to the page Head.
	 * 
	 * @return void
	 */
	function add_color_css() {
		$primary = $this->get_page_color();
		echo "<style>:root {";
			echo "--primary:" . $primary . ";";
			echo "--white: #fff;";
			echo "--black: #000;";
			echo "--primary-contrast: " . (self::get_brightness($primary) ? "var(--black)" : "var(--white)") . ";";
			echo "--primary-transparent: " . $primary . "aa;";
		echo "} </style>";
	}

	/**
	 * Register page color as Meta Data
	 * for backwards compatibility, we need to store it as an object
	 *
	 * @return void
	 */
	public function register_meta() {
		
		foreach($this->post_types as $post_type) {
			
			register_meta( $post_type, 'page_colors', [
				'type' => 'object',
				'show_in_rest' => ['schema' => [
					'type'  => 'object',
					'properties' => [
						'primary_color' => ['type' => 'string'],
					]
				]],
				'single'       => true,
				'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
				}
			]);
		}
		
    }


	/**
	 * Get page color from metadata or return default
	 *
	 * @return void
	 * @TODO How to handle default color?
	 */
	public function get_page_color() {
        
        global $post;

        if(!$post) {
            return "#fff";
        }

        $color_meta = get_post_meta( $post->ID, 'page_colors', true );
        if(isset($color_meta['primary_color'])) {
            return $color_meta['primary_color'];
        }
		
        return "#fff";
    }

	/**
     * Decide if a color is more dark or more light, e.g. to select a fitting contrast
     *
     * @param string $color hexadecimal color value
         * @param string $threshold adjust the threshold value when a color should e treated as bright
     * @return bool true for bright, false for dark
     */
    public static function get_brightness($color, $threshold = 170) {
        if(!preg_match('/#(?:[0-9a-fA-F]{6})/', $color)) {
            return false;
        }
        $color = str_replace('#', '', $color);
        $red = hexdec(substr($color, 0, 2));
        $green = hexdec(substr($color, 2, 2));
        $blue = hexdec(substr($color, 4, 2));

        return intval((($red * 299) + ($green * 587) + ($blue * 114)) / 1000) > $threshold;
    }
	

	

   


}





