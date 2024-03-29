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
	Mime,
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
		Mime::register(Config::load('mimes'));
		Assets::register();
		Cookies::init();
		self::add_wordpress_functions();
		self::add_theme_colors();
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
		
		add_action( 'do_meta_boxes', [__CLASS__, 'remove_default_custom_fields_meta_box'], 1, 3 );

		update_option('large_size_w', 1440);
		update_option('large_size_h', 900);

		update_option('medium_size_w', 640);
		update_option('medium_size_h', 600);
	}

	public static function remove_default_custom_fields_meta_box( $post_type, $context, $post ) {
		remove_meta_box( 'postcustom', $post_type, $context );
	}

	private static function add_theme_colors()
	{
		$colors = \Contexis\Core\Color::register();
		$theme_support = Config::load('theme_support');
		//$theme_support['editor-color-palette'] = array_values($colors->get_editor_colors(true));
		ThemeSupport::register($theme_support);
	}

}
