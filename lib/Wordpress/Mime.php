<?php

namespace Contexis\Wordpress;

/**
 * Allow or disallow mime-types from Array
 * 
 * @param array $new_mimes
 * @since 1.0.0
 */
Class Mime {

    public static function register($new_mimes) {

        $mimes = wp_get_mime_types();
        if ($new_mimes === null) { return $mimes; }

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