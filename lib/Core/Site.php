<?php

namespace Contexis\Core;
use Contexis\Core\Config;


/**
 * Der Seiten-Controller erstellt einen PHP-Array (Context), in dem alle für den Aufbau der Seite benötigten
 * Informationen gespeichert werden. 
 * 
 * @since 1.0.0
 */

class Site extends \Timber\Site {

	private $config;

	/** Add timber support. */
	public function __construct() {

		// aus dem config-Folder das Site-Objekt laden
		$this->config = Config::load('site');

		setlocale(LC_TIME, $this->config['locale']);
		\Timber\Timber::$dirname = $this->config['template_folder'];
		$this->addThemeSupport($this->config['theme_support']);
		$this->addWidgets($this->config["widgets"]);
		//$this->addThemeSupport(['editor-color-palette', $config->colors]);
		add_filter( 'timber/context', array( $this, 'createContext' ) );
		add_filter('upload_mimes', array($this, 'addMimeTypes', 1, 1));
		//add_action( 'init', array( $this, 'register_post_types' ) );
		//add_action( 'init', array( $this, 'register_taxonomies' ) );
		$this->addShortcodes();
		$this->addBlocks();
		parent::__construct();
	}

	public function addHook( $type, $name, $function ) {  
		$type = strtolower( $type );
        if ( 'filter' === $type ) {
			add_filter( $name, $function );
			return;
        }
		add_action( $name, $function );
	}

	public function getConfig() {
		return($this->config);
	}

	public function addMimeTypes($mime_types) {
		array_push($mime_types, $this->config['mimes']);
        return $mime_types;
	}

	
	/**
	 * function addShortcodes
	 * 
	 * @since 1.0
	 */

	private function addShortcodes() {
		// get all shortcodes from the shortcodesfolder
		$files = scandir(__DIR__ . '/../Shortcodes');
		if (!$files) { return; }
		foreach($files as $file) {
			if ("php" === substr($file, -3)) {
				require_once(__DIR__ . '/../Shortcodes/' . $file);
				$shortcode = substr($file, 0, -4);
				add_shortcode( $shortcode, $shortcode . "_shortcode" );
			}
		}
	}

	private function addBlocks() {
		// get all blocks from the blocks folder
		// these are not new blocks but modifications of core-blocks
		// new blocks should be generated with react!
		$files = scandir(__DIR__ . '/../Blocks');
		if (!$files) { return; }
		foreach($files as $file) {
			if ("php" === substr($file, -3)) {
				require_once(__DIR__ . '/../Blocks/' . $file);
				
				$block = explode(".", substr($file, 0, -4))[1];
				$namespace = explode(".", substr($file, 0, -4))[0];
				add_action( 'init', function() use ($block, $namespace) {
					register_block_type( $namespace . '/' . $block, array(
						'render_callback' => $namespace . '_' . $block . '_render',
					) );
				});
			}
		}	
	}

	public function addWidgets ($widgets) {
		$this->addHook('action', 'widgets_init', function() use ($widgets){
			foreach ($widgets as $area) {
				register_sidebar($area);	
			}	
		});	
	}

	public function deregisterStyles($styles) {
		$this->addHook('action', 'wp_print_styles', function() use ($styles){
			foreach($styles as $style) {
				wp_dequeue_style( $style );
			}		
		});
	}

	
	// function for theme support
	public function addThemeSupport($features) {
		$this->addHook('action', 'after_setup_theme', function() use ($features){
			foreach((array) $features as $key => $value) {
				if(empty($value)) {
					add_theme_support( $key );
					return;
				}
				add_theme_support( $key, $value );
			}		
	
		});
		
	}

}