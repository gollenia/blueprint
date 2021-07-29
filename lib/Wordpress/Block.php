<?php

namespace Contexis\Wordpress;

/**
 * Load allowed Gutenberg blocks for page types from config
 * 
 * @param array $post_types 
 * @since 1.0.0
 */
Class Block {

    public static function register($post_types) {

      if($post_types === null) { return; }
        
		add_filter('allowed_block_types_all', function() use (&$post_types){
			foreach ($post_types as $post_type => $allowed_blocks) {
                global $post;
                if($post->post_type == $post_type) {
                    return $allowed_blocks;
                }
            }	
		});
    }
    
}