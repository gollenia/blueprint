<?php
/**
 * Additional twig-functions for working with colors. Utilizes OzdemirBuraks Color-Tools
 * 
 * @since 1.0.0
 * @deprecated 1.5
 * @link https://github.com/ozdemirburak/iris
 */

namespace Contexis\Core;
use OzdemirBurak\Iris\Color\Hex;

class Color {

    private $colors = [];

    private $color_fields = [
        "key" => "color_fields",
        "title" => "Globale Farbpalette",
        'instructions' => 'Hier können eigene Farbnuancen für die Seite eingestellt werden.',
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
        "theme_colors" => [
            'page_title'    => 'Farb-Einstellungen',
            'menu_title'    => 'Farb-Einstellungen',
            'menu_slug'     => 'theme-colors',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'parent_slug' => 'options-general.php',
         ]
    ];
    
    private $page_color = [
        "key" => "page_colors",
            "title" => "Seitenfarbe",
            "fields" => [
                [
                    "key" => "primarycolor",
                    "label" => "Primärfarbe",
                    "name" => "primarycolor",
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
                        "value" => "theme-colors"
                    ]
                ]
            ],
            'position' => 'side',
        ];


    /**
     * We have to iterace the colors twice, because we cannot call get_fields() before register_fields()
     *
     * @param array $colors
     */
    public function __construct($colors) {
        foreach($colors as $color) {
            array_push($this->color_fields["fields"], $this->create_color_field($color));
            $this->color_option_field($color);
        }

        \Contexis\Wordpress\Plugins\Fields::registerPages($this->color_page);
        \Contexis\Wordpress\Plugins\Fields::registerFields(array($this->color_fields));
        \Contexis\Wordpress\Plugins\Fields::registerFields(array($this->page_color));
        $this->colors = $this->fetch_custom_colors($colors);
    }

    private function color_option_field($color) {
        $field_label = '<div style="display: flex; align-items: center"> <span style="display: inline-block; border-radius: 100%;  margin-right: 5px; height: 16px; width: 16px; background-color: var(--' . $color['slug'] . ');" class=""></span> ' . $color["name"] . "</div>";
        $this->page_color["fields"][0]["choices"][$color["slug"]] = $field_label;
        $this->page_color["fields"][1]["choices"][$color["slug"]] = $field_label;
    }

    public function add_admin_color_css() { 
        $stylesheet = ":root {";
        foreach ($this->colors as $color) {
            $stylesheet .= "--" . $color['slug'] . ": " . $color["color"] . ";";
        }
        $stylesheet .= "}";
        add_action('admin_enqueue_scripts', function() use (&$stylesheet) {
            wp_register_style( 'admin-custom-colors' , false );
            wp_enqueue_style( 'admin-custom-colors' );
            wp_add_inline_style('admin-custom-colors', $stylesheet);
        });
    }

    /**
     * Create fields for Theme-Color Page from color array
     *
     * @param [type] $color
     * @return void
     */
    private function create_color_field($color) {
        return [
            "key" => 'theme_color_' . $color['slug'],
            "label" => $color['name'],
            "name" => $color['name'],
            "type" => "color_picker",
            'default_value' => $color['color'],
        ];
    }

    /**
     * Iterate colors, get the custom field value if set and add some custom stuff
     *
     * @param [type] $colors
     * @return void
     */
    public function fetch_custom_colors($colors) {
        $color_sets = [];
        foreach($colors as $color) {
            
            $hex = get_field('theme_color_' . $color['slug'], "options") ?: $color["color"];
            $new_color = [
                "slug" => $color['slug'],
                "name" => $color['name'],
                "color" => $hex,
                "brightness" => $this->get_brightness($hex) < 170 ? "dark" : "light",
                "transparent" => $hex . "aa"
            ];
            array_push($color_sets, $new_color);
        }
        return $color_sets;
        
    }

    public function register_fields() {
        
    }

    public function get() {
        return $this->colors;
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

    // To own Color Calss
    function get_brightness($hex) { 
        $hex = str_replace('#', '', $hex); 
        $c_r = hexdec(substr($hex, 0, 2)); 
        $c_g = hexdec(substr($hex, 2, 2)); 
        $c_b = hexdec(substr($hex, 4, 2)); 
        
        return intval((($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000);
    }

    //maybe we can get rid of these...
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
        $twig->addFunction( new \Twig\TwigFunction( 'isLight', function( $color ) {
            if(!$color) {return;}
            $hex = new Hex($color);
            return $hex->isLight();
        } ) );
        $twig->addFunction( new \Twig\TwigFunction( 'isDark', function( $color ) {
            if(!$color) {return;}
            $hex = new Hex($color);
            return $hex->isDark();
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