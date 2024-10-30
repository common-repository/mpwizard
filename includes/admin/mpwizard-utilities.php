<?php 

/**
 * Retrieve product posts.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_get_posts' ) ) {

  function mpwizard_get_posts($post_id = null){
    if (isset($post_id)) {
      
      $args = array(
        'p' => $post_id,
        'post_type' => 'mpwizard_button',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'author' => get_current_user_id()
      );
  
    } else {
  
      $args = array(
        'post_type' => 'mpwizard_button',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'author' => get_current_user_id()
      );
  
    }
  
    return new WP_Query($args);
  
  }

}

/**
 * Clean unit values from leftover characters.
 * 
 * Used when CSS property values are empty.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_clean_value_unit' ) ) {

  function mpwizard_clean_value_unit( $value ) {

    return str_replace( array( 'px', 'em', '%', 'vw' ), '', $value );
  
  }

}

/**
 * Get scaped attribute.
 * 
 * Used when CSS property values are empty.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_product_attr' ) ) {

  function mpwizard_product_attr( $value ) {

    return  esc_attr( mpwizard_clean_value_unit( $value ) );
  
  }

}

/**
 * Get selected value for select and radio inputs.
 * 
 * Used when CSS property values are empty.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_selected_val' ) ) {

  function mpwizard_selected_val( $expected_value, $actual_value ) {

    return $expected_value === $actual_value ? ' selected="selected" ' : '';
  
  }

}

/**
 * Get a WP_Error from custom message.
 *
 * @since 1.0.0
 * 
 * @param  string $error Error message
 * @param  bool   $localize Localize the message
 * 
 * @return WP_Error
 * 
 */
if ( !function_exists( 'mpwizard_validation_error' ) ) {
  
  function mpwizard_validation_error($error, $localize = true) {

    //TODO write to log
    if ( $localize ) {
  
      return new WP_Error( 'mpwizard_error', esc_html__( $error, 'mpwizard' ) );
  
    } else {
  
      return new WP_Error( 'mpwizard_error', esc_html( $error, 'mpwizard' ) );
  
    } 
  
  }

}

/**
 * Generate encryption keys.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_generate_encryption_keys' ) ) {

  function mpwizard_generate_encryption_keys() {

    $first_key  = '';
    $second_key = '';
  
    //if option not exits will create it
    //otherwise retrieve from database
    $option = get_option( 'mpwizard_keys' );
  
    if( $option === false ) { 
  
      //generate keys for first time
      $mpwizard_keys = array(
        'mpwizard_firstkey' => base64_encode(openssl_random_pseudo_bytes(32)),
        'mpwizard_secondkey' => base64_encode(openssl_random_pseudo_bytes(64))
      );
  
      //if option creation fail report error
      if ( update_option( 'mpwizard_keys', $mpwizard_keys ) === false ) {
        //TODO registrar error
      } 
  
      $first_key  = $mpwizard_keys[ 'mpwizard_firstkey' ];
      $second_key = $mpwizard_keys[ 'mpwizard_secondkey' ];
  
    } else {
  
      $first_key  = $option[ 'mpwizard_firstkey' ];
      $second_key = $option[ 'mpwizard_secondkey' ];
  
    }
    //TODO Definir donde estarán las constantes
    //finally define constants
    if ( ! defined( 'MPWIZARD_FIRSTKEY' ) ) {
      define( 'MPWIZARD_FIRSTKEY', $first_key );
    }
    
    if ( ! defined( 'MPWIZARD_SECONDKEY' ) ) {
      define( 'MPWIZARD_SECONDKEY', $second_key );
    }
    
  }

}

/**
 * Encrypt data.
 *
 * @since 1.0.0
 * 
 * @param string $data Data to encrypt
 * 
 */
