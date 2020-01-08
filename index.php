<?php


$post_slug = get_post_field( 'post_name' );

echo $post_slug;
$page = new Contexis\Controllers\Page();
$page->addContent('config', $site->getConfig());
\Contexis\Core\Utilities::debug($page->getContent(""));
$page->render();