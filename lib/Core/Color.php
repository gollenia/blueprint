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
    
    private $page_color = [
        "key" => "page_colors",
            "title" => "Farbeinstellungen",
            "fields" => [
                [
                    "key" => "primarycolor",
                    "label" => "Primärfarbe",
                    "name" => "pagecolor",
                    'type' => 'select',
                    'ui' => 1,
                    'choices' => [
                        "" => "Standard"
                    ]
                ],
                [
                    "key" => "secondarycolor",
                    "label" => "Sekundärfarbe",
                    "name" => "secondarycolor",
                    "type" => "select",
                    'ui' => 1,
                    'choices' => [
                        "" => "Standard"
                    ]
                ]
            ],
            "location" => [
                [
                    [
                        "param" => "post_type",
                        "operator" => "==",
                        "value" => "page"
                    ]
                ],
                [
                    [
                        "param" => "post_type",
                        "operator" => "==",
                        "value" => "post"
                ]
                ],
                [
                    [
                        "param" => "post_type",
                        "operator" => "==",
                        "value" => "event"
                    ]
                ],
                [
                    [
                        'param' => 'options_page',
                        "operator" => "==",
                        "value" => "theme-settings"
                    ]
                ]
            ],
            'menu_order' => 0,
            'position' => 'side',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ];

    public function __construct($colors) {
        $this->colors = $colors;
        $this->colors = $this->get_theme_colors($this->colors);
        foreach($this->colors as $color) {
            array_push($this->color_fields["fields"], $this->create_color_field($color));
            $this->page_color["fields"][0]["choices"][$color["slug"]] = '<div style="display: flex; align-items: center"> <span style="display: inline-block; margin-right: 5px; height: 16px; width: 16px; background-color: ' . $color["color"] . ';" class=""></span> ' . $color["name"] . "</div>";
            $this->page_color["fields"][1]["choices"][$color["slug"]] = '<div style="display: flex; align-items: center"> <span style="display: inline-block; margin-right: 5px; height: 16px; width: 16px; background-color: ' . $color["color"] . ';" class=""></span> ' . $color["name"] . "</div>";
        }
       
        \Contexis\Wordpress\Plugins\Fields::registerPages($this->color_page);
        \Contexis\Wordpress\Plugins\Fields::registerFields(array($this->color_fields));
        \Contexis\Wordpress\Plugins\Fields::registerFields(array($this->page_color));

        
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
            
            $hex_value = get_field('theme_color_' . $color['slug'], "options");

            $new_color = [
                "slug" => $color['slug'],
                "name" => $color['name'],
                "color" => $hex_value,
                "brightness" => $this->get_brightness($hex_value) < 170 ? "dark" : "light",
                "transparent" => $hex_value . "aa"
            ];

            

            array_push($colors, $new_color);
        }
        return $colors;
        
    }

    public static function  get_color_by_slug($slug) {
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
    }


    function get_brightness($hex) { 
        // returns brightness value from 0 to 255 
        // strip off any leading # 
        $hex = str_replace('#', '', $hex); 
        $c_r = hexdec(substr($hex, 0, 2)); 
        $c_g = hexdec(substr($hex, 2, 2)); 
        $c_b = hexdec(substr($hex, 4, 2)); 
        
        return intval((($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000);
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
        $twig->addFunction( new \Timber\Twig_Function( 'editor-color-palette', function( $slug ) {
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