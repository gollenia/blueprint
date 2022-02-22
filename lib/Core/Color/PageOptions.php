<?php

namespace Contexis\Core\Color;

class PageOptions {

    public $post_types = ['post', 'page', 'event'];
    public $colors = [];

    public static function register($colors) {
        $instance = new self;
        $instance->colors = $colors;
		add_action('init', array($instance, 'register_meta') );
        add_filter( 'ctx_page_colors', array($instance, 'get_page_colors'), 1, 2 );
    }

	/**
	 * Register the post metadata for post, page and event
	 *
	 * @since 1.7
	 * @return void
	 */
	public static function register_meta() {
		
			register_post_meta( '', 'page_colors', [
				'type' => 'object',
				'show_in_rest' => ['schema' => [
					'type'  => 'object',
					'properties' => [
						'primary_color' => ['type' => 'string'],
						'secondary_color' => ['type' => 'string'],
					]
				]],
				'single'       => true,
				'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
				}
			]);
		
    }

	/**
	 * Filter function to swap primary and secopndary colors with meta settings
	 * if existant. There could be a bit more of encapsulation...
	 *
	 * @param array $colors
	 * @return array $colors
	 */
    public static function get_page_colors($colors) {
        
        global $post;

        if(!$post) {
            return $colors;
        }

        $color_meta = get_post_meta( $post->ID, 'page_colors', true );

		$colors['primary-page']['color'] = $colors['primary']['color'];
		$colors['secondary-page']['color'] = $colors['secondary']['color'];

        if(isset($color_meta['primary_color'])) {
            $colors['primary-page']['color'] = $color_meta['primary_color'];
        }
        
        if(isset($color_meta['secondary_color'])) {
            $colors['secondary-page']['color'] = $color_meta['secondary_color'];
        }

		$colors['primary-page']['light'] = \Contexis\Core\Color::get_brightness($colors['primary-page']['color']);
		$colors['secondary-page']['light'] = \Contexis\Core\Color::get_brightness($colors['primary-page']['color']);
		
        return $colors;
    }
}