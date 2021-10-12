<?php
/**
 * The Page-Controller creates a PHP-Array ($context), which stores all data to render the page or to return JSON.
 * 
 * @since 1.0.0
 */

namespace Contexis\Core;

use Contexis\Core\{
    Utilities
};

use Timber\{
    Timber
};


class Controller {

    protected array $context = [];
    protected string $template = 'pages/page.twig';

    /**
     * Constructor
     * 
     * @todo This function is heavily overloaded!!!
     * 
     * @param \Contexis\Core\Site $site A Site Object
     * @param string $template Twig template to be rendered
     * @since 1.0.0
     */
    public function __construct() {
 
        $this->context = \Timber\Timber::context();

        // Advanced Custom Field Plugin
        if (function_exists('get_fields')) {
            $this->context['fields'] = get_fields('option');
        }

        // until better color management is found
        //$this->context['colors'] = Config::load('colors');

        

        $this->context['colors'] = \Contexis\Core\Color\PageOptions::get_page_colors($this->context['colors']);
        $this->context['grayscale'] = \Contexis\Core\Color\Utils::get_grayscale($this->context['colors'][7]['color']);

        // Die Widgets
        $this->context['footer'] = Timber::get_widgets('footer_area');
        
        // Das Menü
        $this->context['menu'] = Timber::get_menu();

    }

    /**
     *  Add data to context
     * 
     * @since 1.0.0
     * 
     * @param array $context How should this content item be available in twig?
     * 
     * @return bool Returns false, if key already exists. If key already exists and $force is false, the functio returns false, else true.
     * 
     */
    public function add_to_context(array $context) {
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
            Utilities::debug($this->context);
        }
        Utilities::debug($this->context);
        Timber::render( $this->template, $this->context );
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