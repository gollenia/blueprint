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
		add_action('admin_enqueue_scripts', [$instance, 'enqueue_admin_scripts']);
	}

	public function enqueue_scripts()
	{

		if (is_admin()) return;
		$script = require_once(__DIR__ . '/../../build/app.asset.php');

		wp_enqueue_script(
			'blueprint',
			get_template_directory_uri() . '/build/app.js',
			$script['dependencies'],
			$script['version'],
			true
		);
	}

	public function enqueue_admin_scripts()
	{
		if (!is_admin()) return;
		$script = require_once(__DIR__ . '/../../build/admin.asset.php');

		wp_enqueue_script(
			'blueprint-admin',
			get_template_directory_uri() . '/build/admin.js',
			$script['dependencies'],
			$script['version'],
			true
		);
	}


}
