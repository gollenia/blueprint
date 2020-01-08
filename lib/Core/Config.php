<?php

namespace Contexis\Core;
use Symfony\Component\Yaml\Yaml;


/**
 * Class loading config files. When  an Instance is loaded, every YAML and JSON file in a
 * given directory is loaded into the object
 * 
 * @since 1.0.0
 */





class Config {
    
    private $config = array();

    public function __construct($config_path) {

        $files = scandir($config_path);
        
        foreach($files as $file) {
            
			if ("yaml" === substr($file, -4)) {
                $setting = substr($file, 0, -5);
                $this->config[$setting] = Yaml::parseFile($config_path . $file);
			}

            if ("json" === substr($file, -4)) {
                $setting = substr($file, 0, -5);
                $json = file_get_contents($config_path . $file);
                $this->config[$setting] = json_decode($string, true);
            }
            
            if ("php" === substr($file, -3)) {
                $setting = substr($file, 0, -4);
                $this->config[$setting] = require_once($config_path . $file);
			}
		}
        
    }

    public function get( $string )
    {
        $keys = explode( '.', strval( $string ) );
        $movingTarget = $this->config;
        
        foreach ( $keys as $key )
        {
            $isArray = is_array( $movingTarget ) || $movingTarget instanceof ArrayAccess;
            if ( ! $isArray || ! isset( $movingTarget[ $key ] ) ) return NULL;
            
            $movingTarget = $movingTarget[ $key ];
        }
        
        return $movingTarget;
    }

    public static function load(string $file) {

        $config_path = get_template_directory() . "/config/";

        
        if (file_exists ( $config_path . $file . ".yaml" )) {
            return Yaml::parseFile($config_path . $file . ".yaml");
        }

        

        if (file_exists ( $config_path . $file . ".json" )) {
            $json = file_get_contents($config_path . $file);
            return json_decode($json, true);
        }

        if (file_exists ( $config_path . $file . ".php" )) {
            return include($config_path . $file . ".php");
        }

        
    }

    // OBSOLETE: Function is now in \Contexis\Core\Utilities::debug
    public function debug() {
        echo "<script>console.log(" . json_encode($this->config) . ");</script>";
    }

    // a set function is (yet) not needed. Maybe later for a Backend-Configuration-Plugin?
    public function set() {}
}