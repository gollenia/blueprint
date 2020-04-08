<?php

namespace Contexis\Wordpress;

Class Mime {

    public static function register($new_mimes) {
        $mimes = wp_get_mime_types();

        

        foreach($new_mimes['remove'] as $key) {
            unset($mimes[$key]);
        }

        foreach($new_mimes['add'] as $key => $value) {
            $mimes[$key] = $value;
        }

		add_filter('mime_types', function() use (&$mimes){
            return $mimes;
		});
    }
    
}