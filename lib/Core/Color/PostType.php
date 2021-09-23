<?php
/**
 * Class to generate a custom post type for colors
 * 
 * @since 1.5.0
 */

namespace Contexis\Core\Color;

class PostType {

    public static function register() {
        add_action( 'init', array('Contexis\Core\Color\PostType', 'register_color_post_type') );
        add_action( 'add_meta_boxes', array('Contexis\Core\Color\PostType', 'add_meta_boxes') );
        add_action( 'save_post', array('Contexis\Core\Color\PostType', 'save'), 1, 2 );
        add_filter( 'manage_ctx-color-palette_posts_columns', array('Contexis\Core\Color\PostType', 'set_custom_columns') );
        add_action( 'manage_ctx-color-palette_posts_custom_column' , array('Contexis\Core\Color\PostType', 'custom_column'), 10, 2 );
        //add_action( 'admin_enqueue_scripts', ['Contexis\Core\Color\PostType', 'color_picker'] );
        add_action( 'edit_form_advanced', ['Contexis\Core\Color\PostType', 'add_back_button'] );
    }

	public static  function register_color_post_type(){
		$args = [
			'hierarchical' 		  => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'show_admin_column' => true,
			'show_in_menu'        => false,
			'menu_position'       => 30,
			'query_var' => true, 
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'supports'            => [ 'title', 'custom-fields', 'page_attributes' ],
			'menu_icon'           => 'dashicons-color-picker',
			'labels' => [
				'name'               => __('Color Palette', 'ctx-theme'),
				'singular_name'      => __('Color', 'ctx-theme'),
				'add_new'            => __('Create new color', 'ctx-theme'),
				'add_new_item'       => __('Create new color', 'ctx-theme'),
				'edit_item'          => __('Edit color', 'ctx-theme'),
				'new_item'           => __('New color', 'ctx-theme'),
				'all_items'          => __('All colors' ,'ctx-theme'),
				'view_item'          => __('View colors', 'ctx-theme'),
				'search_items'       => __('Search colors', 'ctx-theme'),
				'not_found'          => __('No colors found', 'ctx-theme'),
				'not_found_in_trash' => __('No colors found in trash', 'ctx-theme'),
				'parent_item_colon'  => '',
				'menu_name'          => __('Color Palette', 'ctx-theme')
			]
		];

		register_post_type( 'ctx-color-palette', $args );

                
        
    }

	public static function add_meta_boxes() {
        add_meta_box(
                'color_settings',
                __( 'Color Settings', 'ctx-theme' ),
                ['Contexis\Core\Color\PostType', 'metabox_callback'],
                'ctx-color-palette',
                'normal'
            ); 
    }

    public static function metabox_callback() {
        global $post;
        
        $color = get_post_meta( $post->ID, 'color', true );
        if (!$color) {
            $color = '#000000';
        }
        $brightness = get_post_meta( $post->ID, 'brightness', true );
        
        if(!$brightness) {
            $brightness = "auto";
        }
        wp_nonce_field( basename( __FILE__ ), 'color_fields' );
        echo '<table class="form-table"><tbody>';
        echo '<tr><th>' . __( 'Color value', 'ctx-theme' ) . '</th><td><input name="color" type="text" value="' . $color . '" class="ctx-color-picker" data-default-color="#ffffff"></td></tr>';
        echo '<tr><th>'  . __( 'Slug', 'ctx-theme' ) . '</th><td><input id="sluginput" name="post_name" type="text" value="' . $post->post_name . '"><br><p id="slug-error" class="description">' . __( 'No spaces or special chars. Used for internal identification', 'ctx-theme' ) . '</p></td></tr>';
        echo '<tr><th>'  . __( 'Brightness', 'ctx-theme' ) . '</th><td><select name="brightness" value="' . $brightness . '">';
            echo '<option value="auto">' . __( 'Let System decide', 'ctx-theme' ) . '</option>';
            echo '<option value="light" ' . ($brightness == 'light' ? 'selected' : '') . '>' . __( 'Light', 'ctx-theme' ) . '</option>';
            echo '<option value="dark" ' . ($brightness == 'dark' ? 'selected' : '') . '>' . __( 'Dark', 'ctx-theme' ) . '</option>';
        echo '</select><br><p class="description">' . __( 'Decides if text on this color should be white or black', 'ctx-theme' ) . '</p></td></tr>';
        echo '</tbody></table>';
        
        ?>
            <script type="text/javascript">
                const forbiddenClasses = <?php echo json_encode(array_keys(\Contexis\Core\Color\Utils::$color_array)) ?>;
                    
                slugInput = document.getElementById('sluginput').addEventListener('keyup', function(event) {
                    console.log(forbiddenClasses)
                    if(forbiddenClasses.includes(event.target.value)) {
                        document.getElementById('publish').disabled = true;
                        document.getElementById('slug-error').innerText = "<?php _e( 'Error: The slug must not contain any of the base color names', 'ctx-theme' ) ?>"
                        document.getElementById('slug-error').className = "description error"
                        return;
                    }
                    document.getElementById('publish').disabled = false;
                    document.getElementById('slug-error').innerText = "<?php _e( 'No spaces or special chars. Used for internal identification', 'ctx-theme' ) ?>"
                    document.getElementById('slug-error').className = "description"
                    
                });
                
            </script>
        <?php
    }

