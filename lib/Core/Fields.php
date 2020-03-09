<?php
namespace Contexis\Core;

/**
 * Classification of Advanced Custom Fields
 * 
 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
 * 
 * @since 1.0.0
 */

class Fields {

    /**
	 * Speichert die Konfiguration, die unter /config/fields.php zu finden ist
	 */
    private $fields;
    private $blocks;

    public function __construct() {
        $config = \Contexis\Core\Config::load('fields');
        $this->fields = $config['fields'];
        $this->blocks = $config['blocks'];
        add_action('acf/init', array($this, 'addAcfBlocks'));
    }

    /**
	 * Widgets hinzufügen, die in /config/site.php abgespeichert sind.
	 * 
	 * @since 1.0.0
	 */
	public function addAcfBlocks () {
		if( function_exists('acf_register_block_type') ) {
			for ($i=0; $i < count($this->blocks) ; $i++) { 
				$block = $this->blocks[$i];
				$block['render_callback'] = array($this, "renderAcfBlock");
				acf_register_block_type($block);
			}
		}
	}

	public function renderAcfBlock($block, $content = '', $is_preview = false, $post_id = 0) {
		
		\Contexis\Core\Utilities::debug($block);
		\Timber\Timber::render('blocks/' . $block['name'] . '.twig', $block);
	}
}