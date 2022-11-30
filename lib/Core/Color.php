<?php
/**
 * Color Management Class
 * 
 * @since 1.6.0
 */

namespace Contexis\Core;

use Contexis\Core\Color\PageOptions;
use Contexis\Core\Color\PostType;

class Color {

    /**
     * We have to make sure, that a basic set of colors exist.
	 * Default color array with fallback colors to be overwritten by PageOptions
     *
     * @var array $default_colors
     */
    public static $default_colors = [
        'primary' => '#2196f3', 
        'secondary' => '#607d8b', 
        'error' => "#f44336", 
        'warning' => "#ff9800", 
        'success' => "#8bc34a",
        'black' => "#000000",
        'white' => "#ffffff",
        'gray' => "#999999"
    ];

    private $colors = [];

    /**
     * Create an instance. This is the static constructor method.
     *
     * @return Contexis\Core\Color
     *
     */
    public static function register() {
        $instance = new self;
        add_action( 'customize_register', [$instance, 'add_color_settings'] ); 
        \Contexis\Core\Color\PostType::register();
        $instance->colors = apply_filters('ctx_custom_colors', iterator_to_array(self::get_base_colors()));
        \Contexis\Core\Color\PageOptions::register($instance->colors);
		add_action('wp_head', [$instance, 'add_color_css']);
		add_action('admin_head', [$instance, 'add_admin_css']);
        return $instance;
    }

	/**
	 * Add color settings to the page Head.
	 * 
	 * @return void
	 */
	function add_color_css() {
		$colors = self::get(true);
		
		echo "<style>:root {";
		foreach ($colors as $key => $value) {
			echo "--{$key}: {$value['color']};";
			echo "--{$key}-transparent: {$value['color']}aa;";
			echo "--{$key}-contrast: " . ($value['light'] ? "var(--black)" : "var(--white)") . ";";
			echo "--{$key}-dark: " . self::adjust_brightness($value['color'], -.4) . ";";
			echo "--{$key}-light: " . self::adjust_brightness($value['color'], .4) . ";";
			echo "--{$key}-light-transparent: {$value['color']};";
		}

		echo "}";

		echo "</style>";
		if(key_exists('primary', $colors)) {
			echo "<meta name='theme-color' content='{$colors['primary']['color']}'>";
		}
	}


	function add_admin_css() {
		$colors = self::get(false);
		echo "<style> :root {";
			echo "--primary:" . $colors['primary']['color'] . ";";
			echo "--primary--contrast" . $colors['primary']['light'] ? "var(--black)" : "var(--white);";
		echo "}";

	}
	


    /**
     * Callback function to add Customizer-Settings for Colors. Maybe we put this stuff into the Adminclass later?
     *
     * @param \WP_Customize_Manager $wp_customize 
     * @return void
     */
    public function add_color_settings(\WP_Customize_Manager $wp_customize){

        foreach(self::$default_colors as $slug => $color) {
            $setting = 'ctx_' . $slug . '_color';

            $wp_customize->add_setting( $setting, array(
                'default' => $color,
            ));

            $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, $setting, array(
                'label' => __(ucfirst($slug) . ' Color'),
                'section' => 'colors',
                'settings' => $setting
            )));
        }
    }

    /**
     * Get the base colors stored in the Theme Customizer (or fallback to default)
     *
     * @return \Generator
     * 
     */
    public static function get_base_colors() {
        foreach (self::$default_colors as $slug => $color) {
            $color = get_theme_mod('ctx_' . $slug . '_color') ?: $color;
            (yield $slug => [
                "color" => $color,
                "slug" => $slug,
                "name" => __(ucfirst($slug) . ' Color', 'ctx-theme'),
                "light" => self::get_brightness($color)
            ]);
        }
    }
 
    /**
     * Return an array with all our colors
     *
     * @param bool $inject_page_colors Inject primary and secondary color setting from the current page if present
     * @return array Colors
     * 
     */
    public function get($inject_page_colors = false, $grayscale = true) {
		$colors = $this->colors;
		if ($grayscale) {
			$colors = array_merge($colors, $this->get_grayscale());
		}
        if ($inject_page_colors) {
            return apply_filters('ctx_page_colors', $colors);
        }
        return $colors;
    }


	public function get_editor_colors($inject_page_colors = false, $grayscale = true) {
		$colors = [];
		unset($colors['primary']);
		unset($colors['secondary']);
		
		if ($grayscale) {
			$colors = array_merge($colors, $this->get_grayscale());
		}
        
        return PostType::get_colors($colors);
        
        return $colors;
    }
    

    /**
     * Generate a grayscale
     *
     * @param string $hex Basevalue
     * @return array 
     */
    public function get_grayscale($hex = "") { 

        $hex = $hex ?: $this->colors['gray']['color'];

        if(!preg_match('/#(?:[0-9a-fA-F]{6})/', $hex)) {
            return false;
        }
		
        $redbase = hexdec("1" . substr($hex, 2, 1));
        $green_diff = hexdec(substr($hex, 1, 2)) - hexdec(substr($hex, 3, 2));
        $blue_diff = hexdec(substr($hex, 1, 2)) - hexdec(substr($hex, 5, 2));
        $greenbase = $redbase - $green_diff;
        $bluebase = $redbase  - $blue_diff;
        $base_gray = '#' . str_pad(dechex($redbase), 2, "0", STR_PAD_LEFT) . str_pad(dechex($greenbase), 2, "0", STR_PAD_LEFT) . str_pad(dechex($bluebase), 2, "0", STR_PAD_LEFT);


        $steps = [.95, .95, .90, .85, .8, .7, .5, .4, .3, .2];
        $grayscale = [];
        for ($i=1; $i < 10; $i++) { 
            $grayscale["gray-" . $i . "00"] = [
                "color" => self::adjust_brightness($base_gray, $steps[$i]),
                "light" => $i < 5,
				"slug" =>"gray-" . $i . "00"
            ];
        }
 
        return $grayscale;
    }

	/**
     * Decide if a color is more dark or more light, e.g. to select a fitting contrast
     *
     * @param string $color hexadecimal color value
	 * @param string $threshold adjust the threshold value when a color should e treated as bright
     * @return bool true for bright, false for dark
     */
    public static function get_brightness($color, $threshold = 170) { 
        if(!preg_match('/#(?:[0-9a-fA-F]{6})/', $color)) {
            return false;
        }
        $color = str_replace('#', '', $color); 
        $red = hexdec(substr($color, 0, 2)); 
        $green = hexdec(substr($color, 2, 2)); 
        $blue = hexdec(substr($color, 4, 2)); 
        
        return intval((($red * 299) + ($green * 587) + ($blue * 114)) / 1000) > $threshold;
    }

	/**
	 * brighten or darken a hexadecimal color (add white or black)
	 *
	 * @param string $hexCode
	 * @param float $factor from -1 to 1
	 * @return string hexadecimal color code
	 */
    public static function adjust_brightness($hexCode, $factor) {
        $hexCode = ltrim($hexCode, '#');
    
        if (strlen($hexCode) == 3) {
            $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
        }
    
        $hexCode = array_map('hexdec', str_split($hexCode, 2));
    
        foreach ($hexCode as & $color) {
            $adjustableLimit = $factor < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $factor);
    
            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }
    
        return '#' . implode($hexCode);
    }

	

   


}