if ( !function_exists( 'mpwizard_secure_encrypt' ) ) {

  function mpwizard_secure_encrypt( $data ) {

    //generate encryption constants if not exists
    mpwizard_generate_encryption_keys();
  
    $first_key  = base64_decode( MPWIZARD_FIRSTKEY );
    $second_key = base64_decode( MPWIZARD_SECONDKEY );   
  
    $method = "aes-256-cbc";   
    $iv_length  = openssl_cipher_iv_length( $method );
    $iv = openssl_random_pseudo_bytes( $iv_length );
  
    $first_encrypted  = openssl_encrypt( $data, $method, $first_key, OPENSSL_RAW_DATA , $iv );   
    $second_encrypted = hash_hmac( 'sha512', $first_encrypted, $second_key, TRUE );
  
    $output = base64_encode( $iv.$second_encrypted.$first_encrypted );   
  
    return $output;     
  
  }

}

/**
 * Validate log 
 * 
 * @since 1.0.0
 * 
 * @return bool
 * 
 */
if ( !function_exists( 'mpwizard_validate_log' ) ) {

  function mpwizard_validate_log() {
  
    if ( ! get_option( 'mpwizard_log' ) ) {
      return true;
    } else if ( get_option( 'mpwizard_log' ) === 'yes' ){
      return true;
    } else{
      return false;
    }  

  }

}

/**
 * Decrypt data.
 *
 * @since 1.0.0
 * 
 * @param string $data Data to decrypt
 * 
 */
if ( !function_exists( 'mpwizard_secure_decrypt' ) ) {

  function mpwizard_secure_decrypt( $input ) {

    //generate encryption constants if not exists
    mpwizard_generate_encryption_keys();
  
    $first_key  = base64_decode( MPWIZARD_FIRSTKEY );
    $second_key = base64_decode( MPWIZARD_SECONDKEY );           
    $mix  = base64_decode( $input );
  
    $method = "aes-256-cbc";   
    $iv_length  = openssl_cipher_iv_length( $method );
  
    $iv = substr( $mix, 0, $iv_length );
    $second_encrypted = substr( $mix, $iv_length, 64 ) === false ? '' : substr( $mix, $iv_length, 64 );
    $first_encrypted  = substr( $mix, $iv_length + 64 ) === false ? '' : substr( $mix, $iv_length + 64 );
  
    $data = openssl_decrypt( $first_encrypted, $method, $first_key, OPENSSL_RAW_DATA, $iv );
    $second_encrypted_new = hash_hmac( 'sha512', $first_encrypted, $second_key, TRUE );
   
    if ( hash_equals( $second_encrypted, $second_encrypted_new ) ) {
  
      return $data;
  
    }
    
    return false;
  }

}

/**
 * Validate an option.
 *
 * @since 1.0.0
 * 
 * @param string $option Option to validate
 * 
 */
if ( !function_exists( 'mpwizard_validate_option' ) ) {

  function mpwizard_validate_option( $option ) {

    if ( get_option( $option ) && ! empty( get_option( $option ) ) ) {
      return true;
    } else {
      return false;
    } 
  
  }

}

/**
 * Get plugin settings.
 *
 * @since 1.0.0
 * 
 * 
 */
if ( !function_exists( 'mpwizard_get_settings' ) ) {

  function mpwizard_get_settings() {

    $credentials_mode = get_option( 'mpwizard_credentials_mode' );
  
    $currency = get_option( 'mpwizard_payment_preferences_currency' );
    $installments = get_option( 'mpwizard_payment_preferences_installments' );
    $binarymode = get_option( 'mpwizard_payment_preferences_binarymode' );
    $successdir = get_option( 'mpwizard_payment_preferences_successdir' );
    $pendingdir = get_option( 'mpwizard_payment_preferences_pendingdir' );
    $failuredir = get_option( 'mpwizard_payment_preferences_failuredir' );
  
    $marketplace = get_option( 'mpwizard_business_marketplace' );
    $statementdesc = get_option( 'mpwizard_business_statementdesc' );

    $public_key = '';
    $access_token = '';
  
    if ( $credentials_mode === 'test') {
  
      //public key is automatically decripted by filter in frontend
    $public_key   = get_option( 'mpwizard_credentials_test_key' );
      //access token nedd to be decripted in backend
    $access_token =  get_option( 'mpwizard_credentials_test_token' );
  
    } else if ( $credentials_mode === 'production') {
  
      //public key is automatically decripted by filter in frontend
      $public_key   = get_option( 'mpwizard_credentials_key' );
      //access token nedd to be decripted in backend
      $access_token = get_option( 'mpwizard_credentials_token' );     
  
    } 
  
    return array(
      'public_key'        =>  $public_key,
      'access_token'      =>  $access_token,
      'credentials_mode'  =>  $credentials_mode,
      'currency'          =>  $currency,
      'installments'      =>  $installments, 
      'binarymode'        =>  $binarymode,
      'marketplace'       =>  $marketplace, 
      'statementdesc'     =>  $statementdesc, 
      'successdir'        =>  $successdir,
      'pendingdir'        =>  $pendingdir,   
      'failuredir'        =>  $failuredir,   
    );
    
  }

}

