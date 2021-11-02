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
        add_action( 'admin_enqueue_scripts', ['Contexis\Wordpress\Assets', 'enqueue_color_picker'] );
        if (!$assets) {return;}
        if (isset($assets['scripts'])) { self::addScripts($assets['scripts']); }
        if (isset($assets['styles'])) { self::addStyles($assets['styles']); }
        if (isset($assets['remove_scripts'])) { self::removeScripts($assets['remove_scripts']); }
        if (isset($assets['admin_styles'])) { self::adminStyles($assets['admin_styles']); }
        if (isset($assets['admin_scripts'])) { self::adminScripts($assets['admin_scripts']); }
        if (isset($assets['remove_styles'])) { self::removeStyles($assets['remove_styles']); }
    }

    private static function addScripts($scripts) {
        add_action('wp_enqueue_scripts', function() use (&$scripts) {
            foreach($scripts as $script) {
                wp_enqueue_script( $script['handle'], $script['url'], $script['dependencies'], $script['version'], $script['in_footer'] );
            }
        });
    }

    public static function enqueue_color_picker( $hook_suffix ) {
        //var_dump($hook_suffix);
        //if(!in_array($hook_suffix, ['appearance_page_ctx-base-colors', 'post.php']));

        if($hook_suffix == 'appearance_page_ctx-base-colors') {
            wp_enqueue_script('wp-color-picker', admin_url(('js/color-picker.min.js'), array( 'wp-color-picker-js', 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, true));
        }
        
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'wp-color-picker-js', 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, true );
        wp_enqueue_script( 'ctx-color-picker', get_template_directory_uri() . '/assets/dist/admin-color.js', array('jquery'), '', true );

        
    }

    private static function addStyles($styles) {
        if(!$styles) {
            return;
        }
        add_action('wp_print_styles', function() use (&$styles) {
            foreach($styles as $style) {
                wp_enqueue_style( 
                    $style['handle'], 
                    $style['url'], 
                    isset($style['dependencies']) ? $style['dependencies'] : "", 
                    isset($style['version']) ? $style['version'] : false, 
                    isset($style['media']) ? $style['media'] : "all", 
                );
            }
        });

    }

    private static function adminScripts($scripts) {
        add_action('admin_enqueue_scripts', function() use (&$scripts) {
            foreach($scripts as $script) {
                wp_enqueue_script( 
                    $script['handle'], 
                    $script['url'], 
                    isset($style['dependencies']) ? $style['dependencies'] : "",  
                    isset($style['version']) ? $style['version'] : false, 
                    isset($style['in_footer']) ? $style['in_footer'] : false, 
                );
            }
        });
    }

    private static function adminStyles($styles) {
        add_action('admin_head', function() use (&$styles) {
            foreach($styles as $style) {
                wp_enqueue_style( 
                    $style['handle'], 
                    $style['url'], 
                    isset($style['dependencies']) ? $style['dependencies'] : "", 
                    isset($style['version']) ? $style['version'] : false, 
                    isset($style['media']) ? $style['media'] : "all", 
                );
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