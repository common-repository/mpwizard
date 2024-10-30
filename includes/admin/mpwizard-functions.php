<?php

/**
 * Product add and edit actions handler
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_add_button_handler' ) ) {

    function mpwizard_add_button_handler() {
      // Handle request then generate response using echo or leaving PHP and using HTML
    
      check_ajax_referer( 'mpwizard_nonce' );
    
      //first of all check that credentials settings are stablished
      if ( mpwizard_validate_credentials_settings() === false ) {
    
        $wp_error = mpwizard_credentials_settings_error_message();
        wp_send_json( ['post_id' => -1, 'error' => $wp_error->get_error_message()] );
    
      }
    
      //general fields sanitization and validation
      $title  = sanitize_text_field( $_POST['mpwizard-btn-title'] );
      $quantity = sanitize_text_field( $_POST['mpwizard-btn-quantity'] );
      $price  = sanitize_text_field( $_POST['mpwizard-btn-price'] );
      //$button_text  = sanitize_text_field( $_POST['mpwizard-btn-text'] );
      $picture_url  = esc_url_raw( $_POST['mpwizard-btn-picture-url'] );
      //$description  = sanitize_textarea_field( $_POST['mpwizard-btn-desc'] );  
      $external_reference = sanitize_text_field( $_POST['mpwizard-btn-refnumber'] );
      $expiration_date_from = sanitize_text_field( $_POST['mpwizard-btn-activationd'] );
      $expiration_date_to = sanitize_text_field( $_POST['mpwizard-btn-expirationd'] );
    
      if ( strlen($title) <= 0 ) {
    
        $wp_error = mpwizard_validation_error('Título inválido');
        wp_send_json( ["post_id" => -1, 'error' => $wp_error->get_error_message()] );
    
      } else if ( strlen($quantity) <= 0 || ! is_numeric($quantity) ) {
    
        $wp_error = mpwizard_validation_error('Cantidad inválida');
        wp_send_json( ["post_id" => -1, 'error' => $wp_error->get_error_message()] );
    
      } else if ( strlen($price) <= 0 || ! is_numeric($price) ) {
    
        $wp_error = mpwizard_validation_error('Precio inválido');
        wp_send_json( ["post_id" => -1, 'error' => $wp_error->get_error_message()] );
    
      } /*else if ( strlen($button_text) <= 0 ) {
    
        $wp_error = mpwizard_validation_error('Texto del botón inválido');
        wp_send_json( ["post_id" => -1, 'error' => $wp_error->get_error_message()] );
    
      }*/ else if ( $picture_url !== sanitize_text_field( $_POST['mpwizard-btn-picture-url'] ) ) {
    
        $wp_error = mpwizard_validation_error('URL de la imagen inválida');
        wp_send_json( ["post_id" => -1, 'error' => $wp_error->get_error_message()] );
    
      /*} else if ( strlen( sanitize_text_field( $_POST['mpwizard-btn-desc'] ) ) > 0 && strlen($description) <= 0 ) {
    
        $wp_error = mpwizard_validation_error('Descripción inválida');
        wp_send_json( ["post_id" => -1, 'error' => $wp_error->get_error_message()] );*/
    
      } else if ( strlen( sanitize_text_field( $_POST['mpwizard-btn-refnumber'] ) ) > 0 && strlen($external_reference) <= 0 ) {
    
        $wp_error = mpwizard_validation_error('Número de referencia inválido');
        wp_send_json( ["post_id" => -1, 'error' => $wp_error->get_error_message()] );
    
      } else if ( strlen( sanitize_text_field( $_POST['mpwizard-btn-activationd'] ) ) > 0 && \DateTime::createFromFormat('Y-m-d', $expiration_date_from) === false ) {
    
        $wp_error = mpwizard_validation_error('Fecha de inicio inválida');
        wp_send_json( ["post_id" => -1, 'error' => $wp_error->get_error_message()] );
    
      } else if ( strlen( sanitize_text_field( $_POST['mpwizard-btn-expirationd'] ) ) > 0 && \DateTime::createFromFormat('Y-m-d', $expiration_date_to) === false ) {
    
        $wp_error = mpwizard_validation_error('Fecha de vencimiento inválida');
        wp_send_json( ["post_id" => -1, 'error' => $wp_error->get_error_message()] );
    
      }
    
      //others
      $preference_id_production  = sanitize_text_field( $_POST['preference_id_production'] );
      $init_point_production  = sanitize_text_field( $_POST['init_point_production'] );
      $preference_id_test  = sanitize_text_field( $_POST['preference_id_test'] );
      $init_point_test  = sanitize_text_field( $_POST['init_point_test'] );
      $credentials_mode  = sanitize_text_field( $_POST['actual_credentials_mode'] );

      //temp vars
      $temp_preference_id  = '';
      $temp_preference_id_test  = '';
      $temp_init_point  = '';
      $temp_init_point_test  = '';

      //get credentials_mode from wp_options
      $credentials_mode_option = get_option( 'mpwizard_credentials_mode' );
    
      //if post_id param exists means than it is an edit action
      $post_id  = isset( $_POST['post_id'] ) ? sanitize_text_field( $_POST['post_id'] ) : null;

      if ( isset( $post_id ) && ! empty( $post_id ) ) {

        //check if the environment has change
        if( $credentials_mode_option !== $credentials_mode ) {

          if ( $credentials_mode_option === 'production' && empty( $preference_id_production ) ) {

            //create the preference and get it
            $preference = create_preference(
              $title,
              $quantity,
              $price,
              $picture_url,
              $description,  
              $external_reference,
              $expiration_date_from,
              $expiration_date_to
            );

            //update temp vars
            $temp_preference_id  = $preference->id;
            $temp_preference_id_test  =  $preference_id_test;
            $temp_init_point  =  $preference->init_point;
            $temp_init_point_test  = $init_point_test;

          } else if ( $credentials_mode_option === 'production' && ! empty( $preference_id_production ) ) {
            
            //update the preference and get it
            $preference = create_preference(
              $title,
              $quantity,
              $price,
              $picture_url,
              $description,  
              $external_reference,
              $expiration_date_from,
              $expiration_date_to,
              $preference_id_production
            );

            //update temp vars
            $temp_preference_id  = $preference->id;
            $temp_preference_id_test  =  $preference_id_test;
            $temp_init_point  =  $preference->init_point;
            $temp_init_point_test  = $init_point_test;

          } else if ( $credentials_mode_option === 'test' && empty( $preference_id_test ) ) {
       
            //create the preference and get it
            $preference = create_preference(
              $title,
              $quantity,
              $price,
              $picture_url,
              $description,  
              $external_reference,
              $expiration_date_from,
              $expiration_date_to
            );

            //update temp vars
            $temp_preference_id  =  $preference_id_production;
            $temp_preference_id_test  =$preference->id;
            $temp_init_point  =  $init_point_production;
            $temp_init_point_test  =  $preference->init_point;
          
          } else if ( $credentials_mode_option === 'test' && ! empty( $preference_id_test ) ) {
            
            //update the preference and get it
            $preference = create_preference(
              $title,
              $quantity,
              $price,
              $picture_url,
              $description,  
              $external_reference,
              $expiration_date_from,
              $expiration_date_to,
              $preference_id_test
            );

            //update temp vars
            $temp_preference_id  =  $preference_id_production;
            $temp_preference_id_test  =$preference->id;
            $temp_init_point  =  $init_point_production;
            $temp_init_point_test  =  $preference->init_point;

          }        
    
        } else {//no env changes, just update the preference
                //the preference_id must necessarily exist

          //update the preference and get it
          if( $credentials_mode_option === 'production' ) {

            $preference = create_preference(
              $title,
              $quantity,
              $price,
              $picture_url,
              $description,  
              $external_reference,
              $expiration_date_from,
              $expiration_date_to,
              $preference_id_production
            );

          } else {

            $preference = create_preference(
              $title,
              $quantity,
              $price,
              $picture_url,
              null,//$description,  
              $external_reference,
              $expiration_date_from,
              $expiration_date_to,
              $preference_id_test
            );

          }
          
          //update temp vars
          $temp_preference_id  = $credentials_mode_option === 'production' ? $preference->id : $preference_id_production;
          $temp_preference_id_test  = $credentials_mode_option === 'test' ? $preference->id : $preference_id_test;
          $temp_init_point  = $credentials_mode_option === 'production' ? $preference->init_point : $init_point_production;
          $temp_init_point_test  = $credentials_mode_option === 'test' ? $preference->init_point : $init_point_test;

        }
    
      } else {

        //create the preference for first time and get it
        $preference = create_preference(
          $title,
          $quantity,
          $price,
          $picture_url,
          null,//$description,  
          $external_reference,
          $expiration_date_from,
          $expiration_date_to
        );

        //update temp vars
        $temp_preference_id  = $credentials_mode_option === 'production' ? $preference->id : '';
        $temp_preference_id_test  = $credentials_mode_option === 'test' ? $preference->id : '';
        $temp_init_point  = $credentials_mode_option === 'production' ? $preference->init_point : '';
        $temp_init_point_test  = $credentials_mode_option === 'test' ? $preference->init_point : '';
    
      }
    
      if ( ! is_wp_error( $preference, true ) ) {
    
         $content = wp_json_encode( array(
           'name' =>  $title,
           'quantity' =>  $quantity,
           'price'  =>  $price,
           //'button_text'  =>  $button_text,
           'picture_url'  =>  $picture_url,
           'description'  =>  null,//$description,  
           'external_reference' =>  $external_reference,
           'expiration_date_from' =>  $expiration_date_from,
           'expiration_date_to' =>  $expiration_date_to,
           'preference_id'  =>  $temp_preference_id,
           'preference_id_test'  =>  $temp_preference_id_test,
           'init_point'  => $temp_init_point,
           'init_point_test'  =>  $temp_init_point_test,
           'credentials_mode' =>  $credentials_mode_option,
          ), JSON_UNESCAPED_UNICODE  );

         $post_id  = isset( $_POST['post_id'] ) ? sanitize_text_field( $_POST['post_id'] ) : null;
    
         if ( isset( $post_id ) && ! empty( $post_id ) ) {
    
          $my_post = array(
            'ID'   =>  $post_id,
            'post_title'   =>  $title,
            'post_content' =>  $content,
            'post_type'    =>  'mpwizard_button',
            'post_status'  =>  'publish'
            );
            
            // Insert the post into the database
            $post_id = wp_update_post( $my_post );
    
         } else {
    
          $my_post = array(
            'post_title'   =>  $title,
            'post_content' =>  $content,
            'post_type'    =>  'mpwizard_button',
            'post_status'  =>  'publish'
            );
            
            // Insert the post into the database
            $post_id = wp_insert_post( $my_post );
    
         }
    
         wp_send_json( array( 'post_id' =>  $post_id, 'init_point' => $preference->init_point ) );
                       
      } else{
        //TODO LOG si falla preferencia  
    
        wp_send_json( array( 'post_id'  =>  -1, 'error' =>  $preference->get_error_message() ) );
    
      }
    
    }
  
}

