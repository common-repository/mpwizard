<?php

/**
 * Register product post type.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_custom_post_types' ) ) {

    function mpwizard_custom_post_types() {
  
      register_post_type('mpwizard_button',
          array(
              'labels'      => array(
                  'name'          => __( 'MPWizard Buttons', 'mpwizard' ),
                  'singular_name' => __( 'MPWizard Button', 'mpwizard' )
              ),
              'public'      => true,
              'has_archive' => true,
              'show_ui' => false,
              //'rewrite'     => array( 'slug' => 'products' ),
              'supports' => array( 'title', 'editor', 'custom-fields' )
          )
      );

      /*register_post_type('mpwizard_susc_plan',
          array(
              'labels'      => array(
                  'name'          => __( 'MPWizard Suscription Plans', 'mpwizard' ),
                  'singular_name' => __( 'MPWizard Suscription Plan', 'mpwizard' )
              ),
              'public'      => false,
              'has_archive' => true,
              'show_ui' => false,
              //'rewrite'     => array( 'slug' => 'products' ),
              'supports' => array( 'title', 'editor', 'custom-fields' )
          )
      );*/
    
      // Clear the permalinks after the post type has been registered.
      flush_rewrite_rules(); 
    }
  
  }