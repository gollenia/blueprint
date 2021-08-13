<?php
/**
 * Search-Controller to return a JSON-Response with search results
 * 
 * @since 1.0.0
 */

namespace Contexis\Controllers;
    
use Timber\{
    PostQuery
};

class Search extends \Contexis\Core\Controller{

    private $results = [];
    private $search_term = "";

    public function __construct() {
        header('Content-Type: application/json');
        $this->search_term = $_GET['ctx_search'];
        $this->getSearchResults();
        
    }

    private function getSearchResults() {
        $results = new PostQuery([
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