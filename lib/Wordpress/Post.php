<?php

namespace Contexis\Wordpress;

use Contexis\Core\Color\Utils;
use Contexis\Core\Utilities;

/**
 * Replace ACF with page options
 * 
 * @since 1.5.0a
 */
class Post {

    public static function register() {
        add_action( 'add_meta_boxes', array('Contexis\Wordpress\Post', 'add_meta_boxes') );
        add_action( 'save_post', array('Contexis\Wordpress\Post', 'save'), 1, 2 );
        add_action( 'admin_enqueue_scripts', array('Contexis\Wordpress\Post', 'scripts'));
        //add_action( 'admin_enqueue_scripts', ['Contexis\Core\Color\PostType', 'color_picker'] );
    }

    public static function add_colors() {

    }

    public static function add_meta_boxes() {
        $post_types = ['post', 'page', 'event'];
        foreach($post_types as $post_type) {
            add_meta_box(
                'post_header',
                __( 'Page Header', 'ctx-theme' ),
                ['Contexis\Wordpress\Post', 'header_metabox_callback'],
                $post_type,
                'side'
            ); 
        } 
    }

    public static function header_metabox_callback() {

        global $post;

        $header = get_post_meta( $post->ID, 'header', true ) ?: [
            "height" => 30,
            "subtitle" => '',
            "link" => [
                'title' => '',
                'url' => ''
            ],
            "image_position" => 1,
        ];

        ?>
            <!-- Subtitle -->
            <div class="ctx-metabox__formfield" tabindex="-1">
                <label for="ctx-header-height" class="ctx-metabox__label"><?php _e("Header Height", "ctx-theme") ?></label>
                    <input id="ctx-header-height" 
                    type="number" 
                    autocomplete="off" 
                    name="header_height"
                    class="components-form-token-field__input" 
                    aria-expanded="false" 
                    aria-autocomplete="list" 
                    aria-describedby="components-form-token-suggestions-howto-0" 
                    value=<?php echo $header['height'] ?>
                >
                <p id="components-form-token-suggestions-howto-0" class="components-form-token-field__help"><?php _e("Page height in percent", "ctx-theme") ?></p>
            </div>
            <div class="ctx-metabox__formfield" tabindex="-1">
                <label for="ctx-header-subtitle" class="components-form-token-field__label"><?php _e("Header Subtitle", "ctx-theme") ?></label>
                
                    <input id="ctx-header-subtitle" 
                    type="text" 
                    autocomplete="off" 
                    name="header_subtitle"
                    class="components-form-token-field__input" 
                    aria-expanded="false" 
                    aria-autocomplete="list" 
                    aria-describedby="components-form-token-suggestions-howto-0" 
                    value="<?php echo $header['subtitle'] ?>"
                >
              
            </div>
            <div class="ctx-metabox__formfield" tabindex="-1">
                <label for="ctx-header-link" class="components-form-token-field__label"><?php _e("Header Link", "ctx-theme") ?></label>
                
                <div class="ctx-link">
                            <a class="ctx-link__preview" id="link-preview" href=""><?php echo $header['link']['url'] ?></a>
							<input type="hidden" id="input-title" id="test" name="header_link[title]" value="<?php echo $header['link']['title'] ?>" >						
                            <input type="hidden" id="input-url" name="header_link[url]" value="<?php echo $header['link']['url'] ?>">						
                            <a class="button ctx-link-modal" id=""><?php _e("Add link", "ctx-theme") ?></a>			
                </div>
                
                
                
                
                
            </div>
            <div class="ctx-metabox__formfield" tabindex="-1">
                <label class="ctx-metabox__label"><?php _e("Header Image", "ctx-theme") ?></label>
                
                    <select id="ctx-header-image-position" 
                        type="text" 
                        autocomplete="off" 
                        class="components-form-token-field__select" 
                        aria-expanded="false" 
                        name="header_image_position"
                        aria-autocomplete="list" 
                        aria-describedby="components-form-token-suggestions-howto-0" 
                        value=<?php echo $header ? $header['image_position'] : "1" ?>
                    >
                        <option value="0" <?php echo $header['image_position'] == 0 ? "selected" : "" ?>><?php _e("Top") ?></option>
                        <option value="1" <?php echo $header['image_position'] == 1 ? "selected" : "" ?>><?php _e("Middle") ?></option>
                        <option value="2" <?php echo $header['image_position'] == 2 ? "selected" : "" ?>><?php _e("Bottom") ?></option>
                    </select>
                
            </div>
        <?php
    }


    public static function save( $post_id, $post ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

        if(! in_array($post->post_type, ['post', 'page', 'event'])) {
            return $post_id;
        }

        

        $header = [
            "height" => key_exists('header_height', $_POST) ? $_POST['header_height'] : 30,
            "subtitle" => key_exists('header_subtitle', $_POST) ? $_POST['header_subtitle'] : "",
            "link" => key_exists('header_link', $_POST) ? $_POST['header_link'] : ['title' => '', 'url' => ''],
            "image_position" => key_exists('header_image_position', $_POST) ? $_POST['header_image_position'] : 1,
        ];
        
        Utilities::debug_to_log($header);

        if ( empty($header) ) {
            delete_post_meta( $post_id, "header" );
            return;
        }
            
        if ( get_post_meta( $post_id, "header", false ) ) {
            update_post_meta( $post_id, "header", $header );
            return;
        }
            
        add_post_meta( $post_id, "header", $header); 
            
        
    
    }

    public static function scripts() {
        wp_enqueue_script("ctx-links", get_template_directory_uri() . '/assets/dist/admin-link.js', ['jquery'], false, true);
    }


} 