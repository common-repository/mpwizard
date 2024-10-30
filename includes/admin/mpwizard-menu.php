<?php

/**
 * Products list html
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_buttons_list_page_html' ) ) { 

  function mpwizard_buttons_list_page_html() {

    // check user capabilities
    if ( ! current_user_can( 'edit_posts' ) ) {
      return;
    }
  
    mpwizard_credentials_settings_error();
  
    require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-product-list-view.php';
  }

}

/**
 * Suscription plans list html
 *
 * @since 1.1.0
 * 
 */
if ( !function_exists( 'mpwizard_suscr_plan_list_page_html' ) ) { 

  function mpwizard_suscr_plan_list_page_html() {

    // check user capabilities
    if ( ! current_user_can( 'edit_posts' ) ) {
      return;
    }
  
    mpwizard_credentials_settings_error();
  
    require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-suscr-plan-list-view.php';
  }

}

/**
 * Product form html
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_buttons_add_page_html' ) ) { 

  function mpwizard_buttons_add_page_html() {

    // check user capabilities
    if ( ! current_user_can( 'edit_posts' ) ) {
      return;
    }
  
    mpwizard_credentials_settings_error();

    $id = isset( $_GET[ 'id' ] ) ? sanitize_text_field( $_GET[ 'id' ] ) : null;
  
    if ( isset( $id ) ) {
  
      $loop = mpwizard_get_posts( $id );
  
      while ( $loop->have_posts() ) {
  
        $loop->the_post();
    
        if ( get_post_type() === 'mpwizard_button' ) {
  
          $mpwizard_product = \json_decode( get_the_content() );
          
        }
        
      }
  
      $mpwizard_page_title = __( 'Edit product', 'mpwizard');
  
    } else {
  
      $mpwizard_page_title = get_admin_page_title();
  
    }
  
    require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-product-form-view.php';
  
  }

}


/**
 * Suscription plan form html
 *
 * @since 1.1.0
 * 
 */
if ( !function_exists( 'mpwizard_suscription_plan_add_page_html' ) ) { 

  function mpwizard_suscription_plan_add_page_html() {

    // check user capabilities
    if ( ! current_user_can( 'edit_posts' ) ) {
      return;
    }
  
    mpwizard_credentials_settings_error();

    $id = isset( $_GET[ 'id' ] ) ? sanitize_text_field( $_GET[ 'id' ] ) : null;
  
    if ( isset( $id ) ) {
  
      $loop = mpwizard_get_posts( $id );
  
      while ( $loop->have_posts() ) {
  
        $loop->the_post();
    
        if ( get_post_type() === 'mpwizard_button' ) {
  
          $mpwizard_product = \json_decode( get_the_content() );
          
        }
        
      }
  
      $mpwizard_page_title = __( 'Edit product', 'mpwizard');
  
    } else {
  
      $mpwizard_page_title = get_admin_page_title();
  
    }
  
    require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-suscription-plan-form-view.php';
  
  }

}

/**
 * Settings html
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_settings_page_html' ) ) {
  
  function mpwizard_settings_page_html() {

    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
      return;
    }
  
    require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-settings-view.php';
  
  }

}

/**
 * Register menu
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_register_menus' ) ) { 

  function mpwizard_register_menus() {

    add_menu_page(
        'MPWizard',
        'MPWizard',
        'edit_posts',
        'mpwizard-overview',
        'mpwizard_buttons_list_page_html',
        'dashicons-products',
        20
    );

    //---------------Submenu------------------------

    add_submenu_page(
			'mpwizard-overview',
			esc_html__( 'Payment links', 'mpwizard' ),
			esc_html__( 'Payment links', 'mpwizard' ),
			'edit_posts',
			'mpwizard-overview',
			'mpwizard_buttons_list_page_html'
		);

    add_submenu_page(
      'mpwizard-overview',
      esc_html__('Add new', 'mpwizard'),
      esc_html__('Add new', 'mpwizard'),
      'edit_posts',
      'mpwizard-add-button',
      'mpwizard_buttons_add_page_html'
    );

    /*add_submenu_page(
			'mpwizard-overview',
			esc_html__('Suscription Plans', 'mpwizard'),
      esc_html__('Suscription Plans', 'mpwizard'),
			'manage_options',
			'mpwizard-suspl-list',
			'mpwizard_suscr_plan_list_page_html'
		);

    add_submenu_page(
      null,
      esc_html__('Add New Suscription Plan', 'mpwizard'),
      esc_html__('Add New', 'mpwizard'),
      'manage_options',
      'mpwizard-add-suscription-plan',
      'mpwizard_suscription_plan_add_page_html'
    );*/

    add_submenu_page(
      'mpwizard-overview',
      esc_html__('Settings', 'mpwizard'),
      esc_html__('Settings', 'mpwizard'),
      'manage_options',
      'mpwizard-settings',
      'mpwizard_settings_page_html'
    );

  }

}