<?php

namespace Contexis\Core;

/**
 * Class that collects all files in ./Twig and adds them as function or filter
 * 
 * @param array $post_types 
 * @since 1.0.0
 */
Class TwigExtensions {


    /**
     * Collect all Twig Classes and load them
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