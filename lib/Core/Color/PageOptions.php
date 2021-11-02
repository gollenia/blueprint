<?php

namespace Contexis\Core\Color;

class PageOptions {

    public $post_types = ['post', 'page', 'event'];
    public $colors = [];

    public static function register($colors) {
        $instance = new self;
        $instance->colors = $colors;
        add_action( 'add_meta_boxes', array($instance, 'add_meta_boxes') );
        add_action( 'save_post', array($instance, 'save'), 1, 2 );
        add_filter( 'ctx_page_colors', array($instance, 'get_page_colors'), 1, 2 );
        
    }

    public function add_meta_boxes() {
        
        foreach (['post', 'page', 'event'] as $type) {
            add_meta_box(
                'page_color_options',
                __( 'Color Settings', 'ctx-theme' ),
                [$this, 'metabox_callback'],
                $type,
                'side'
            ); 
        }

    }

    public function metabox_callback() {
        global $post;

        $color_meta = get_post_meta( $post->ID, 'page_colors', true ) ?: [];

        
        $primarycolor = array_key_exists('primary_color', $color_meta) ? $color_meta['primary_color'] : $this->colors['primary']['color'];
        $secondarycolor = array_key_exists('secondary_color', $color_meta) ? $color_meta['secondary_color'] : $this->colors['secondary']['color'];

        wp_nonce_field( basename( __FILE__ ), 'color_pickers' );
        
        ?>
        <div class="color-select">
            <legend><div class="block-editor-color-gradient-control__color-indicator">
                <span class="components-base-control__label"><?php _e('Primary Color', 'ctx-theme') ?><input type="color" name="primary_color" id="primary" class="ctx-color-selector-input" value="<?php echo $primarycolor; ?>"></span>
            </div></legend>
            <div class="components-circular-option-picker">
                <div class="ctx-color-selector">
                    <?php
                        foreach($options as $slug => $color) {
                            $selected = $slug == $primarycolor ? "is-pressed" : "";
                            echo '<div class="ctx-color-selector-holder"><button type="button" data-color="' . $color['color'] . '" data-for="primary" class="ctx-color-selector-button ' . $selected . '"';
                            echo ' style="background-color: ' . $color['color'] . '; color: ' . ($color['light'] ? "#000000" : "#ffffff") . ';"></button>';
                            echo '</div>';
                        }
                    ?>
                    </div>
                </div>
        </div>
        <div class="color-select">
            <legend><div class="block-editor-color-gradient-control__color-indicator">
                <span class="components-base-control__label"><?php _e('Secondary Color', 'ctx-theme') ?><input type="color" name="secondary_color" id="secondary" class="ctx-color-selector-input" value="<?php echo $secondarycolor; ?>"></span>
            </div></legend>
            <div class="components-circular-option-picker">
                <div class="ctx-color-selector">
                    <?php
                        foreach($options as $slug => $color) {
                            $selected = $slug == $primarycolor ? "is-pressed" : "";
                            echo '<div class="ctx-color-selector-holder">';
                            echo '<button type="button" data-color="' . $color['color'] . '"  data-for="secondary" class="ctx-color-selector-button ' . $selected . '" style="background-color: ' . $color['color'] . '; color: ' . ($color['light'] ? "#000000" : "#ffffff") . ';"></button>';
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


    public function save( $post_id, $post ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

        if(! in_array($post->post_type, ['post', 'page', 'event'])) {
            return $post_id;
        }

        $color_meta = [];
        
        if(key_exists('primary_color', $_POST)) {
            if(!empty($_POST['primary_color']) || $_POST['primary_color'] == get_theme_support('ctx_primary_color') ) {
                $color_meta['primary_color'] = sanitize_text_field( $_POST['primary_color'] );
            }
        }

        if(key_exists('secondary_color', $_POST)) {
            if(!empty($_POST['secondary_color']) || $_POST['secondary_color' == get_theme_support('ctx_secondary_color')] ) {
                $color_meta['secondary_color'] = sanitize_text_field( $_POST['secondary_color'] );
            }
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

        if(!$post) {
            return $colors;
        }

        $color_meta = get_post_meta( $post->ID, 'page_colors', true );

        if(isset($color_meta['primary_color'])) {
            $colors['primary']['color'] = $color_meta['primary_color'];
            $colors['primary']['light'] = \Contexis\Core\Color::get_brightness($colors['primary']['color']);
        }
        
        if(isset($color_meta['secondary_color'])) {
            $colors['secondary']['color'] = $color_meta['secondary_color'];
            $colors['secondary']['light'] = \Contexis\Core\Color::get_brightness($colors['secondary']['color']);
        }

        return $colors;
    }
}