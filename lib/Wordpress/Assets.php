<?php
namespace Contexis\Wordpress;

/**
 * Completely rewritten to load deeply integrated JS without config file
 * 
 * @param array $assets 
 * @since 1.7.0
 */
Class Assets {

    public static function register() {
		$instance = new self;
        add_action( 'admin_enqueue_scripts', [$instance, 'enqueue_admin_scripts'] );
		add_action( 'wp_enqueue_scripts', [$instance, 'enqueue_scripts'] );
    }

	public function enqueue_scripts() {

		if(is_admin()) return;

		$script = require_once(__DIR__ . '/../../assets/dist/app.asset.php');
		
		wp_enqueue_script( 
			'blueprint', 
			get_template_directory_uri() . '/assets/dist/app.js',
			$script['dependencies'],
			$script['version']
		);

		wp_enqueue_script( 
			'alpine', 
			'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js',
			[],
			false
		);
	}

    public function enqueue_admin_scripts() {
		$admin_script = require_once(__DIR__ . '/../../assets/dist/admin.asset.php');
		
		wp_enqueue_script( 
			'blueprint-admin', 
			get_template_directory_uri() . '/assets/dist/admin.js',
			$admin_script['dependencies'],
			$admin_script['version']
		);

		wp_enqueue_style('blueprint-admin-style', get_template_directory_uri() . '/assets/dist/admin.css', [], $admin_script['version']);
		wp_set_script_translations( 'blueprint-admin', 'blueprint', plugin_dir_path( __FILE__ ) . '../../lang' );
    }

}