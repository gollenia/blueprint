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
	private $config;

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
		\Timber\Timber::$dirname = $this->config->get('site.template_folder');
	}
	
}