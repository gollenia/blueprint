<?php
/**
 * Post-Controller to render standard Posts
 * 
 * @since 1.0.0
 */

namespace Contexis\Controllers;

use Timber\Timber;



class Post extends \Contexis\Core\Controller {

    public string $template = 'pages/post.twig';
    
    public function __construct($template = false) {
        parent::__construct();

        $this->add_to_context([
            "author" => $this->getAuthor(),
            "latest_posts" => $this->getLatestPosts(5),
        ]);
        
    }

    private function getLatestPosts(int $limit = 5) {
        $args = [
            'post_type' => 'post',
            'post__not_in' => [$this->context['post']->id],
            'limit' => 5,
            'orderby' => 'date',
            'order' => 'DESC'
        ];
        return Timber::get_posts( $args );
    }

    private function getAuthor()
    {
        return get_the_author_meta( 'display_name', $this->context['post']->post_author );
    }


}