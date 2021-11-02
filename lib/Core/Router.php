<?php

namespace Contexis\Core;
use Contexis\Core\Config;

class Router {

    public $routes;

    /**
	 * Constructor
     * 
     * @todo Make this class self-invoking?
	 * 
     * @param array $routes
	 * @since 1.0.0
	 */
	public function __construct($routes = false) {
        $this->routes = $routes;
    }

    /**
     * 
     * Retrieves the firs route that is true
     *
     * @return string Controller Classname
     */
    public function get() {
        $controller = "";
        foreach ($this->routes as $route => $isTrue) {        
            if ($isTrue) {
                $controller = $route;
            break;
            }
        }
        return $controller;
    }

    /**
     * Adds a new route at a specified position
     *
     * @param string $name Name of a Controller Class
     * @param bool $condition when is this route fulfilled? See Wordpress Conditionals for examples
     * @param integer $priority where should the route be placed?
     * @return void
     */
    public function add($name, $condition, $priority = 1) {
        array_splice( $this->routes, $priority, 0, array($name => $condition) );
    }


}