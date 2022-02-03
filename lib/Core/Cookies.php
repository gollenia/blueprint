<?php
/**
 * Managing cookies for privacy
 * 
 * @since 1.0.0
 */

namespace Contexis\Core;

class Cookies {

	public static function init() {
        $instance = new self;
		add_action('wp_ajax_nopriv_set_consent',[$instance, 'set_consent']);
		add_action('wp_ajax_set_consent',[$instance, 'set_consent']);
		add_action('admin_init',[$instance, 'add_settings']);
    }

	public function set_consent() {
		setcookie('ctx_consent_ok', "true", time()+31556926, '/', $_SERVER['HTTP_HOST']);
		echo "OK";
		wp_die();
	}

	public function add_settings() {
		add_settings_section(
			'privacy_window_section',
			__('Privacy Consent window','ctx-theme'),
			[$this,'print_section'],
			'privacy'
		);

		register_setting( 
			'privacy', 
			'privacy_window_text'
		);
		
		add_settings_field( "privacy_window_text", __("Privacy window text message"), [$this, "print_settings"], 'privacy', 'privacy_window_section');
	}

	public function print_settings() {
		echo "<textarea rows='10' cols='50' name='privacy_window_text' class='large-text code'>" . get_option( 'privacy_window_text' ) . "</textarea>";
	}

	public function print_section() {
		echo "";
	}

	public static function get_consent() {
		if(get_option( 'wp_page_for_privacy_policy' ) == get_the_ID()) return true;
		if(!get_option( 'privacy_window_text' )) return true;
		return isset($_COOKIE["ctx_consent_ok"]);
	}
}