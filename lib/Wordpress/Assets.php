<?php

namespace Contexis\Wordpress;

/**
 * Completely rewritten to load deeply integrated JS without config file
 * 
 * @param array $assets 
 * @since 1.7.0
 */
class Assets
{

	public static function register()
	{
		$instance = new self;
		
		add_action('wp_enqueue_scripts', [$instance, 'enqueue_scripts']);
	}

	public function enqueue_scripts()
	{

		if (is_admin()) return;

		$script = require_once(__DIR__ . '/../../assets/dist/app.asset.php');

		wp_enqueue_script(
			'blueprint',
			get_template_directory_uri() . '/assets/dist/app.js',
			$script['dependencies'],
			$script['version'],
			true
		);
	}


}
