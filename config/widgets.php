<?php

/** 
 * Add taxonomies here. The can be registered with \Contexis\Wordpress\Widgets:register()
 * For further Info on options and Arguments see:
 * 
 * @link https://developer.wordpress.org/reference/functions/register_widget/
 * 
 * @return array Widgets
*/

return [
    'Footer-Bereich' => [
            "id" => 'footer_area',
            "description" => 'Widget-Bereich ganz unten auf der Seite',
            "before_widget"=> '<div class="col col-12 col-lg-4">',
            "after_widget"=> '</div>',
            "before_title"=> '<h4>',
            "after_title"=> '</h4>'
        ]
    ];