<?php

namespace Contexis\Controllers;

/**
 * Der Seiten-Controller erstellt einen PHP-Array (Context), in dem alle für den Aufbau der Seite benötigten
 * Informationen gespeichert werden. 
 * 
 * @since 1.0.0
 */

class Search extends \Contexis\Core\Controller{

    private $results = [];
    private $search_term = "";

    public function __construct($site, $template = false) {
        header('Content-Type: application/json');
        $this->search_term = $_GET['ctx_search'];
        $this->getSearchResults();
        
    }

    private function getSearchResults() {
        $results = new \Timber\PostQuery([
            's' => $this->search_term,
            'orderby' => 'type',
        ]);

        foreach ($results as $key => $value) {
            $text = strip_tags(html_entity_decode($value->content));
            $firstFind = strpos ( $text , $this->search_term );
            $text = substr($text, $firstFind -800, 800);
            $text = str_replace($this->search_term, "<b>" . $this->search_term . "</b>", $text);
            $text = str_replace(ucFirst($this->search_term), "<b>" . ucFirst($this->search_term) . "</b>", $text);
            array_push($this->results, [
                "title" => $value->post_title,
                "link" => $value->link,
                "text" => $text,
                "debug" => $value

            ]);
        }
    }

    public function render() {
        
        echo json_encode($this->results);
    }
    
}