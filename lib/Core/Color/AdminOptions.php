<?php
/**
 * Class to generate a custom post type for colors
 * 
 * @since 1.5.0
 * @deprecated 1.6
 */

namespace Contexis\Core\Color;

use Contexis\Core\Color\Helper;

class AdminOptions {

    public static function register() {
        $instance = new self;
        add_action('admin_menu', [ $instance, 'add_settings_menu' ], 9);    
		add_action('admin_init', [ $instance, 'register_settings'] );
        add_action('after_switch_theme', [ $instance,'generate_default_options']); 
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function add_settings_menu(){
        add_submenu_page( 
			'themes.php', 			// URL Location
			__('Base Colors', 'ctx-theme'),	// Name
			__('Base Colors', 'ctx-theme'), 								// Title
			'administrator', 							// Access Level
			'ctx-base-colors', 					// Page Name
			[$this, 'display_admin_settings']			// Callback
		);
        add_submenu_page('themes.php', __('Custom Colors', 'ctx-theme'), __('Custom Colors', 'ctx-theme'), 'manage_options', 'edit.php?post_type=ctx-color-palette');
	}

    /**
     * Show Admin color settings page
     *
     * @return void
     */
	public function display_admin_settings() {
		?>
		<div class="wrap">
		        <div id="icon-themes" class="icon32"></div>  
		        <h2><?php echo __("Base Colors", 'ctx-products') ?></h2>  
				<?php settings_errors(); ?>  
		        <form method="POST" action="options.php">  
		            <?php 
		                settings_fields( 'ctx_base_colors' );
		                do_settings_sections( 'ctx-main-colors' ); 
                        submit_button();
		            ?>             
		        </form> 
		</div>
		<?php
	}

    /**
     * Register Admin Page color settings
     *
     * @return void
     */
	public function register_settings() {
		register_setting( 'ctx_base_colors', 'ctx_base_color_options' );
		add_settings_section( 'main_colors', 'Main Colors', [$this,'main_section_text'], 'ctx-main-colors' );
        
        foreach (Helper::$color_array as $name => $value) {
            add_settings_field( 'ctx_base_color_' . $name, __(ucfirst($name) . ' Color', 'ctx-theme'), [$this,'ctx_color_setting_colorfield'], 'ctx-main-colors', 'main_colors', ['name' => $name] );
        }
	
	}

    /**
     * Echo out the section helper text
     *
     * @return void
     */
	public function main_section_text() {
        echo __("Here you can define the base colors of your theme.");
	}

    /**
     * Validate request input for hex value
     *
     * @param string $input
     * @return string clean output
     * 
     * @todo Use this function!
     */
	public function ctx_product_options_validate( $input ) {
		$newinput['slug'] = trim( $input['slug'] );
		if ( ! preg_match( '/^[a-z0-9]{32}$/i', $newinput['slug'] ) ) {
			$newinput['slug'] = '';
		}
	
		return $newinput;
	}

    /**
     * Generate input field for the color option page
     *
     * @param array $color
     * @return void
     */
	public function ctx_color_setting_colorfield($color) {
        
		$options = get_option( 'ctx_base_color_options' );
        
        $color_value = array_key_exists($color['name'], $options) ? $options[$color['name']] : Helper::$color_array[$color['name']];
		echo "<input id='ctx_color_setting_" . $color['name'] . "' name='ctx_base_color_options[" . $color['name'] . "]' type='color' class='ctx-color-picker' value='" . $color_value . "' />";
	}

    /**
    *  For the theme to work, the base colors have to at least exist as option settings,
    *   therefore let's create them with some standard colors if they are not present 
    * 
    *   @return void
    *
    */
    public function generate_default_options()
    {
        $options = get_option( 'ctx_base_color_options' );
        if($options) {
            return;
        }
        add_option('ctx_base_color_options', Helper::$color_array);
    }

    public static function get() {
        $base_colors = get_option('ctx_base_color_options'); 
        $colors = [];
        foreach ($base_colors as $slug => $color) {
            $brightness = \Contexis\Core\Color\Helper::get_brightness($color) < 170 ? "dark" : "light";
            array_push($colors, [
                    "slug" => $slug,
                    "name" => __(ucfirst($slug) . ' Color', 'ctx-theme'),
                    "color" => $color,
                    "brightness" => $brightness,
                    "contrast" => $brightness == "dark" ? "#ffffff" : "#000000"
            ]);
        }
        
        return $colors;
    }

}
    

    
	

