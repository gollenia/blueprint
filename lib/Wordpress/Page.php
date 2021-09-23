<?php

namespace Contexis\Wordpress;

class Page {

    public static function register() {
        add_action( 'init', array('Contexis\Core\Color\PostType', 'register_color_post_type') );
        add_action( 'add_meta_boxes', array('Contexis\Core\Color\PostType', 'add_meta_boxes') );
        add_action( 'save_post', array('Contexis\Core\Color\PostType', 'save'), 1, 2 );
        add_filter( 'manage_ctx-color-palette_posts_columns', array('Contexis\Core\Color\PostType', 'set_custom_columns') );
        add_action( 'manage_ctx-color-palette_posts_custom_column' , array('Contexis\Core\Color\PostType', 'custom_column'), 10, 2 );
        //add_action( 'admin_enqueue_scripts', ['Contexis\Core\Color\PostType', 'color_picker'] );
        add_action( 'edit_form_advanced', ['Contexis\Core\Color\PostType', 'add_back_button'] );
    }

    public static function add_colors() {

    }

    public static function add_meta_boxes() {
        $post_types = array ( 'post', 'page', 'event' );
        foreach($post_types as $post_type) {
            add_meta_box(
                'page_color_options',
                __( 'Color Settings', 'ctx-theme' ),
                ['Contexis\Wordpress\Page', 'color_metabox_callback'],
                'ctx-color-palette',
                'side'
            ); 
        }
        
    }


}