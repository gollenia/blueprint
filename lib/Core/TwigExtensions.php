<?php

namespace Contexis\Core;

/**
 * Base Shortcode Class
 * 
 * @param array $post_types 
 * @since 1.0.0
 */
Class TwigExtensions {

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

        $files = scandir(get_template_directory() . '/lib/Core/Twig');

        if (!$files) { return; }

		foreach($files as $file) {

			if ("php" === pathinfo($file, PATHINFO_EXTENSION)) {
                require_once(get_template_directory() . '/lib/Core/Twig/' . $file);
                $twig_extension = 'Contexis\\Core\\Twig\\' . substr($file, 0, -4);
                add_filter( 'timber/twig', $twig_extension . '::init');

			}
		}
    }



} 