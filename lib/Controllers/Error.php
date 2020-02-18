<?php

namespace Contexis\Controllers;

/**
 * Error-Controller
 * 
 * Wird geladen, wenn zB ein 404 Fehler auftaucht.
 * 
 * @since 1.0.0
 */

class Error {

    protected $context = [];
    protected $templates = [];

    public function __construct($site, $template = false) {
        
        // Diese Variable sollte eigentlich in den Post-Intalt
        $this->context['body_class'] = implode(' ', get_body_class());
        
        // Das Site-Objekt. 
        $this->context['site'] = $site;

        // Die Widgets
        $this->context['footer'] = \Timber\Timber::get_widgets('footer_area');

        // Das Menü
        $this->context['menu'] = new \Timber\Menu();

        $this->templates = $this::setTemplate();
    }
    
    /**
     * Template festlegen
     * 
     * @since 1.0.0
     * 
     * @return string Template-Dateiname
     * 
     */

    protected function setTemplate() {
        return 'pages/404.twig';
    }

    
    /**
     *  Seite mit Twig rendern
     * 
     * @since 1.0.0
     * 
     */
    public function render() {
        // Wenn der Debug-Modus aktiviert ist, wird der gesamte Seiten-Array in der Browser-Konsole geladen
        if( WP_DEBUG === true ) { 
            \Contexis\Core\Utilities::debug($this->context);
        }
        // Das eigentliche Seiten-Rendern
        \Timber\Timber::render( $this->templates, $this->context);
    }

    /**
     * Inhalt als JSON ausgeben
     * 
     * Für AJAX-Anwendungen kann es sinnvoll sein, den Inhalt als JSON zurückzugeben
     * Bei 404 wird lediglich ein leeres Objekt zurückzugeben.
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
        http_response_code (404);
        return json_encode("{}");
    }

}