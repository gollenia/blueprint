<?php
/**
 * Post-Controller to render standard Posts
 * 
 * @since 1.0.0
 */

namespace Contexis\Controllers;

use Contexis\Wordpress\Breadcrumbs;
use Timber\PostQuery;



class Post extends \Contexis\Core\Controller {

    
    public function __construct(\Contexis\Core\Site $site, $template = false) {
        parent::__construct($site);

        $this->addToContext([
            "author" => $this->getAuthor(),
            "latest_posts" => $this->getLatestPosts(5),
            "breadcrumbs" => Breadcrumbs::generate(),
        ]);
        
        $this->setTemplate('pages/post.twig');
    }

    private function getLatestPosts(int $limit = 5) {
        return new PostQuery([
            'post_type' => 'post',
            'post__not_in' => [$this->context['post']->id],
            'limit' => 5,
            'orderby' => 'date',
            'order' => 'DESC'
        ]);
    }

    private function getAuthor()
    {
        return get_the_author_meta( 'display_name', $this->context['post']->post_author );
    }


}