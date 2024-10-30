<?php

/**
 * Enqueue admin scripts and styles
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_admin_enqueue_scripts_styles' ) ) { 

  function mpwizard_admin_enqueue_scripts_styles() {

    //Set correct environment admin script
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true) {
    	$admin_script = 'admin-script.js';
      $admin_style = 'admin-style.css';
    } else {
      $admin_script = 'admin-script.min.js';
      $admin_style = 'admin-style.min.css';
    }

    //jquery-confirm style
    wp_register_style('jquery_confirm_style', plugins_url( 'assets/css/jquery-confirm.min.css', realpath( __DIR__ . '/..'/*, 2 */) ) );
    wp_enqueue_style('jquery_confirm_style');
  
    //fontawesome style
    wp_register_style('fontawesome_style', plugins_url( 'assets/css/all.min.css', realpath( __DIR__ . '/..'/*, 2 */) ) );
    wp_enqueue_style('fontawesome_style');
  
    //custom styles
    wp_register_style('mpwizard_style', plugins_url( "assets/css/$admin_style", realpath( __DIR__ . '/..'/*, 2 */) ) );
    wp_enqueue_style('mpwizard_style');
  
    wp_enqueue_media();
  
    //jquery-confirm script
    wp_register_script('jquery_confirm_script', plugins_url('assets/js/jquery-confirm.min.js', realpath( __DIR__ . '/..'/*, 2 */) ),  array( 'jquery' ) );
    wp_enqueue_script('jquery_confirm_script');
    
    //custom scripts
    wp_register_script('mpwizard_admin_script', plugins_url("assets/js/$admin_script", realpath( __DIR__ . '/..'/*, 2 */) ),  array( 'jquery'/*, 'wp-i18n'*/ ) );
    wp_enqueue_script('mpwizard_admin_script');
  
    wp_localize_script(
      'mpwizard_admin_script',
      'mpwizard_ajax_obj',
      array(
          'ajax_add_url' => admin_url( 'admin-ajax.php' ),
          'ajax_delete_url' => admin_url( 'admin-ajax.php' ),
          'ajax_init_point_url' => admin_url( 'admin-ajax.php' ),
          'img_placeholder' => MPWIZARD_PLUGIN_URL . 'assets/images/image-placeholder-2.png',
          'log' => mpwizard_validate_log() === true ? 'yes' : 'no',
          'translations' => array(
            'Button' => __( 'Button', 'mpwizard' ),
            'SelectPicture' => __( 'Select picture', 'mpwizard' ),
            'RegisteredProduct' => __( 'Registered product', 'mpwizard' ),
            'UpdatedProduct' => __( 'Updated product', 'mpwizard' ),
            'HereIsYourPaymentLink' => __( 'Here is your payment link', 'mpwizard' ),
            'ClickOnItToCopy' => __( 'Click on it to copy', 'mpwizard' ),
            'AnErrorHasOccurred' => __( 'An error has occurred', 'mpwizard' ),
            'Update' => __( 'Update', 'mpwizard' ),
            'Register' => __( 'Register', 'mpwizard' ),
            'Copied' => __( 'Copied', 'mpwizard' ),
            'AreYouSureYouWantToRemoveThisProduct' => __( 'Are you sure you want to remove this product?', 'mpwizard' ),
            'Cancel' => __( 'Cancel', 'mpwizard' )
          ),
          'nonce'    => wp_create_nonce( 'mpwizard_nonce' )
      )
    );
  
  }

}

/**
 * Enqueue public scripts and styles
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_public_enqueue_scripts_styles' ) ) { 

  function mpwizard_public_enqueue_scripts_styles() {

    //Set correct environment public script
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true) {
      $public_script = 'public-script.js';
      $public_style = 'public-style.css';
    } else {
      $public_script = 'public-script.min.js';
      $public_style = 'public-style.min.css';
    }

    //custom styles
    wp_register_style('mpwizard_public_style', plugins_url( "assets/css/$public_style", realpath( __DIR__ . '/..'/*, 2 */) ) );
    wp_enqueue_style('mpwizard_public_style');
  
    //custom scripts
    wp_register_script( 'mpwizard_public_script', plugins_url("assets/js/$public_script", realpath( __DIR__ . '/..'/*, 2 */) ),  array( 'jquery' ) );
    wp_enqueue_script( 'mpwizard_public_script');
  
    wp_localize_script(
      'mpwizard_public_script',
      'mpwizard_ajax_obj',
      array(
          'ajax_url'       => admin_url( 'admin-ajax.php' ),
          'credentials_public_key'    => mpwizard_get_settings()[ 'public_key' ]
      )
    );
  
  }

}