/**
 * Validate credentials settings.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_validate_credentials_settings' ) ) {

  function mpwizard_validate_credentials_settings() {
 
    //validate options exits and are not empty 
    if ( mpwizard_validate_option( 'mpwizard_keys' ) === false ||
         mpwizard_validate_option( 'mpwizard_credentials_mode' ) === false ) {
  
          return false;
      
    } 
  
    //get options values
    $mpwizard_keys = get_option( 'mpwizard_keys' );
    $mpwizard_credentials_mode = get_option( 'mpwizard_credentials_mode' );
  
    if ( $mpwizard_credentials_mode === 'test') {
  
      if ( mpwizard_validate_option( 'mpwizard_credentials_test_key' ) === false || 
           mpwizard_validate_option( 'mpwizard_credentials_test_token' ) === false ) {
  
        return false;
  
      }
  
    } else if ( $mpwizard_credentials_mode === 'production') {
  
      if ( mpwizard_validate_option( 'mpwizard_credentials_key' ) === false || 
           mpwizard_validate_option( 'mpwizard_credentials_token' ) === false ) {
  
        return false;
  
      } 
  
    }
  
    return true;
  
  }

}


/**
 * Validate browser.
 *
 * @since 1.0.0
 * 
 * @return bool
 */
if ( !function_exists( 'mpwizard_validate_browser' ) ) {

  function mpwizard_validate_browser() {
 
    if (! isset( $_SERVER['HTTP_USER_AGENT']) ) {
      return true;//in case the variable is not set return
    } else if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && \strpos( $_SERVER['HTTP_USER_AGENT'], 'Trident' ) !== false ) {
      return false;
    } 
    
    return true;
  
  }

}

/**
 * Get a credentials settings error message
 * when these are not established.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_credentials_settings_error_message' ) ) {

  function mpwizard_credentials_settings_error_message() {

    $error_text = esc_html__( "Mercado Pago credentials have not been established. Before registering a product you must set your test or production credentials on the settings page.", 'mpwizard' );
  
    $link_text  = esc_html__('Go to Settings', 'mpwizard');
  
    return  '<div>' . $error_text . ' <a href="'  . menu_page_url('mpwizard-settings', false) . '">'  . $link_text . '</a> </div>';
  
  }

}

/**
 * Add a settings error when credentials 
 * are not established.
 * 
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_credentials_settings_error' ) ) {

  function mpwizard_credentials_settings_error() {

    if ( mpwizard_validate_credentials_settings() === false ) {
     
      add_settings_error( 'mpwizard_messages', 'mpwizard_error', 
      mpwizard_credentials_settings_error_message(),
      'warning' );
      
    }
    
    if ( mpwizard_validate_browser() === false ) {
     
      add_settings_error( 'mpwizard_messages', 'mpwizard_error', 
      esc_html__('The plugin may not work properly with your current browser. Please use a newer browser.', 'mpwizard'),
      'warning' );
      
    }

    if ( mpwizard_validate_log() === false ) {
     
      add_settings_error( 'mpwizard_messages', 'mpwizard_error', 
      esc_html__('Your MPWizard license is invalid. Please contact us to obtain a new license number.', 'mpwizard'),
      'error' );
      
    }
    
  }

}

/**
 * Update post content preferences
 * if credentials mode changes.
 * 
 * @since 1.0.0
 * 
 * @param int $post_id Post ID
 * 
 * @return mixed Post content array or false on failure
 * 
 */
