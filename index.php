<?php


        
        
        function my_myme_types($mime_types){
            $mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
            return $mime_types;
        }
        add_filter('upload_mimes', 'my_myme_types', 1, 1);
        

        
        // wenn nicht, wird auf den Parent-Controller \Contexis\Controllers\Page zurückgegriffen.
        
        if(is_front_page()) {
            $page = new Contexis\Controllers\Frontpage($site);
        }

        else {
            // Der Controller entscheident, welche Inhalte für die Seite gesammel werden sollen und welches Template geladen werden soll
            $page = new Contexis\Controllers\Page($site);
        }
        
        // zum Schluss wird die Seite an Twig übergeben
        $page->render();
   
        
