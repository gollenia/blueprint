<?php
namespace Contexis\Wordpress;

/**
 * Load Assets from a config Array and enqeue/dequeue them
 * 
 * @param array $assets 
 * @since 1.0.0
 */
Class Assets {

    public static function register($assets) {
        if (!$assets) {return;}
        if ($assets['scripts'] !== null) { self::addScripts($assets['scripts']); }
        if ($assets['styles'] !== null) { self::addStyles($assets['styles']); }
        if ($assets['remove_scripts'] !== null) { self::removeScripts($assets['remove_scripts']); }
        if ($assets['admin_styles'] !== null) { self::adminStyles($assets['remove_scripts']); }
        if ($assets['admin_scripts'] !== null) { self::adminScripts($assets['remove_scripts']); }
        if ($assets['remove_styles'] !== null) { self::removeStyles($assets['remove_styles']); }
    }

    private static function addScripts($scripts) {
        add_action('wp_enqueue_scripts', function() use (&$scripts) {
            foreach($scripts as $script) {
                wp_enqueue_script( $script['handle'], $script['url'], $script['dependencies'], $script['version'], $script['in_footer'] );
            }
        });
    }

    private static function addStyles($styles) {
        add_action('wp_print_styles', function() use (&$styles) {
            foreach($styles as $style) {
                wp_enqueue_style( $style['handle'], $style['url'], $style['dependencies'], $style['version'], $style['media'] );
            }
        });

    }

    private static function adminScripts($scripts) {
        add_action('admin_enqueue_scripts', function() use (&$scripts) {
            foreach($scripts as $script) {
                wp_enqueue_script( $script['handle'], $script['url'], $script['dependencies'], $script['version'], $script['in_footer'] );
            }
        });
    }

    private static function adminStyles($styles) {
        add_action('admin-styles', function() use (&$styles) {
            foreach($styles as $style) {
                wp_enqueue_style( $style['handle'], $style['url'], $style['dependencies'], $style['version'], $style['media'] );
            }
        });

    }

    private static function removeScripts($scripts) {
        add_action('wp_footer', function() use (&$scripts) {
            foreach($scripts as $script) {
                wp_dequeue_script( $script );
            }
        });
    }

    private static function removeStyles($styles) {
        add_action('em_enqueue_styles', function() use (&$styles) {
            foreach($styles as $style) {
                wp_dequeue_style($style);
                wp_deregister_style( $style );
            }
        });
    }

}