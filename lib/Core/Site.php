<?php

namespace Contexis\Core;

/**
 * Child Class of the \Timber\Site Object. Collects data about the Page and sets up Wordpress
 * functions such as Theme-Support, Widgets, Shortcodes, etc. 
 * 
 * @since 1.0.0
 */

class Site extends \Timber\Site {

	/**
	 * Must be a \Contexis\Core\Config object
	 */
	private \Contexis\Core\Config $config;

	/**
	 * Constructor loads config and parent constructor
	 * 
	 * @since 1.0.0
	 * 
	 */
	public function __construct($config) {
		$this->config = $config;
		$this->add_wordpress_functions();
		$this->add_timber_functions();
		parent::__construct();
		add_action( 'init', [$this, 'add_taxonomies_to_pages'] );
	}

	/**
	 * add_taxonomies_to_pages()
	 * 
	 * Add Taxonomy to normal pages. Must be hooked into init
	 * 
	 * @since 1.0.0
	 */
	public function add_taxonomies_to_pages() {
		register_taxonomy_for_object_type( 'post_tag', 'page' );
		register_taxonomy_for_object_type( 'category', 'page' );
	}

	/**
	 * getConfig()
	 * 
	 * get config as array, used in controller
	 * 
	 * @since 1.0.0
	 */
	public function getConfig() {
		return $this->config->get();
	}

	/**
	 * Calls all Wordpress related functions
	 * 
	 * @since 1.0.0
	 */
	private function add_wordpress_functions() {

		\Contexis\Wordpress\ThemeSupport::register($this->config->get('theme_support'));
		\Contexis\Wordpress\Widgets::register($this->config->get('widgets'));
		\Contexis\Wordpress\Mime::register($this->config->get('mimes'));
		\Contexis\Wordpress\Assets::register($this->config->get('assets'));
		\Contexis\Wordpress\Taxonomy::register($this->config->get('taxonomies'));
		\Contexis\Wordpress\Shortcode::register();
		\Contexis\Wordpress\Block::register($this->config->get('blocks'));
		
		// plugin-dependent
		\Contexis\Core\Fields::register($this->config->get('fields'));

		// remove automatic <p>-tags
		remove_filter('the_content', 'wpautop');

		// use Gutenberg Block Editor in Events-Manager
		define('EM_GUTENBERG', true);
	}

	/**
	 * Calls all Timber related functions
	 * 
	 * @since 1.0.0
	 */
	private function add_timber_functions() {
		//setlocale(LC_ALL, $this->config->get('site.locale'));
		\Timber\Timber::$dirname = $this->config->get('site.template_folder');
	}
	
}