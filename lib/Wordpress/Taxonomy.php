<?php
/**
 * Load Taxonomies from Array and add them to Wordpress
 * 
 * @since 1.0.0
 */

namespace Contexis\Wordpress;

Class Taxonomy {

    public static function register($taxonomies) {

    if($taxonomies === null) { return; }

    
		add_action('init', function() use (&$taxonomies){
      var_dump("sdfsdf");
			foreach ($taxonomies as $taxonomy => $options) {
                var_dump($options);
                register_taxonomy($taxonomy, $options['object_type'], $options['options']);	
            }	
		});
    }
    
}