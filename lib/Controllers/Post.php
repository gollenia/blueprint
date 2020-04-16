<?php
namespace Contexis\Controllers;

use \Timber\URLHelper;
use \Timber\Helper;
use \Timber\User;

/**
 * Der Seiten-Controller erstellt einen PHP-Array (Context), in dem alle für den Aufbau der Seite benötigten
 * Informationen gespeichert werden. 
 * 
 * @since 1.0.0
 */

class Post extends Page {

    
    public function __construct(\Contexis\Core\Site $site, $template = false) {
        parent::__construct($site);
        $this->context['author'] = get_the_author_meta( 'display_name', $this->context['post']->post_author );
        $this->context['latest_posts'] = $this->getLatestPosts(5);
    }

    private function getLatestPosts(int $limit = 5) {
        return new \Timber\PostQuery([
            'post_type' => 'post',
            'post__not_in' => [$this->context['post']->id],
            'limit' => 5,
            'orderby' => 'date',
            'order' => 'DESC'
        ]);
    }

    protected function setTemplate() {
        return array( 'pages/post.twig' );
    }

}