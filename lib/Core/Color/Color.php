<?php

namespace Contexis\Core\Color;

class Color {

    public $colors;

    public static function register() {
        PostType::register();
        Options::register();

        

        PageOptions::register();

        
    }    

    public static function get() {
        return array_merge(Options::get(), PostType::get());
        
    }


    
}