<?php
/**
 * The Page-Controller creates a PHP-Array ($context), which stores all data to render the page or to return JSON.
 * 
 * @since 1.0.0
 */

namespace Contexis\Core;

use Contexis\Core\{
    Site,
    Utilities
};

use Timber\{
    Timber,
    Menu,
    Post
};


class Controller {

    protected array $context = [];
    protected array $templates = [ 'pages/page.twig' ];

    /**
     * Constructor
     * 
     * @todo This function is heavily overloaded!!!
     * 
     * @param \Contexis\Core\Site $site A Site Object
     * @param string $template Twig template to be rendered
     * @since 1.0.0
     */
    public function __construct(Site $site, string $template = null) {

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

        $post = Timber::get_post();

        if($post) {
            $this->context['categories'] = $post->terms( 'category' );
            // Der aktuelle Post
            $this->context['post'] = new Post();
        }

        $base = $post->primarycolor ?: get_field('primarycolor', "options");
        $this->context['primarycolor'] = \Contexis\Core\Color::get_color_by_slug($base);

        $base = $post->secondarycolor ?: get_field('secondarycolor', "options");
        $this->context['secondarycolor'] = \Contexis\Core\Color::get_color_by_slug($base);

        // Die Widgets
        $this->context['footer'] = Timber::get_widgets('footer_area');

        // Das Menü
        $this->context['menu'] = new Menu();

        $this->setTemplate($template);

    }
    
    /**
     *  Set Template file
     * 
     * @since 1.0.0
     * 
     * @param string $key How should this content item be available in twig?
     * 
     * @return bool Returns false, if key already exists. If key already exists and $force is false, the functio returns false, else true.
     * 
     */
    protected function setTemplate(string $template) {  
        if($template) {
            array_unshift($this->templates, $template);
        }      
        
    }

    public function addToContext(array $context) {
        foreach($context as $key => $value) {
            $this->context[$key] = $value;
        }
    }

    /**
     *  Get context (mainly fpr debugging)
     * 
     * @since 1.0.0
     * 
     * @param string $key which key of the context to return?
     * 
     * @return mixed return Data stored in context.
     * 
     */
    public function get_context($key = false) {
        if (!$key) {
            return $this->context;
        }

        return $this->context[$key];
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
            Utilities::debug($this->context);
        }
        Timber::render( $this->templates, $this->context );
    }

    /**
     *  Return content as JSON
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