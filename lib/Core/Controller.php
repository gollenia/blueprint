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

        $this->add_to_context([
            "footer" => Timber::get_widgets('footer_area'),
            "menu" => Timber::get_menu()
        ]);
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
        foreach($context as $key => $item) {
            $this->context[$key] = $item;
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