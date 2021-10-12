<?php

namespace Contexis\Wordpress;

/**
 * Load allowed Gutenberg blocks for page types from config
 * 
 * @param array $block_types 
 * @since 1.0.0
 */
Class Block {

    public static function register($block_types) {

        if($block_types === null) { return; }
        
		add_filter('allowed_block_types_all', function($test) use (&$block_types){
            
			return $block_types;
		});
    }
    
}