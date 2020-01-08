<?php


require_once( __DIR__ . '/vendor/autoload.php' );


$timber = new Timber\Timber();
$options = new Contexis\Core\Options;

$site = new Contexis\Core\Site;
//$wp_customize = new WP_Customize_Manager();
///var_dump($wp_customize);

function mytheme_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 'image_logo' , array(
        'default'   => '',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_section( 'ctx_branding' , array(
        'title'      => __( 'Branding', 'ctx-theme' ),
        'priority'   => 30,
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'link_color', array(
        'label'      => "Header-Logo",
        'section'    => 'ctx_branding',
        'settings'   => 'image_logo',
    ) ) );
    
 }
 add_action( 'customize_register', 'mytheme_customize_register' );

//var_dump($wp_customize->get_setting('image_logo'));

function my_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);



$all_settings = get_theme_mods();
