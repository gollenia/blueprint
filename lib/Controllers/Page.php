<?php

namespace Contexis\Controllers;

/**
 * Page Controller, which collects page data ("context") and renders it.
 * 
 * @since 1.0.0
 */

class Page {

    private $context = [];
    private $templates = [];

    public function __construct() {
        $this->context = \Timber::context();
        $this->context['post'] = new \Timber\Post();
        $this->context['footer'] = \Timber::get_widgets('footer_area');
        $this->context['menu'] = new \Timber\Menu();
        $this->templates = array( 'pages/page-' . $this->context['post']->post_name . '.twig', 'pages/index.twig' );
    }
    /**
     *  Add Content to Controller
     * 
     * @since 1.0.0
     * 
     * @param string $key How sould this content item be available in twig?
     * @param mixed Content to be aded. This can be an array, an Object or simple strings, integers, etc.
     * @param bool $force Overwrites data, if Key already exists. Default is false.
     * 
     * @return bool Returns false, if key already exists. If key already exists and $force is false, the functio returns false, else true.
     * 
     */
    public function addContent (string $key, array $context, bool $force = false) {
        if (array_key_exists( $key , $this->context) && !$force) {
            return false;
        }

        $this->context[$key] = $context;
        return true;
    }

    public function addImage() {}

    public function addQuery() {}

    /**
     *  Get Content from Controller
     * 
     * @since 1.0.0
     * 
     * @param string $key Which content should be fetched?
     * 
     * @return mixed whatever is stored in the key
     * 
     */
    public function getContent(string $key = "") {
        if ($key == "") { return $this->context; }
        return $this->context[$key];
    }

    /**
     *  Render Content to Twig
     * 
     * @since 1.0.0
     * 
     * @param string $key Which content should be fetched?
     * 
     * @return mixed whatever is stored in the key
     * 
     */
    public function render() {
        \Timber::render( $this->templates, $this->context );
    }

    public function returnJson(int $options = 0, int $depth = 512) {
        header('Content-Type: application/json');
        return json_encode($this->context, $options, $depth);
    }

}