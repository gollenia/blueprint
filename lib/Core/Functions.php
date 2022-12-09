<?php

/**
 * 
 * functions such as Theme-Support, Widgets, Shortcodes, etc. 
 * 
 * @since 1.4.0
 */

namespace Contexis\Core;

use Contexis\Core\Config;
use Contexis\Core\Cookies;

use Contexis\Wordpress\{
	ThemeSupport,
	Widgets,
	Mime,
	Post,
	Assets,
	Security
};

class Functions
{

	/**
	 * Load different Wordpress functions
	 * 
	 * @since 1.4.0
	 * 
	 */
	public static function init()
	{
		Widgets::register(Config::load('widgets'));
		Mime::register(Config::load('mimes'));
		Assets::register();
		Cookies::init();
		self::add_wordpress_functions();
		self::add_theme_colors();
		self::custom_functions();
	}

	/**
	 * Add Taxonomy to normal pages. Must be hooked into init
	 * 
	 * @return void
	 * @since 1.0.0
	 */
	public static function add_taxonomies_to_pages()
	{
		register_taxonomy_for_object_type('post_tag', 'page');
		register_taxonomy_for_object_type('category', 'page');
		add_post_type_support('page', 'excerpt');
	}

	/**
	 * Calls all Wordpress related functions
	 * 
	 * @return void
	 * @since 1.0.0
	 */
	private static function add_wordpress_functions()
	{
		add_action('init', [__CLASS__, 'add_taxonomies_to_pages']);

		load_theme_textdomain('ctx-theme', get_template_directory() . '/lang');
		// remove automatic <p>-tags
		remove_filter('the_content', 'wpautop');

		Security::disable_feed();
		Security::disable_xmlrpc();
		Security::clean_header();
		//Security::limit_login_attempts(5);

		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'rsd_link');

		update_option('large_size_w', 1440);
		update_option('large_size_h', 900);

		update_option('medium_size_w', 640);
		update_option('medium_size_h', 600);
	}


	/*
	* Add custom colors to the editor. Maybe this will work with theme,json later?
	*/
	private static function add_theme_colors()
	{
		$colors = \Contexis\Core\Color::register();
		$theme_support = Config::load('theme_support');
		$theme_support['editor-color-palette'] = array_values($colors->get_editor_colors(true));
		ThemeSupport::register($theme_support);
	}


	/**
	 * Call custom functions for plugins etc.
	 * CF7 will disappear in future
	 * @since 1.0.0
	 */
	private static function custom_functions()
	{
		\Contexis\Wordpress\Plugins\ContactForm7::add_custom_attribute("booking");
		\Contexis\Wordpress\Plugins\ContactForm7::add_required_to_wpcf7();
		\Contexis\Wordpress\Plugins\ContactForm7::remove_span_wrap();
	}
}
