<?php

namespace Contexis\Core;

/**
 * Der Seiten-Controller erstellt einen PHP-Array (Context), in dem alle für den Aufbau der Seite benötigten
 * Informationen gespeichert werden. 
 * 
 * @since 1.0.0
 */

class Controller {

    protected array $context = [];
    protected array $templates = [];

    public function __construct(\Contexis\Core\Site $site, string $template = "") {

        global $wp_customize;
        
        // Diese Variable sollte eigentlich in den Post-Intalt
        $this->context['body_class'] = implode(' ', get_body_class());
        
        // Das Site-Objekt. 
        $this->context['site'] = $site;

        $this->context['config'] = $site->getConfig();

        // Advanced Custom Field Plugin
        if (function_exists('get_fields')) {
            $this->context['fields'] = get_fields('option');
        }

        $post = \Timber\Timber::get_post();

        if($post) {
            $this->context['categories'] = $post->terms( 'category' );
            // Der aktuelle Post
            $this->context['post'] = new \Timber\Post();
        }

        // Die Widgets
        $this->context['footer'] = \Timber\Timber::get_widgets('footer_area');

        // Das Menü
        $this->context['menu'] = new \Timber\Menu();

        $this->setTemplate($template);

    }
    
    /**
     *  Template festlegen
     * 
     * @since 1.0.0
     * 
     * @param string $key How sould this content item be available in twig?
     * 
     * @return bool Returns false, if key already exists. If key already exists and $force is false, the functio returns false, else true.
     * 
     */

    protected function setTemplate(string $template) {
        if ($template === "") {
            $this->templates = array( 'pages/page.twig' );    
        }
        
        $this->templates = [$template, 'pages/page.twig'];
    }

    public function addToContext(array $context) {
        foreach($context as $key => $value) {
            $this->context[$key] = $value;
        }
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