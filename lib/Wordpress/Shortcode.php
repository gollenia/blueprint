<?php

namespace Contexis\Wordpress;

Class Shortcode {

    public function __construct()
    {
        add_shortcode( 
            $this->shortcodeName, 
            [$this, "init"]
        );
    }

    public static function register() {

        $files = scandir(get_template_directory() . '/lib/Wordpress/Shortcodes');

        if (!$files) { return; }
        
		foreach($files as $file) {

			if ("php" === substr($file, -3)) {

                require_once(get_template_directory() . '/lib/Wordpress/Shortcodes/' . $file);
                
                $shortcode = 'Contexis\\Wordpress\\Shortcodes\\' . substr($file, 0, -4);
                add_action( 'init', function() use(&$shortcode){new $shortcode;});
                
			}
		}
    }


    
}