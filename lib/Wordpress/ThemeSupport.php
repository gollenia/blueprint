<?php

namespace Contexis\Wordpress;

Class ThemeSupport {

    public static function register($theme_support) {
		add_action('after_setup_theme', function() use (&$theme_support){
            //\Contexis\Core\Utilities::debug($theme_support);
			foreach((array) $theme_support as $key => $value) {
				if(empty($value)) {
					add_theme_support( $key );
					continue;
				}
				add_theme_support( $key, $value );
			}		
		});
    }
    
}