<?php
namespace Contexis\Core;

/**
 * Advanced Custom Fields
 * 
 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
 * 
 * @since 1.0.0
 */

Class Fields {

    public static function register($fields) {

		if ($fields === null) { return; }
        
		add_action('acf/init', function() use (&$fields){
			foreach ($fields as $field) {
                acf_add_local_field_group($field);	
            }	
		});
    }
    
}