/**
 * Product delete action handler
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_delete_product_handler' ) ) {
  
    function mpwizard_delete_product_handler() {
  
      check_ajax_referer( 'mpwizard_nonce' );
    
      if ( isset( $_POST['product'] ) ) {
    
        $id = sanitize_text_field( $_POST['product'] );
    
        $buttonsTable = new MPWizard_Links_Table();
    
        $deleted = $buttonsTable->delete_product($id);
    
        if ( $deleted instanceof WP_Post ) {
          wp_send_json( array( "post_id" =>  $id ) );
        } else {
          $wp_error = esc_html__( 'An error occurred while deleting the product. Please try again.', 'mpwizard' );
          wp_send_json( array( "post_id"  =>  -1, 'error' =>  $wp_error->get_error_message() ) );
        }   
    
      } else {
        $wp_error = esc_html__( 'Product ID is not valid.', 'mpwizard' );
        wp_send_json( array( "post_id"  =>  -1, 'error' =>  $wp_error->get_error_message() ) );
      }
    
    }
  
  }

  /**
 * Get the correct init point.
 * 
 * Used with product list view.
 *
 * @since 1.0.0
 * 
 * @return string
 * 
 */
if ( !function_exists( 'mpwizard_get_init_point_handler' ) ) {
  
  function mpwizard_get_init_point_handler() {

    check_ajax_referer( 'mpwizard_nonce' );

    $id = sanitize_text_field( $_POST['product'] );
  
    if ( isset( $id ) ) {
  
      $post_content = mpwizard_update_post_preferences( $id );

      if ( $post_content !== false) {

        //check actual credentials mode
        $credentials_mode = get_option( 'mpwizard_credentials_mode' );

        if ( $credentials_mode === 'test' ) {
          $init_point = $post_content->init_point_test;
        } else {
          $init_point = $post_content->init_point;
        }
        
        wp_send_json( array( "init_point"  =>  $init_point ) );

      } else {
        $wp_error = esc_html__('There was an error getting the payment link. Please try again.', 'mpwizard');
        wp_send_json( array( "init_point"  =>  -1, 'error' =>  $wp_error->get_error_message() ) );
      }
      
    }

  }

}