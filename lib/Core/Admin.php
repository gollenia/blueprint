<?php
namespace Contexis\Core;
use Contexis\Core\Config;

/**
 * Class for managing Theme Options. An Admin-Page will be generated, and Theme Options can be loaded with get()
 * 
 * @since 1.0.0
 */

class Admin {

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
        $this->options = Config::load("options");
        
    }

    public function theme_menu() {
        add_theme_page("Theme Anpassungen", "Theme Anpassungen", "manage_options", "theme_options", [$this, 'theme_options'], null, 99);
    }

    public function theme_options() {
        echo "hihi";
        add_settings_field (
            "facebook", 
            "Facebook", 
            function() {echo "hallo";},
            "theme_options"
        );
    }



}