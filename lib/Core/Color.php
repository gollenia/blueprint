<?php
/**
 * Color Management Class
 * 
 * @since 1.6.0
 * @link https://github.com/ozdemirburak/iris
 */

namespace Contexis\Core;

// @TODO Replace this with own functions for less dependencies
use OzdemirBurak\Iris\Color\Hex;

class Color {

    /**
     * Default color array with fallback colors to be overwritten PageOptions or AdminOptions
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
        
        $instance->colors = apply_filters('ctx_custom_colors', iterator_to_array(self::get_base_colors()));
        \Contexis\Core\Color\PageOptions::register($instance->colors);
		\Contexis\Core\Color\PostType::register($instance->colors);
        return $instance;
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

    public static function get_background_color() {
        $color = get_background_color() ?: false;
        if($color) {
            $color = [
            "color" => $color,
            "slug" => "background",
            "name" => __('Background', 'ctx-theme'),
            "light" => self::get_brightness($color)
            ];
        }
        return $color;
    }

    public static function get_page_colors() {
        
    }

 
    /**
     * Rreturn an array with all our colors
     *
     * @param bool $inject_page_colors Inject primary and secondary color setting from the current page if present
     * @return array Colors
     * 
     */
    public function get($inject_page_colors = false) {
        if ($inject_page_colors) {
            return apply_filters('ctx_page_colors', $this->colors);
        }
        return $this->colors;
    }

    /**
     * Calculate the brightness of a color based on a threshold
     *
     * @param string $hex
     * @return bool true for bright, false for dark
     */
    public static function get_brightness($hex, $threshold = 170) { 
        if(!preg_match('/#(?:[0-9a-fA-F]{6})/', $hex)) {
            return false;
        }
        $hex = str_replace('#', '', $hex); 
        $c_r = hexdec(substr($hex, 0, 2)); 
        $c_g = hexdec(substr($hex, 2, 2)); 
        $c_b = hexdec(substr($hex, 4, 2)); 
        
        return intval((($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000) > $threshold;
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

        $red = hexdec(substr($hex, 1, 2));
        $redbase = hexdec("1" . substr($hex, 2, 1));
        $green = hexdec(substr($hex, 3, 2));
        $blue =  hexdec(substr($hex, 5, 2));
        $green_diff = $red - $green;
        $blue_diff = $red - $blue;
        $greenbase = $redbase - $green_diff;
        $bluebase = $redbase  - $blue_diff;
        $base_gray = '#' . str_pad(dechex($redbase), 2, "0", STR_PAD_LEFT) . str_pad(dechex($greenbase), 2, "0", STR_PAD_LEFT) . str_pad(dechex($bluebase), 2, "0", STR_PAD_LEFT);


        $steps = [.95, .95, .90, .85, .8, .7, .5, .4, .3, .2];
        $grayscale = [];
        for ($i=1; $i < 10; $i++) { 
            $grayscale["gray-" . $i . "00"] = [
                "color" => self::adjust_brightness($base_gray, $steps[$i]),
                "light" => $i < 5,
            ];
        }
 
        return $grayscale;
    }


    public static function adjust_brightness($hexCode, $adjustPercent) {
        $hexCode = ltrim($hexCode, '#');
    
        if (strlen($hexCode) == 3) {
            $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
        }
    
        $hexCode = array_map('hexdec', str_split($hexCode, 2));
    
        foreach ($hexCode as & $color) {
            $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $adjustPercent);
    
            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }
    
        return '#' . implode($hexCode);
    }

    /**
     * Add twig filters for tinting colors
     *
     * @param \Twig\Twig $twig
     * @return \Twig\Twig
     */
    public static function add_twig_filter($twig)
    {
        $twig->addFilter( new \Twig\TwigFilter( 'darken', function( $color, $percent ) {
            if(!$color) {return;}
            $hex = new Hex($color);
            return $hex->darken($percent);
        } ) );
        $twig->addFilter( new \Twig\TwigFilter( 'lighten', function( $color, $percent ) {
            if(!$color) {return;}
            $hex = new Hex($color);
            return $hex->lighten($percent);
        } ) );
        $twig->addFilter( new \Twig\TwigFilter( 'tint', function( $color, $percent ) {
            if(!$color) {return;}
            $hex = new Hex($color);
            return $hex->tint($percent);
        } ) );
        $twig->addFilter( new \Twig\TwigFilter( 'shade', function( $color, $percent ) {
            if(!$color) {return;}
            $hex = new Hex($color);
            return $hex->shade($percent);
        } ) );
        $twig->addFunction( new \Twig\TwigFunction( 'editor-color-palette', function( $slug ) {
            $color = [];
            $colors = get_theme_support('editor-color-palette');
            //var_dump($colors);
            foreach ($colors[0] as $set) {
                //var_dump($set);
                if($set['slug'] === $slug) {
                    $color = $set;
                    break;
                }
            }

        return $color;
        } ) );

        return $twig;
    }


}