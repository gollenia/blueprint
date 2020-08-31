<?php
/**
 * Controler to render the categories page. Timber is used to get the posts within the given category
 *  
 * @since 1.0.0
 */

namespace Contexis\Controllers;

use Timber\PostQuery;

class Categories extends \Contexis\Core\Controller{

    public function __construct($site, $template = false) {

        parent::__construct($site);
        $this->addToContext([
            'posts' => new PostQuery(),
            'category' => single_cat_title('', false)
        ]);
        
        $this->setTemplate('pages/categories.twig');
        
    }
    
}