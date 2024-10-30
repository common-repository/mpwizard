<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

/**********************************************************
 Remove custom post types
***********************************************************/

/**
 * Delete custom post types.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_delete_custom_post_types' ) ) {

    function mpwizard_delete_custom_post_types() {

        unregister_post_type( 'mpwizard_button' );
        unregister_post_type( 'mpwizard_susc_plan' );

        // Clear the permalinks after the post type has been registered.
        flush_rewrite_rules(); 
    }
}

add_action( 'init','mpwizard_delete_custom_post_types' );

/**********************************************************
 Remove custom post types from database
***********************************************************/

global $wpdb;

$post_type  =   'mpwizard_button';
$postmeta   =   $wpdb->prefix.'postmeta';
$posts   =   $wpdb->prefix.'posts';

$wpdb->query( "DELETE FROM $postmeta where post_id IN (SELECT ID from $posts  where post_type = '$post_type' );" );
//$wpdb->query( "DELETE FROM wp_comments where comment_post_ID IN (SELECT ID from wp_posts where post_type = '$post_type' );" );
$wpdb->query( "DELETE from $posts where post_type = '$post_type';" );

/**********************************************************
 Remove shortcodes
***********************************************************/

remove_shortcode( 'mpwizard_button' );

/**********************************************************
 Remove menu
***********************************************************/

/**
 * Remove menu.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_remove_menu' ) ) {

    function mpwizard_remove_menu() {

        remove_menu_page( 'mpwizard-overview' );

    }
}

add_action( 'admin_menu', 'mpwizard_remove_menu', 99 );

/**********************************************************
 Remove options
***********************************************************/

delete_option( 'mpwizard_credentials_mode' );
delete_option( 'mpwizard_keys' );
delete_option( 'mpwizard_credentials_test_key' );
delete_option( 'mpwizard_credentials_test_token' );
delete_option( 'mpwizard_credentials_key' );
delete_option( 'mpwizard_credentials_token' );
delete_option( 'mpwizard_payment_preferences_currency' );
delete_option( 'mpwizard_payment_preferences_installments' );
delete_option( 'mpwizard_payment_preferences_binarymode' );
delete_option( 'mpwizard_payment_preferences_successdir' );
delete_option( 'mpwizard_payment_preferences_pendingdir' );
delete_option( 'mpwizard_payment_preferences_failuredir' );
if( get_option( 'mpwizard_payment_preferences_experience' ) ) {
    delete_option( 'mpwizard_payment_preferences_experience' );
}
delete_option( 'mpwizard_business_marketplace' );
delete_option( 'mpwizard_business_statementdesc' );