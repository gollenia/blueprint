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

class Event extends \Contexis\Core\Controller {

    
    public function __construct($site, $template = false) {
        parent::__construct($site);
        $this->setTemplate('pages/event.twig'); 
        $this->context['booking'] = $this->getBookingForm();
    }

    private function getBookingForm() {
        $post = \Timber\Timber::get_post();
        $content = apply_filters( 'the_content', $post->content );
        return $this->filterForm($content);
    }

    public function filterForm($form) {
        if ($form=="") {return;}
        $html = new \Wa72\HtmlPageDom\HtmlPageCrawler($form);
    
        
        if($html->filter(".input-country")->count()) {
            $html->filter("option[value=0]")->setAttribute("disabled", "")->setAttribute("value", "")->setText("Land auswählen...");
        }

        // Add UiKit Classes
        
        if($html->filter('input')->count()) {
            foreach ($html->filter('input') as $field) {
                $field = \Wa72\HtmlPageDom\HtmlPageCrawler::create($field);
                
                switch ($field->getAttribute('type')) {
                    case "text":
                        $field->addClass("uk-input");
                        break;
                    case "password":
                        $field->addClass("uk-input");
                        break;
                    case "radio":
                        $field->addClass("uk-radio");
                        break;
                    case "checkbox":
                        $field->addClass("uk-checkbox");
                        break;
                    case "submit":
                        $field->addClass("uk-button uk-button-primary");
                        break;
                    default:       
                }

            }
        }

        if($html->filter('textarea')->count()) {
            $html->filter('textarea')->addClass("uk-textarea");
        }

        if($html->filter('select')->count()) {
            $html->filter('select')->addClass("uk-select");
        }

        if($html->filter('table')->count()) {
            $html->filter('table')->wrap("<div>", "</div>");
        }
        if($html->filter('.em-booking-form-details')->count()) {
            $html->filter('.em-booking-form-details')->wrap("<div>", "</div>");
        }

        // Add some infos for form-validation

        if($html->filter('.input-user-field')->count()) {
            $fields = $html->filter('.input-user-field,.input-group');
            foreach ($fields as $field) {
                $field = \Wa72\HtmlPageDom\HtmlPageCrawler::create($field);
                if($field->filter('span.em-form-required')->count() && $field->filter('input,select')->count()) {
                    $field->filter('span.em-form-required')->remove();
                    $field->filter('input')->addClass('required')->setAttribute("required", true);

                }
                if($field->filter('label')->count() && $field->filter('input[type="text"]')->count()) {
                    $placeholder = $field->filter('label')->text();
                    $field->filter('label')->remove();
                    $field->filter('input')->setAttribute('placeholder', $placeholder);
                }

                if($field->filter('label')->count() && $field->filter('select')->count()) {
                    $field->filter('label')->remove();
                    $field->filter('input')->setAttribute('placeholder', $placeholder);
                }
            }
        }

        // input-types festlegen
        $types = [
            "#user_email" => "email",
            "#dbem_phone" => "tel",
            "#dbem_zip" => "number",
        ];

        foreach($types as $id => $type) {
            if($html->filter($id)->count()) {
                $html->filter($id)->setAttribute("type", $type);
            }
        }

        // Zwei-Spalten-Ansicht
        if($html->filter("form")->count()) {
            $html->filter("form")->setAttribute("uk-grid", true);
            $html->filter("form")->setAttribute("novalidate", true);
            $html->filter("form")->addClass("uk-child-width-1-2@m");
        }


        $currency = get_option('dbem_bookings_currency');
        if($currency == "EUR") {
            $currency = "€";
        }

        // Tabelle für Gesamtpreis hinzufügen
        if(($html)->filter(".em-booking-gateway")->count()) {
            $html->filter(".em-booking-gateway")->prepend("<table class='uk-table'><tr><td>Gesamtpreis</td><td class='uk-text-right'><span id='price' class='uk-text-bold'>0,00 " . $currency . "</span></td></tr></table>");
        }

        return $html->saveHTML();
         
    }

}