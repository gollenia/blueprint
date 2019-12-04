<?php

namespace Contexis\Classes;
use Symfony\Component\Yaml\Yaml;
$config = Yaml::parseFile(__DIR__ . '/config.yml');

/**
 * Class for managing Theme Options. An Admin-Page will be generated, and Theme Options can be loaded with get()
 * 
 * @since 1.0.0
 */

class Config {

    private $options = [];
    /**
     *  Initialize Class. Inject Theme Menu into Admin Menu
     * 
     * @since 1.0.0
     * 
     */
    public function __construct() {
        add_action('admin_menu', [$this, 'theme_menu']);
        define( 'DISALLOW_FILE_EDIT', true );
        $this->options = \Contexis\Config::get("options")
    }

    public function theme_menu() {
        add_theme_page("Theme Anpassungen", "Theme Anpassungen", "manage_options", "theme-options", [$this, 'theme_options'], null, 99);
    }

    public function theme_options() {
        foreach
    }

    public static function get

}