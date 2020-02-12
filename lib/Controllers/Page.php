<?php

namespace Contexis\Controllers;

/**
 * Der Seiten-Controller erstellt einen PHP-Array (Context), in dem alle für den Aufbau der Seite benötigten
 * Informationen gespeichert werden. 
 * 
 * @since 1.0.0
 */

class Page {

    protected $context = [];
    protected $templates = [];

    public function __construct($site, $template = false) {
        
        // Diese Variable sollte eigentlich in den Post-Intalt
        $this->context['body_class'] = implode(' ', get_body_class());
        
        // Das Site-Objekt. 
        $this->context['site'] = $site;
        
        // Das User-Objekt, falls angemeldet - sonst false
        //$user = new User();
        //$this->context['user'] = ($user->ID) ? $user : false;

        // Der aktuelle Post
        $this->context['post'] = new \Timber\Post();

        // Die Widgets
        $this->context['footer'] = \Timber\Timber::get_widgets('footer_area');

        // Das Menü
        $this->context['menu'] = new \Timber\Menu();

        $this->templates = $this::setTemplate();
    }
    
    /**
     *  Template festlegen
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
     *  Seite mit Twig rendern
     * 
     * @since 1.0.0
     * 
     */
    public function render() {
        if( WP_DEBUG === true ) { 
            \Contexis\Core\Utilities::debug($this->context);
        }
        \Timber\Timber::render( $this->templates, $this->context );
    }

    /**
     *  Inhalt als JSON ausgeben
     * 
     *  Für AJAX-Anwendungen kann es sinnvoll sein, den Inhalt als JSON zurückzugeben
     * 
     * @since 1.0.0
     * 
     * @param int $options Ausgabe Optionen
     * 
     * @return string Fertiges JSON-Objekt
     * 
     */
    public function returnJson(int $options = 0, int $depth = 512) {
        header('Content-Type: application/json');
        return json_encode($this->context, $options, $depth);
    }

}