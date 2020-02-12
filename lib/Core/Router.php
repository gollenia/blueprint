<?php

namespace Contexis\Core;
use Contexis\Core\Config;

class Router {

    private $routes = [];

	public function construct($route) {
        $this->routes = Config::load('routes');
    }

    /**
     * liefert den ersten Controller, der true ergibt
     *
     * @return bool
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
     * Fügt den Routen eine neue hinzu, die an einer bestimmten Stelle eingefügt werden kann.
     *
     * @param string $name der name des Controllers der später aufgerufen wird 
     * @param bool $condition eine Bedingung oder eine Funktion, die eine Bedingung zurückgibt
     * @param integer $position an welcher Stelle soll die Route eingefügt werden?
     * @return void
     */
    public function add($name, $condition, $position = 1) {
        array_splice( $this->routes, $position, 0, array($name => $condition) );
    }


}