<?php

namespace Contexis\Wordpress;

/**
 * Base Shortcode Class
 * 
 * @param array $post_types 
 * @since 1.0.0
 */
Class Shortcode {

    /**
     * Self-Register Shortcode-Class
     * 
     * @since 1.0.0
     */
    public function __construct()
    {
        add_shortcode( 
            $this->shortcodeName, 
            [$this, "init"]
        );
    }

    /**
     * Collect all shortcode Classes and load them
     * 
     */
    public static function register() {

        $files = scandir(get_template_directory() . '/lib/Wordpress/Shortcodes');

        if (!$files) { return; }
        
		foreach($files as $file) {

			if ("php" === pathinfo($file, PATHINFO_EXTENSION)) {
                require_once(get_template_directory() . '/lib/Wordpress/Shortcodes/' . $file);
                $shortcode = 'Contexis\\Wordpress\\Shortcodes\\' . substr($file, 0, -4);
                add_action( 'init', function() use(&$shortcode){new $shortcode;});
                
			}
		}
    }


    
}