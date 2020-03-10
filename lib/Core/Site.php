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

	/**
	 * Speichert die Konfiguration, die unter /config/site.php zu finden ist
	 */
	private $config;

	/**
	 * Hier werden im Prinzip alle Funktionen ausgeführt, die normalerweise in 
	 * functions.php zu finden sind. Von dort aus wird die Klasse auch initiiert.
	 * 
	 * @since 1.0.0
	 * 
	 * @todo Aufräumen: Was wird wirklich benötigt?
	 */
	public function __construct() {

		// aus dem config-Folder das Site-Objekt laden
		$this->config = Config::load('site');
		setlocale(LC_TIME, $this->config['locale']);
		\Timber\Timber::$dirname = $this->config['template_folder'];
		$this->addThemeSupport($this->config['theme_support']);
		$this->addWidgets($this->config["widgets"]);
		//$this->addThemeSupport(['editor-color-palette', $config->colors]);
		\add_filter( 'timber/context', array( $this, 'createContext' ) );
		//add_filter('upload_mimes', array($this, 'addMimeTypes', 1, 1));
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

	/**
	 * MIME-Typen hinzufügen. Im jetzigen Zustand funtioniert die Funktion nicht, weil die vorhandenen Mime-Types nicht übergeben werden.
	 * 
	 * @since 1.0.0
	 * 
	 * @return array Array mit den Mime-Typen
	 * 
	 * @todo Funktion so schreiben, dass sie funktioniert
	 */
	public function addMimeTypes($mime_types) {
		var_dump($mime_types);
		array_push($mime_types, $this->config['mimes']);
        return $mime_types;
	}

	
	/**
	 * Shortcodes im Verzeichnis /lib/Shortcodes sammlen und initiieren
	 * 
	 * @since 1.0.0
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

	/**
	 * Existierende Blöcke können mit ACF (derzeit noch) nicht überschrieben werden.
	 * Blocks im Verzeichnis /lib/Blocks sammlen und initiieren
	 * 
	 * @since 1.0.0
	 */
	private function addBlocks() {
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

	/**
	 * Widgets hinzufügen, die in /config/site.php abgespeichert sind.
	 * 
	 * @since 1.0.0
	 */
	public function addWidgets ($widgets) {
		$this->addHook('action', 'widgets_init', function() use ($widgets){
			foreach ($widgets as $area) {
				register_sidebar($area);	
			}	
		});	
	}

	

	/**
	 * Widgets hinzufügen, die in /config/site.php abgespeichert sind.
	 * 
	 * @since 1.0.0
	 * 
	 * @ignore
	 */
	public function deregisterStyles($styles) {
		$this->addHook('action', 'wp_print_styles', function() use ($styles){
			foreach($styles as $style) {
				wp_dequeue_style( $style );
			}		
		});
	}

	
	/**
	 * Theme-Supports hinzufügen, die in /config/site.php abgespeichert sind.
	 * 
	 * @since 1.0.0
	 * 
	 */
	public function addThemeSupport($features) {
		//var_dump($features);
		$this->addHook('action', 'after_setup_theme', function() use ($features){
			
			foreach((array) $features as $key => $value) {
				//echo $key;
				if(empty($value)) {
			
					add_theme_support( $key );
					continue;
				}
				
				add_theme_support( $key, $value );
			}		
	
		});
		
	}

}