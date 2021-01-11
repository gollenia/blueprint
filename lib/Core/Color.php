<?php
/**
 * Additional twig-functions for working with colors. Utilizes OzdemirBuraks Color-Tools
 * 
 * @since 1.0.0
 * @link https://github.com/ozdemirburak/iris
 */

namespace Contexis\Core;
use OzdemirBurak\Iris\Color\Hex;

class Color {

    private $colors = [];
    private $color_fields = [
        "key" => "color_fields",
        "title" => "Farb-Einstellungen",
        "fields" => [],
        "location" => [
            [
                [
                    'param' => 'options_page',
                    "operator" => "==",
                    "value" => "theme-colors"
                ]
            ]
        ],

    ];

    private $color_page = [
        "theme_options" => [
            'page_title'    => 'Theme-Farben',
            'menu_title'    => 'Theme-Farben',
            'menu_slug'     => 'theme-colors',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'parent_slug' => 'options-general.php',
         ]
        ];

    public function __construct($colors) {
        $this->colors = $colors;
        foreach($this->colors as $color) {
            array_push($this->color_fields["fields"], $this->create_color_field($color));
        }
        
        \Contexis\Wordpress\Plugins\Fields::registerPages($this->color_page);
        \Contexis\Wordpress\Plugins\Fields::registerFields(array($this->color_fields));
        
    }

    
    private function create_color_field($color) {
        return [
            "key" => 'theme_color_' . $color['slug'],
            "label" => $color['name'],
            "name" => $color['name'],
            "type" => "color_picker",
            'default_value' => $color['color'],
        ];
    }

    public function get_theme_colors () {
        $colors = [];
        foreach($this->colors as $color) {
            $new_color = [
                "slug" => $color['slug'],
                "name" => $color['name']
            ];
            
            $hex_value = get_field('theme_color_' . $color['slug'], "options");
            
            $new_color["color"] = $hex_value;
            $hex = new Hex($hex_value);
            $hex->isDark() ? $new_color["dark"] = true : $new_color["dark"] = false;
            array_push($colors, $new_color);
        }
        return $colors;
    }

    public static function add_twig_filter($twig)
    {
        $twig->addFilter( new \Timber\Twig_Filter( 'darken', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->darken($percent);
        } ) );
        $twig->addFilter( new \Timber\Twig_Filter( 'lighten', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->lighten($percent);
        } ) );
        $twig->addFilter( new \Timber\Twig_Filter( 'tint', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->tint($percent);
        } ) );
        $twig->addFilter( new \Timber\Twig_Filter( 'shade', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->shade($percent);
        } ) );
        $twig->addFunction( new \Timber\Twig_Function( 'isLight', function( $color ) {
            $hex = new Hex($color);
            return $hex->isLight();
        } ) );
        $twig->addFunction( new \Timber\Twig_Function( 'isDark', function( $color ) {
            $hex = new Hex($color);
            return $hex->isDark();
        } ) );

        return $twig;
    }

}