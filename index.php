<?php


$post_slug = get_post_field( 'post_name' );

// Hier wird geprüft, ob für die aktuelle Seite ein Controller existiert,
// wenn nicht, wird auf den Parent-Controller \Contexis\Controllers\Page zurückgegriffen.


$page = new Contexis\Controllers\Page($site);


$page->render();