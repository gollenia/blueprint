<?php

namespace Contexis\Controllers;

use \Timber\URLHelper;
use \Timber\Helper;
use \Timber\Request;
use \Timber\User;

/**
 * Der Seiten-Controller erstellt einen PHP-Array (Context), in dem alle für den Aufbau der Seite benötigten
 * Informationen gespeichert werden. 
 * 
 * @since 1.0.0
 */

class Page {

    private $context = [];
    private $templates = [];

    public function __construct($site, $template = false) {

        // these come from the original timber-context function
        $this->context['http_host'] = URLHelper::get_scheme().'://'.URLHelper::get_host();
        //$this->context['wp_title'] = Helper::get_wp_title();
        
        // Diese Variable sollte eigentlich in den Post-Intalt
        $this->context['body_class'] = implode(' ', get_body_class());
        
        // Das Site-Objekt. 
        $this->context['site'] = $site;

        // Der Request
        $this->context['request'] = new Request();
        
        // Das User-Objekt, falls angemeldet - sonst false
        $user = new User();
        $this->context['user'] = ($user->ID) ? $user : false;

        // Informationen über das Theme, wie URI, Name, etc
        $this->context['theme'] = $site->theme;

        // Der aktuelle Post
        $this->context['post'] = new \Timber\Post();

        // Die Widgets
        $this->context['footer'] = \Timber::get_widgets('footer_area');

        // Das Menü
        $this->context['menu'] = new \Timber\Menu();

        $this->templates = $this::setTemplate();

        // Wenn der Debug-Mode aktiviert ist, gib den Kontext über die JS-Console aus
        if( WP_DEBUG === true ) { 
            \Contexis\Core\Utilities::debug($this->context);
        }
        
        
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

    protected function setTemplate() {
        return array( 'pages/page-' . $this->context['post']->post_name . '.twig', 'pages/index.twig' );
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