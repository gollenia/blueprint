<?php

namespace Contexis\Wordpress;

/**
 * Now runs with react component
 * (see assets/src/js/admin/headerSettings.js)
 * 
 * @deprecated 2.1
 * @since 1.5.0a
 * @author Thomas Gollenia <thomas@gollenia.at>
 * 
 */
class Post {

    public static function register() {
		add_action('init', array('Contexis\Wordpress\Post', 'register_meta') );
    }

    public static function register_meta() {
		register_post_meta( '', 'header', [
			'type' => 'object',
			'show_in_rest' => ['schema' => [
				'type'  => 'object',
				'properties' => [
					'height' => [ 'type' => 'number'],
					'subtitle' => [ 'type' => 'string'],
					'link' => [
						'type' => 'object',
						'properties' => [
							'title' => [ 'type' => 'string'],
							'url' => [ 'type' => 'string']
						]
					],
					'image_position' => [ 'type' => 'number'],
					
			]]],
			'single'       => true,
			
			'auth_callback' => function() {
				return current_user_can( 'edit_posts' );
			}
		]);
    }


} 