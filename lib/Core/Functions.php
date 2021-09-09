<?php
/**
 * Child Class of the \Timber\Site Object. Collects data about the Page and sets up Wordpress
 * functions such as Theme-Support, Widgets, Shortcodes, etc. 
 * 
 * @since 1.4.0
 */

namespace Contexis\Core;

use Contexis\Core\Config;
use Contexis\Core\Color;
use Contexis\Core\TwigExtensions;
use Contexis\Wordpress\Plugins\Fields;
use Contexis\Wordpress\{
	ThemeSupport,
	Widgets,
	Mime,
	Assets,
	Taxonomy,
	Block,
	Security
};

class Functions {
    
	/**
	 * Load different Wordpress functions
	 * 
	 * @since 1.4.0
	 * 
	 */
	public static function init() {
        
        Fields::register(Config::load('fields'));
        Widgets::register(Config::load('widgets'));
        Mime::register(Config::load('mimes'));
		TwigExtensions::register();
        Assets::register(Config::load('assets'));
        Taxonomy::register(Config::load('taxonomies'));
        Block::register(Config::load('blocks'));
		self::add_wordpress_functions();
		self::add_theme_colors();
		self::add_timber_functions();
		self::custom_functions();		
	}

	/**
	 * add_taxonomies_to_pages()
	 * 
	 * Add Taxonomy to normal pages. Must be hooked into init
	 * 
	 * @since 1.0.0
	 */
	public static function add_taxonomies_to_pages() {
		register_taxonomy_for_object_type( 'post_tag', 'page' );
		register_taxonomy_for_object_type( 'category', 'page' );
		add_post_type_support( 'page', 'excerpt' );
	}

	/**
	 * Calls all Wordpress related functions
	 * 
	 * @since 1.0.0
	 */
	private static function add_wordpress_functions() {
		add_action( 'init', [__CLASS__, 'add_taxonomies_to_pages'] );
		add_filter('block_editor_settings_all', [__CLASS__, 'removeCorePatterns']);
		load_theme_textdomain('ctx-theme', get_template_directory() . '/lang');
		// remove automatic <p>-tags
		remove_filter('the_content', 'wpautop');
		
		Security::disable_feed();
		Security::disable_xmlrpc();
		Security::clean_header();
		//Security::limit_login_attempts(5);

		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'rsd_link');
        
        update_option( 'large_size_w', 1280 );
        update_option( 'large_size_h', 900 );

        update_option( 'medium_size_w', 640 );
        update_option( 'large_size_h', 600 );

        add_image_size( "huge", 2560, 1800 );

	}

	// remove Block patterns, which only generate errors in the console.
	public static function removeCorePatterns(array $settings): array
	{
		$settings['__experimentalBlockPatterns'] = [];
		return $settings;
	}

	private static function add_theme_colors() {
		$colors = new Color(Config::load('colors'));
		$theme_colors = $colors->get();
		$theme_support = Config::load('theme_support');
		$theme_support['editor-color-palette'] = $theme_colors;
		ThemeSupport::register($theme_support);
		$colors->add_admin_color_css();
	}


	/**
	 * Calls all Timber related functions
	 * 
	 * @since 1.0.0
	 */
	private static function add_timber_functions() {
		\Timber\Timber::$dirname = "templates";
		add_filter( 'timber/twig', "\Contexis\Core\Color::add_twig_filter" );
	}

	/**
	 * Call custom functions for plugins etc.
	 * 
	 * @since 1.0.0
	 */
	private static function custom_functions() {
		\Contexis\Wordpress\Plugins\ContactForm7::add_custom_attribute("booking");
		\Contexis\Wordpress\Plugins\ContactForm7::add_required_to_wpcf7();
		\Contexis\Wordpress\Plugins\ContactForm7::remove_span_wrap();
	}


	
}