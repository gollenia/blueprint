<?php
/**
 * Managing cookies for privacy
 * 
 * @since 1.0.0
 */

namespace Contexis\Core;

class Cookies {

	public static $cookie_ok = 'ctx_cookie_ok';
	public static $cookie_all = 'ctx_cookie_all';

	public static function init() {
        $instance = new self;
		add_action('wp_ajax_nopriv_set_consent',[$instance, 'set_consent']);
		add_action('wp_ajax_set_consent',[$instance, 'set_consent']);
		add_action('admin_init',[$instance, 'add_settings']);
		add_action('admin_menu', [ $instance, 'add_settings_menu' ], 9);    
		add_action('wp_footer', [$instance, 'add_cookie_window']);
		
		if(!self::get_consent_all()) {
			add_filter('render_block',[$instance, 'remove_external_blocks'], 10, 2);
		} 
    }

	public function set_consent() {
		setcookie(self::$cookie_ok, "true", time()+31556926, '/', $_SERVER['HTTP_HOST']);

		if(!isset($_REQUEST['all'])) wp_die();
		
		if($_REQUEST['all'] == 1) {
			setcookie(self::$cookie_all, "true", time()+31556926, '/', $_SERVER['HTTP_HOST']);	
			echo "all";
		}

		if($_REQUEST['all'] == 0) {
			setcookie(self::$cookie_all, "", -1, '/', $_SERVER['HTTP_HOST']);	
			unset($_COOKIE[self::$cookie_all]); 
			echo "notall";
		}

		echo "OK";
		wp_die();
	}

	/**
     * Undocumented function
     *
     * @return void
     */
    public function add_settings_menu(){
        add_options_page( 
			__('DSGVO', 'ctx-theme'),	// Name
			__('DSGVO', 'ctx-theme'), 								// Title
			'manage_options', 							// Access Level
			'ctx-cookies', 					// Menu slug
			[$this, 'display_admin_settings']			// Callback
		);
        
	}

	public function add_settings() {
		add_settings_section(
			'privacy_window_section',
			__('Privacy Consent window','ctx-theme'),
			[$this,'print_section'],
			'ctx-cookies'
		);

		register_setting( 'ctx-cookies', 'privacy_window_text');
		register_setting( 'ctx-cookies', 'privacy_window_button_ok');
		register_setting( 'ctx-cookies', 'privacy_window_button_all');
		register_setting( 'ctx-cookies', 'privacy_window_caption');
		register_setting( 'ctx-cookies', 'privacy_forbidden_blocks');
		register_setting( 'ctx-cookies', 'privacy_cookies_neccessary');
		register_setting( 'ctx-cookies', 'privacy_cookies_all');
		register_setting( 'ctx-cookies', 'privacy_cookies_explanation');
		
		add_settings_field( "privacy_window_text", __("Privacy window text message", "ctx-theme"), [$this, "print_settings"], 'ctx-cookies', 'privacy_window_section', ['field' => 'privacy_window_text']);
		add_settings_field( "privacy_cookies_neccessary", __("Label for neccessary cookies", "ctx-theme"), [$this, "print_settings"], 'ctx-cookies', 'privacy_window_section', ['field' => 'privacy_cookies_neccessary']);
		add_settings_field( "privacy_cookies_all", __("Label for third party cookies", "ctx-theme"), [$this, "print_settings"], 'ctx-cookies', 'privacy_window_section', ['field' => 'privacy_cookies_all']);
		add_settings_field( "privacy_cookies_explanation", __("Explanation for third party cookies", "ctx-theme"), [$this, "print_settings"], 'ctx-cookies', 'privacy_window_section', ['field' => 'privacy_cookies_explanation']);
		add_settings_field( "privacy_window_button_ok", __("Title of Button 'Save'", "ctx-theme"), [$this, "print_settings"], 'ctx-cookies', 'privacy_window_section', ['field' => 'privacy_window_button_ok']);
		add_settings_field( "privacy_window_button_all", __("Title of Button 'Accept all'", "ctx-theme"), [$this, "print_settings"], 'ctx-cookies', 'privacy_window_section', ['field' => 'privacy_window_button_all']);
		add_settings_field( "privacy_window_caption", __("Privacy window Caption", "ctx-theme"), [$this, "print_settings"], 'ctx-cookies', 'privacy_window_section', ['field' => 'privacy_window_caption']);
		add_settings_field( "privacy_forbidden_blocks", __("Critical blocks", "ctx-theme"), [$this, "print_settings"], 'ctx-cookies', 'privacy_window_section', ['field' => 'privacy_forbidden_blocks']);
		
	}

	/**
     * Show Admin color settings page
     *
     * @return void
     */
	public function display_admin_settings() {
		?>
		<div class="wrap">
		        <div id="icon-themes" class="icon32"></div>  
		        <h2><?php echo __("", 'ctx-products') ?></h2>  
				<?php settings_errors(); ?>  
		        <form method="POST" action="options.php">  
		            <?php 
		                settings_fields( 'ctx-cookies' );
		                do_settings_sections( 'ctx-cookies' ); 
                        submit_button();
		            ?>             
		        </form> 
		</div>
		<?php
	}

