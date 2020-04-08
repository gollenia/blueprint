<?php

namespace Contexis\Wordpress;

Class Widgets {

    public static function register($widgets) {
        
		add_action('widgets_init', function() use (&$widgets){
			foreach ($widgets as $area) {
                register_sidebar($area);	
            }	
		});
    }
    
}