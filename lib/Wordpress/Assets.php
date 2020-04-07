<?php
namespace Contexis\Wordpress;

Class Assets {

    public static function register($assets) {
        self::addScripts($assets['scripts']);
        self::addStyles($assets['styles']);
        self::removeScripts($assets['remove_scripts']);
        self::removeStyles($assets['remove_styles']);
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

    private static function removeScripts($scripts) {
        add_action('wp_footer', function() use (&$scripts) {
            foreach($scripts as $script) {
                wp_dequeue_script( $script );
            }
        });
    }

    private static function removeStyles($styles) {
        add_action('wp_print_styles', function() use (&$styles) {
            foreach($styles as $style) {
                wp_dequeue_style( $style );
            }
        });
    }

}