	public function print_settings($settings) {
		
		switch ($settings['field']) {
			case 'privacy_window_text':
				echo "<fieldset>";
				echo "<p><label for='privacy_window_text'>" . __("You can use HTML Markup here for links, bold and italic type, line breaks and paragraphs. Leave this field empty to disable the privacy window and cookie consent entirely.", "ctx-theme") . "</label></p>";
				echo "<p><textarea rows='10' cols='50' name='privacy_window_text' id='privacy_window_text' class='large-text code'>" . get_option( 'privacy_window_text' ) . "</textarea></p>";
				echo "</fieldset>";
				break;
			case 'privacy_window_button_ok':
				echo "<input type='text' placeholder='" . __("Save settings", "ctx-theme") . "' class='regular-text' name='privacy_window_button_ok' value='" . get_option( 'privacy_window_button_ok' ) . "' />";
				break;
			case 'privacy_cookies_neccessary':
				echo "<input type='text' placeholder='" . __("Only neccessary cookies", "ctx-theme") . "' class='regular-text' name='privacy_cookies_neccessary' value='" . get_option( 'privacy_cookies_neccessary' ) . "' />";
				break;
			case 'privacy_cookies_all':
				echo "<input type='text' placeholder='" . __("Third party cookies", "ctx-theme") . "' class='regular-text' name='privacy_cookies_all' value='" . get_option( 'privacy_cookies_all' ) . "' />";
				break;
			case 'privacy_cookies_explanation':
				echo "<fieldset>";
				echo "<p><label for='privacy_cookies_explanation'>" . __("Give your visitors a short explanation of what kind of third-party-cookies they're about to accept and why you are using them", "ctx-theme") . "</label></p>";
				echo "<p><textarea rows='10' cols='50' id='privacy_cookies_explanation' name='privacy_cookies_explanation' class='large-text code' >" . get_option( 'privacy_cookies_explanation' ) . "</textarea></p>";
				echo "</fieldset>";
				break;
			case 'privacy_window_button_all':
				echo "<input type='text' placeholder='" . __("Accept all", "ctx-theme") . "' class='regular-text' name='privacy_window_button_all' value='" . get_option( 'privacy_window_button_all' ) . "' />";
				break;
			case 'privacy_window_caption':
				echo "<input type='text' class='regular-text' name='privacy_window_caption' value='" . get_option( 'privacy_window_caption' ) . "' />";
				break;
			case 'privacy_forbidden_blocks':
				echo "<fieldset>";
				echo "<p><label for='privacy_forbidden_blocks'>" . __("Blocks to exclude when the user accepts only neccessary cookies. Use parts of block names or full block names. One entry per line. All embed blocks (like YouTube or Spotify) are removed automatically.", "ctx-theme") . "</label></p>";
				echo "<p><textarea rows='10' cols='50' id='privacy_forbidden_blocks' name='privacy_forbidden_blocks' class='large-text code'>" . get_option( 'privacy_forbidden_blocks' ) . "</textarea></p>";
				echo "</fieldset>";
				break;

			default:
				# code...
				break;
		}
		
	}

	public function print_section() {
		echo "<p>" . __("Here you can adjust settings concerning the European data privacy protection, also known as DSGVO or GDPR", "ctx-theme") . "</p>";
	}

	/**
	 * Check if user acceptend neccessary cookies
	 *
	 * @return bool
	 */
	public static function get_consent() {
		if(get_option( 'wp_page_for_privacy_policy' ) == get_the_ID()) return true;
		if(!get_option( 'privacy_window_text' )) return true;
		return isset($_COOKIE[self::$cookie_ok]);
	}

	/**
	 * Check if usre accepted all cookies
	 *
	 * @return bool
	 */
	public static function get_consent_all() {
		if(!get_option( 'privacy_window_text' )) return true;
		if(!isset($_COOKIE[self::$cookie_all])) return false;
		if($_COOKIE[self::$cookie_all]) return true;
		return false;
	}

	/**
	 * Callback function for render_block to remove non-DSGVO-conform blocks
	 *
	 * @param string $block_content
	 * @param array $block
	 * @return string
	 */
	public function remove_external_blocks($block_content, $block ) {

		if( str_contains($block['blockName'], 'embed')) {
			$block_content = '';
		}

		$blocks_to_remove = get_option('privacy_forbidden_blocks');

		$blocks = explode( "\n", $blocks_to_remove );

		foreach ($blocks as $blockname) {
			if($blockname == '') break;
			if( str_contains($block['blockName'], $blockname)) {
				$block_content = '';
			}
		}
		
		return $block_content;
	}

	public function add_cookie_window() {
		$args = [
			'privacy_consent' => $this->get_consent(),
			'privacy_consent_all' => $this->get_consent_all(),
			'options' => [
				'privacy_window_text' => get_option('privacy_window_text'),
				'privacy_window_button_ok' => get_option('privacy_window_button_ok'),
				'privacy_cookies_neccessary' => get_option('privacy_cookies_neccessary'),
				'privacy_cookies_all' => get_option('privacy_cookies_all'),
				'privacy_cookies_explanation' => get_option('privacy_cookies_explanation'),
				'privacy_window_button_all' => get_option('privacy_window_button_all'),
				'privacy_window_caption' => get_option('privacy_window_caption'),
			]
		];

		\Timber\Timber::render( 'partials/cookies.twig', $args );
	}
}