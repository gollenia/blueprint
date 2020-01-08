<?php
namespace Contexis\Core;
use Contexis\Core\Config;

/**
 * Class for managing Theme Options. An Admin-Page will be generated, and Theme Options can be loaded with get()
 * 
 * @since 1.0.0
 */

class Options {

    const PAGE_NAME = 'theme_options';
    private $options = [];
    /**
     *  Initialize Class. Inject Theme Menu into Admin Menu
     * 
     * @since 1.0.0
     * 
     */
    public function __construct() {
        $this->options = Config::load("options");
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_init', [$this, 'admin_init']);
    }

    public function admin_menu() {
        add_theme_page("Theme Anpassungen", "Theme Anpassungen", "manage_options", self::PAGE_NAME, [$this, 'print_admin_page']);
    }

    public function admin_init() {
 
        register_setting('theme_options', 'theme_options');

        for($i = 0; $i < count($this->options['sections']); $i++) {
            $section = $this->options['sections'][$i];
            add_settings_section (
                $section['id'],
                $section['title'],
                [$this, 'print_section'],
                self::PAGE_NAME
            );
        }

        for($i = 0; $i < count($this->options['settings']); $i++) {
            $setting = $this->options['settings'][$i];
            add_settings_field (
                $setting['id'],
                $setting['title'],
                [$this, 'generate_text_field'],
                self::PAGE_NAME,
                $setting['section'],
                array(
                    'id' => $setting['id'],
                    'title' => $setting['title'], 
                )
            );
        }
         
         
    }

    public function print_admin_page() {
        echo "<h2>Optionen</h2>";
        echo '<form action="options.php" method="post">';
			echo settings_fields('theme_options');
			do_settings_sections('theme_options');
		echo '<input class="button-primary" type="submit" value="Save Changes" />';
		echo '</form>';
    }

    /**
     * 
     * Die Optionsfelder aus config/options.php werden durchgegangen und die entsprechenden Generator-Callbacks aufgerufen.
     * Diese Callbacks werden mehrfach verwendet!
     * 
     * @since 1.0.0
     * 
     * @link https://wordpress.stackexchange.com/questions/129180/add-multiple-custom-fields-to-the-general-settings-page
     */
    public function loop_settings() {
        
        

        
    }

    public function print_section($args) {
        echo "<h4>Optionen</h4>";
        Utilities::debug($args);
    }


    /**
     * 
     * Generator für einfache input-Felder. Der Generator wird mehrfach verwendet! Daher kein "hard-coding"!
     * 
     * @since 1.0.0
     * 
     * @param array $args Parameter des Callback-Aufrufes
     * 
     * @link https://wordpress.stackexchange.com/questions/129180/add-multiple-custom-fields-to-the-general-settings-page
     */
    public function generate_text_field($args) {
        $options = get_option($args['id']); 
        Utilities::debug($options);
        echo "<input type='text' id='" . $args['id'] . "' name='" . $args['id'] . "' value='" . $options[$args['id']] . "'>";
    }

    /**
     * 
     * Generator für checkbox-Felder. Der Generator wird mehrfach verwendet! Daher kein "hard-coding"!
     * 
     * @since 1.0.0
     * 
     * @param array $args Parameter des Callback-Aufrufes
     * 
     * @link https://wordpress.stackexchange.com/questions/129180/add-multiple-custom-fields-to-the-general-settings-page
     */
    public function generate_checkbox($args) {
        
    }

    /**
     * 
     * Generator für option-Felder. Der Generator wird mehrfach verwendet! Daher kein "hard-coding"!
     * 
     * @since 1.0.0
     * 
     * @param array $args Parameter des Callback-Aufrufes
     * 
     * @link https://wordpress.stackexchange.com/questions/129180/add-multiple-custom-fields-to-the-general-settings-page
     */
    public function generate_option($args) {
        
    }



}