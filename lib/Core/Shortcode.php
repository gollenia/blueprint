<?php

namespace Contexis\Core;

Class Shortcode {

    public function __construct()
    {
        add_shortcode( 
            $this->shortcodeName, 
            [$this, "render"]
        );
    }

    public static function register() {
        $files = scandir(get_template_directory() . '/lib/Core/Shortcodes');
		if (!$files) { return; }
		foreach($files as $file) {
			if ("php" === substr($file, -3)) {
				require_once(get_template_directory() . '/lib/Core/Shortcodes/' . $file);
				$shortcode = 'Contexis\\Core\\Shortcodes\\' . substr($file, 0, -4);
				add_action( 'init', function() use(&$shortcode){
                    new $shortcode;
                });
			}
		}
    }
    
}