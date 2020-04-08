<?php

namespace Contexis\Wordpress;

Class Taxonomy {

    public static function register($taxonomies) {
        
		add_action('init', function() use (&$taxonomies){
			foreach ($taxonomies as $taxonomy => $options) {
                register_taxonomy($taxonomy, $options['object_type'], $options['options']);	
            }	
		});
    }
    
}