    public static function save( $post_id, $post ) {

        if($post->post_type != "ctx-color-palette" || ! current_user_can( 'edit_post', $post_id )) {
            return $post_id;
        }
    
        if ( ! isset( $_POST['color'] ) || ! wp_verify_nonce( $_POST['color_fields'], basename(__FILE__) ) ) {
            return $post_id;
        }
        
        $color_meta = [];
    
        $color_meta['color'] = sanitize_text_field( $_POST['color'] );
        $color_meta['brightness'] = sanitize_text_field( $_POST['brightness'] );
        if($color_meta['brightness'] == 'auto') {
            $color_meta['computed_brightness'] = \Contexis\Core\Color\Utils::get_brightness($color_meta['color']) < 170 ? "dark" : "light";
        } 
    
        foreach ( $color_meta as $key => $value ) {    
            if ( get_post_meta( $post_id, $key, false ) ) {
                update_post_meta( $post_id, $key, $value );
                continue;
            } 

            if ( ! $value ) {
                delete_post_meta( $post_id, $key );
                continue;
            }
            
            add_post_meta( $post_id, $key, $value); 
        }
    
    }

    
    public static function set_custom_columns($columns) {
        $columns['slug'] = __( 'Slug', 'ctx-theme' );
        $columns['color'] = __( 'Color', 'ctx-theme' );
        unset($columns['date']);
        return $columns;
    }



    public static function custom_column( $column, $post_id ) {
        if($column == "color") {
            $color = get_post_meta( $post_id , 'color' , true );
            $computed = get_post_meta( $post_id , 'computed_brightness' , true );
            $brightness = $computed ? $computed : get_post_meta( $post_id , 'brightness' , true );
            $foreground = $brightness == "dark" ? '#ffffff' : "#000000";
            echo "<div class='ctx-color-badge' style='height: 24px; width: 120px; background-color: " . $color . "; color: " . $foreground . "'><span>" . $color . "</span></div>";
        }
        if($column == "slug") {
            global $post;
            echo $post->post_name;
        }
    }

    public static function add_back_button( $post ) {
        if( $post->post_type == 'ctx-color-palette' )
            echo "<a class='button button-primary button-large' href='edit.php?post_type=ctx-color-palette' id='my-custom-header-link'>" . __('Back', 'ctx-theme') . "</a>";
    }

    public static function verify_slug($data) {
        
        if($data->post_type != "ctx-color-palette") {
            return $data;
        }

        if(array_key_exists($data['post_name'], \Contexis\Core\Color\Utils::$color_array)) {
            add_action( 'admin_notices', ['Contexis\Core\Color\PostType', 'slug_admin_notice__error'] );
            return $data;
        } 

        return $data;
    }

    public static function get() {
        $args = [
            'post_type' => 'ctx-color-palette'
        ];

        $query = new \WP_Query( $args );
        $color_posts = $query->posts;
        
        $colors = [];
        foreach ($color_posts as $color) {
            
            $color_value = get_post_meta($color->ID, 'color', true);
            $brightness = get_post_meta($color->ID, 'brightness', true);
            
            $computed_brightness = get_post_meta($color->ID, 'computed_brightness', true);
            
            $brightness = $brightness == "auto" && $computed_brightness ? $computed_brightness : $brightness;
            array_push($colors, [
                    "slug" => $color->post_name,
                    "name" => $color->post_title,
                    "color" => $color_value,
                    "brightness" => $brightness,
                    "contrast" => $brightness == "dark" ? "#ffffff" : "#000000"
            ]);
        }

        return $colors;
    }

    
}
    

    
	
