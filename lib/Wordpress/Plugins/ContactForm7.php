<?php

namespace Contexis\Wordpress\Plugins;

/**
 * Add custom Shortcode attribute supporting default values for Contactform7
 * However, this should NOT be here.
 * 
 * @param array $post_types 
 * @since 1.0.0
 * @link https://contactform7.com/getting-default-values-from-shortcode-attributes/
 */
Class ContactForm7 {

    public static function add_custom_attribute($attribute) {

        add_filter( 'shortcode_atts_wpcf7', function($out, $pairs, $atts) use (&$attribute) {
	
            if ( isset( $atts[$attribute] ) ) {
                $out[$attribute] = $atts[$attribute];
            }
            
            return $out;
            
        }, 10, 3 );
    }

    /**
	 * Hack for Contact form 7 to add "required" attribute, will hopefully becom
	 * deprecated in future
	 * 
	 * @since 1.0.0
	 */
	public static function add_required_to_wpcf7() {
		add_filter( 'wpcf7_form_elements', function($content) {
			return str_replace('aria-required="true"', 'required aria-required="true"', $content);
		});
	}

	/**
	 * Remove <span ...>[]</span> from every input field for easier validity-check
	 * 
	 * @since 1.0.0
	 */
	public static function remove_span_wrap() {
		add_filter('wpcf7_form_elements', function($content) {
			$content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
			$content = str_replace('<br />', '', $content);
			return $content;
		});
	}
    
}