if ( !function_exists( 'mpwizard_update_post_preferences' ) ) {

  function mpwizard_update_post_preferences( $post_id ) {

    $loop = mpwizard_get_posts( $post_id );
      
        $post_content = null;
    
        while ( $loop->have_posts() ) {
        
          $loop->the_post();
        
          $post_content = \json_decode( get_the_content() );

        }

        //get credentials mode
        $credentials_mode = get_option( 'mpwizard_credentials_mode' );
        
        //check if the environment has change
        if( $credentials_mode !== $post_content->credentials_mode ) {

          if ( $credentials_mode === 'production' && empty( $post_content->preference_id ) ) {
            
            //create the preference and get it
            $preference = create_preference(
              $post_content->name,
              $post_content->quantity,
              $post_content->price,
              $post_content->picture_url,
              $post_content->description,  
              $post_content->external_reference,
              $post_content->expiration_date_from,
              $post_content->expiration_date_to
            );

            //update post content preference_id for production
            $post_content->preference_id = sanitize_text_field( $preference->id );
            //update post content init_point
            $post_content->init_point = sanitize_text_field( $preference->init_point );
            //update post content credentials_mode
            $post_content->credentials_mode = 'production';

          } else if ( $credentials_mode === 'production' && ! empty( $post_content->preference_id ) ) {
            
            //update the preference and get it
            $preference = create_preference(
              $post_content->name,
              $post_content->quantity,
              $post_content->price,
              $post_content->picture_url,
              $post_content->description,  
              $post_content->external_reference,
              $post_content->expiration_date_from,
              $post_content->expiration_date_to,
              $post_content->preference_id
            );

            //update post content preference_id for production
            $post_content->preference_id = sanitize_text_field( $preference->id );
            //update post content init_point
            $post_content->init_point = sanitize_text_field( $preference->init_point );
            //update post content credentials_mode
            $post_content->credentials_mode = 'production';

          } else if ( $credentials_mode === 'test' && empty( $post_content->preference_id_test ) ) {
       
            //create the preference and get it
            $preference = create_preference(
              $post_content->name,
              $post_content->quantity,
              $post_content->price,
              $post_content->picture_url,
              $post_content->description,  
              $post_content->external_reference,
              $post_content->expiration_date_from,
              $post_content->expiration_date_to
            );
          
            //update post content preference_id for test
            $post_content->preference_id_test = sanitize_text_field( $preference->id );
            //update post content init_point
            $post_content->init_point_test = sanitize_text_field( $preference->init_point );
            //update post content credentials_mode
            $post_content->credentials_mode = 'test';
          
          } else if ( $credentials_mode === 'test' && ! empty( $post_content->preference_id_test ) ) {
            
            //update the preference and get it
            $preference = create_preference(
              $post_content->name,
              $post_content->quantity,
              $post_content->price,
              $post_content->picture_url,
              $post_content->description,  
              $post_content->external_reference,
              $post_content->expiration_date_from,
              $post_content->expiration_date_to,
              $post_content->preference_id_test
            );

            //update post content preference_id for test
            $post_content->preference_id_test = sanitize_text_field( $preference->id );
            //update post content init_point
            $post_content->init_point_test = sanitize_text_field( $preference->init_point );
            //update post content credentials_mode
            $post_content->credentials_mode = 'test';

          }
          
          if ( ! is_wp_error( $preference, true ) ) {

            //update post
            $my_post = array(
              'ID'   =>  $post_id,
              'post_content' =>  wp_json_encode( $post_content )
              );
              
            // Insert the post into the database
            $post_id = wp_update_post( $my_post );

            if ( $post_id === 0 || is_wp_error( $post_id) ) {
              //TODO Enviar error a log de post no actualizado
              return false;
            } else { 
              //all is ok
              return $post_content;
            }
          
          } else {
            //TODO Enviar error a log de preferencia no actualizada
            return false;
          } 

        }

        return $post_content;
    
  }

}


