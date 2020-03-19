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
    }

    /**
	 * Widgets hinzufügen, die in /config/site.php abgespeichert sind.
	 * 
	 * @since 1.0.0
	 */
	public function renderAcfBlock($block, $content = '', $is_preview = false, $post_id = 0) {
		
		\Contexis\Core\Utilities::debug($block);
		\Timber\Timber::render('blocks/' . $block['name'] . '.twig', $block);
	}
}