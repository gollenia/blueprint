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
	 * Speichert die Kinfiguration, die unter /config/site.php zu finden ist
	 */
    private $fields;
    private $blocks;

    public function __construct() {
        $config = \Contexis\Core\Config::load('fields');
        $this->fields = $config['fields'];
        $this->blocks = $config['blocks'];
    }

    /**
     *  Cast any variable into the Browser Javascript Console. Better way to analyze arrays than var_dump.
     * 
     * @since 1.0.0
     * 
     * @param $value Which content should be fetched?
     * 
     * @return mixed whatever is stored in the key
     * 
     */
    public static function debug($value = "nothing to debug") {
        echo "<script>console.log(" . json_encode($value) . ");</script>";
    }

    public static function render($context) {
        var_dump($context);
        echo "Hihi";
    }
}