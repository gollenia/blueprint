<?php

namespace Contexis\Wordpress;

Class Block {

    public static function register($post_types) {

      if($post_types === null) { return; }
        
		add_filter('allowed_block_types', function() use (&$post_types){
			foreach ($post_types as $post_type => $allowed_blocks) {
                global $post;
                if($post->post_type == $post_type) {
                    return $allowed_blocks;
                }
            }	
		});
    }
    
}