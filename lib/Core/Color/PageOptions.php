<?php

namespace Contexis\Core\Color;

class PageOptions {

    public $post_types = ['post', 'page', 'event'];

    public static function register() {
        add_action( 'add_meta_boxes', array('Contexis\Core\Color\PageOptions', 'add_meta_boxes') );
        add_action( 'save_post', array('Contexis\Core\Color\PageOptions', 'save'), 1, 2 );
        
    }

    public static function add_meta_boxes() {
        
        foreach (['post', 'page', 'event'] as $type) {
            add_meta_box(
                'page_color_options',
                __( 'Color Settings', 'ctx-theme' ),
                ['Contexis\Core\Color\PageOptions', 'metabox_callback'],
                $type,
                'side'
            ); 
        }

    }

    public static function metabox_callback() {
        $options = Color::get();
        global $post;

        $color_meta = get_post_meta( $post->ID, 'page_colors', true );
        
        $primarycolor = isset($color_meta['primary_color']) ? $color_meta['primary_color'] : $options[0]['color'];
        $secondarycolor = isset($color_meta['secondary_color']) ? $color_meta['secondary_color'] : $options[1]['color'];

        wp_nonce_field( basename( __FILE__ ), 'color_pickers' );
        
        ?>
        <div class="color-select">
            <legend><div class="block-editor-color-gradient-control__color-indicator">
                <span class="components-base-control__label"><?php _e('Primary color', 'ctx-theme') ?><input type="color" name="primary_color" id="primary" class="ctx-color-selector-input" value="<?php echo $primarycolor; ?>"></span>
            </div></legend>
            <div class="components-circular-option-picker">
                <div class="ctx-color-selector">
                    <?php
                        foreach($options as $color) {
                            $selected = $color["slug"] == $primarycolor ? "is-pressed" : "";
                            echo '<div class="ctx-color-selector-holder">';
                            echo '<button type="button" data-color="' . $color['color'];
                            echo '"  data-for="primary" class="ctx-color-selector-button ' . $selected;
                            echo '" style="background-color: ' . $color['color'] . '; color: ' . $color['contrast'] . ';"></button>';
                            echo '</div>';
                        }
                    ?>
                    </div>
                </div>
        </div>
        <div class="color-select">
            <legend><div class="block-editor-color-gradient-control__color-indicator">
                <span class="components-base-control__label"><?php _e('Secondary color', 'ctx-theme') ?><input type="color" name="secondary_color" id="secondary" class="ctx-color-selector-input" value="<?php echo $secondarycolor; ?>"></span>
            </div></legend>
            <div class="components-circular-option-picker">
                <div class="ctx-color-selector">
                    <?php
                        foreach($options as $color) {
                            $selected = $color["slug"] == $primarycolor ? "is-pressed" : "";
                            echo '<div class="ctx-color-selector-holder">';
                            echo '<button type="button" data-color="' . $color['color'] . '"  data-for="secondary" class="ctx-color-selector-button ' . $selected . '" style="background-color: ' . $color['color'] . '; color: ' . $color['contrast'] . ';"></button>';
                            echo '</div>';
                        }
                    ?>
                    </div>
                </div>
        </div>
        <script>
            const colorPickers = document.getElementsByClassName("ctx-color-selector-button");
            for (let index = 0; index < colorPickers.length; index++) {
                colorPickers[index].addEventListener("click", setColor) 
            }

            function setColor(event) {
                colorPicker = document.getElementById(event.target.dataset.for);
                console.log(colorPicker)
                colorPicker.value = event.target.dataset.color
            }
        </script>
        <?php
        
        
    }


    public static function save( $post_id, $post ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

        if(! in_array($post->post_type, ['post', 'page', 'event'])) {
            return $post_id;
        }

        $base_colors = Options::get();

        $color_meta = [];
        
        
        file_put_contents(ABSPATH . "../log/debug.log", var_export($_POST, TRUE));
        if(key_exists('primary_color', $_POST)) {
        if(!empty($_POST['primary_color']) || $_POST['primary_color'] == $base_colors[0]['color'] ) {
            $color_meta['primary_color'] = sanitize_text_field( $_POST['primary_color'] );
            $color_meta['primar_color_brightness'] = \Contexis\Core\Color\Utils::get_brightness($color_meta['primary_color']) < 170 ? "dark" : "light";
        }
    }
        if(empty($_POST['secondary_color']) || $base_colors[1]['color'] == $_POST['secondary_color'] ) {
            $color_meta['secondary_color'] = sanitize_text_field( $_POST['secondary_color'] );
            $color_meta['secondary_color_brightness'] = \Contexis\Core\Color\Utils::get_brightness($color_meta['secondary_color']) < 170 ? "dark" : "light";
        }
        
        if ( empty($color_meta) ) {
            delete_post_meta( $post_id, "page_colors" );
            return;
        }
            
        if ( get_post_meta( $post_id, "page_colors", false ) ) {
            update_post_meta( $post_id, "page_colors", $color_meta );
            return;
        }
            
        add_post_meta( $post_id, "page_colors", $color_meta); 
            
        
    
    }

    public static function get_page_colors($colors) {
        
        global $post;

        $color_meta = get_post_meta( $post->ID, 'page_colors', true );

        if(isset($color_meta['primary_color'])) {
            $colors[0]['color'] = $color_meta['primary_color'];
            $colors[0]['brightness'] = isset($color_meta['primary_color_brightness']) ? $color_meta['primary_color_brightness'] : (\Contexis\Core\Color\Utils::get_brightness($colors[0]['color']) < 170 ? "dark" : "light");;
            $colors[0]['contrast'] = $colors[0]['brightness'] == "dark" ? "#ffffff" : '#000000';
        }
        
        if(isset($color_meta['secondary_color'])) {
            $colors[1]['color'] = $color_meta['secondary_color'];
            $colors[1]['brightness'] = isset($color_meta['secondary_color_brightness']) ? $color_meta['secondary_color_brightness'] : (\Contexis\Core\Color\Utils::get_brightness($colors[1]['color']) < 170 ? "dark" : "light");;
            $colors[1]['contrast'] = $colors[1]['brightness'] == "dark" ? "#ffffff" : '#000000';
        }


        return $colors;

    }


    




}