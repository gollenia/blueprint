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
	 * @param \Contexis\Core\Config $config config Object
	 * @since 1.0.0
	 * 
	 */
	public function __construct($config) {
		$this->config = $config;
		$this->add_wordpress_functions();
		$this->add_timber_functions();
		$this->custom_functions();
		parent::__construct();
		add_action( 'init', [$this, 'add_taxonomies_to_pages'] );
		if( WP_DEBUG ) {
			$this->development_functions();
		}
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
		add_post_type_support( 'page', 'excerpt' );
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

	private function development_functions() {
		\Contexis\Wordpress\Assets::writeColorsToScss($this->config->get('theme_support.editor-color-palette'));
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

		$this->add_required_to_wpcf7();
		
	}

	
	/**
	 * Hack for Contact form 7 to add "required" attribute, will hopefully becom
	 * deprecated in future
	 * 
	 * @since 1.0.0
	 */
	private function add_required_to_wpcf7() {
		add_filter( 'wpcf7_form_elements', function($content) {
			return str_replace('aria-required="true"', 'required aria-required="true"', $content);
		});
	}


	/**
	 * Calls all Timber related functions
	 * 
	 * @since 1.0.0
	 */
	private function add_timber_functions() {
		\Timber\Timber::$dirname = $this->config->get('site.template_folder');
		add_filter( 'timber/twig', "\Contexis\Core\Color::add_twig_filter" );
	}

	private function custom_functions() {
		\Contexis\Wordpress\Plugins\ContactForm7::addCustiomAttribute("booking");
	}
	
}