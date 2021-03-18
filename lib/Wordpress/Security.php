<?php

namespace Contexis\Wordpress;

/**
 * Add basic security features to Site
 * 
 * @since 1.2.0
 */
Class Security {

    /**
     * Disable XML-RPC and remove headers. Do not forget to block xml-rpc in .htaccess
     *
     * @return void
     */
    public static function disable_xmlrpc() {
        add_filter( 'xmlrpc_enabled', '__return_false' );

		// Hide xmlrpc.php in HTTP response headers
		add_filter( 'wp_headers', function( $headers ) {
			unset( $headers[ 'X-Pingback' ] );
			return $headers;
		} ); 
    }

    public static function disable_feed() {
        add_action( 'init', function() {

            $feeds = array (
                'do_feed',
                'do_feed_rdf',
                'do_feed_rss',
                'do_feed_rss2',
                'do_feed_atom',
            );
        
            foreach ( $feeds as $feed ) {
                remove_action( $feed, $feed );
            } 
        } );
        
        add_action( 'template_redirect', function() {

            if ( in_array( true,
                array (
                    is_feed(),
                    is_trackback(),
                    is_embed(),
                ) ) ) {
                wp_die( __( "NO SOUP FOR YOU!" ) );
            }
        } );
    }

    public static function clean_header() {
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');
    }

    public static function limit_login_attempts($attempts = 5) {
        add_filter( 'authenticate', 'check_attempted_login', 30, 3 ); 
        add_action( 'wp_login_failed', [__CLASS__,'login_failed'], 10, 1 ); 
    }

    public static function login_failed( $username ) {
        if ( get_transient( $username . '_attempted_login' ) ) {
            $datas = get_transient( $username . '_attempted_login' );
            $datas['tried']++;
    
            if ( $datas['tried'] <= 5 )
                set_transient( $username . '_attempted_login', $datas , HOUR_IN_SECONDS );
        } else {
            $datas = ['tried' => 1];
            set_transient( $username . '_attempted_login', $datas , HOUR_IN_SECONDS );
        }
    }


    public static function check_attempted_login( $user, $username, $password ) {
        if ( get_transient( $username . '_attempted_login' ) ) {
            $datas = get_transient( $username . '_attempted_login' );

            return new WP_Error( 'too_many_tried',  sprintf( __( '<strong>ERROR</strong>: You have reached authentication limit. I won\'t tell you whenn you can try it again' ) ) );
        }
        return $user;
    }
    
}