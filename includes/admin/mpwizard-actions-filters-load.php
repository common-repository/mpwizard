<?php

/**
 * Load admin actions.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_admin_load_actions_filters' ) ) {

  function mpwizard_admin_load_actions_filters() {

    if ( current_user_can( 'edit_posts' ) ) {
      //scripts
      add_action('admin_enqueue_scripts', 'mpwizard_admin_enqueue_scripts_styles');
  
      //menu
      add_action( 'admin_menu', 'mpwizard_register_menus' );
      
      add_action('init', 'mpwizard_custom_post_types');
  
      //settings actions
      add_action('admin_init', 'mpwizard_settings_init');

      //settings filters
      add_filter( 'pre_update_option', 'mpwizard_encript_settings_field', 10, 3 );
  
      //ajax handlers
      add_action( 'wp_ajax_mpwizard_add_button', 'mpwizard_add_button_handler' );
      add_action( 'wp_ajax_mpwizard_delete_product', 'mpwizard_delete_product_handler' );
      add_action( 'wp_ajax_mpwizard_get_init_point', 'mpwizard_get_init_point_handler' );
    
    }
    
  }

}

add_action( 'plugins_loaded', 'mpwizard_admin_load_actions_filters' );

/**
 * Load public actions.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_public_load_actions_filters' ) ) {

  function mpwizard_public_load_actions_filters() {
    //scripts
    add_action('wp_enqueue_scripts', 'mpwizard_public_enqueue_scripts_styles');
  
    add_filter( 'option_mpwizard_credentials_test_key', 'mpwizard_decript_settings_field', 10, 3 );

    add_filter( 'option_mpwizard_credentials_test_token', 'mpwizard_decript_settings_field', 10, 3 );

    add_filter( 'option_mpwizard_credentials_key', 'mpwizard_decript_settings_field', 10, 3 );

    add_filter( 'option_mpwizard_credentials_token', 'mpwizard_decript_settings_field', 10, 3 );
    
  }

}

add_action( 'plugins_loaded', 'mpwizard_public_load_actions_filters' );