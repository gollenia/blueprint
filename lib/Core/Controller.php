<?php

namespace Contexis\Core;

/**
 * The Page-Controller creates a PHP-Array ($context), which stores all data to render the page or to return JSON.
 * 
 * @since 1.0.0
 */
class Controller {

    protected array $context = [];
    protected array $templates = [];

    /**
     * Constructor
     * 
     * @param \Contexis\Core\Site $site A Site Object
     * @param string $template Twig template to be rendered
     * @since 1.0.0
     */
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
     *  Set Template file
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
     *  Render page with twig/timber
     * 
     * @since 1.0.0
     * @todo return rendered code instead of echoing it
     * 
     */
    public function render() {
        if( WP_DEBUG === true ) { 
            \Contexis\Core\Utilities::debug($this->context);
        }
        \Timber\Timber::render( $this->templates, $this->context );
    }

    /**
     *  Return Contetn as JSON
     * 
     *  For AJAX calls, it may come in handy to return a JSON Object
     * 
     * @since 1.0.0
     * 
     * @param int $options JSON Options
     * @param int $depth Max depth of the JSON Object
     * 
     * @return string Stringified JSON Object
     * 
     */
    public function returnJson(int $options = 0, int $depth = 512) {
        header('Content-Type: application/json');
        return json_encode($this->context, $options, $depth);
    }

}