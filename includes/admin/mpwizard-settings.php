<?php

/**********************************************************
 global vars
***********************************************************/

if ( !isset( $mpwizard_settings_credentials_fields ) ) {

  $mpwizard_settings_credentials_fields = array( 
    'mpwizard_credentials_test_key',                                          
    'mpwizard_credentials_test_token',
    'mpwizard_credentials_key',                                          
    'mpwizard_credentials_token' 
  );

}

/**********************************************************
 settings callbacks
***********************************************************/

 /****************sections**************/

if ( !function_exists( 'mpwizard_credentials_mode_section_callback' ) ) {

  function mpwizard_credentials_mode_section_callback() {
  
  }

}

if ( !function_exists( 'mpwizard_credentials_test_section_callback' ) ) {

  function mpwizard_credentials_test_section_callback() {
    ?>
    <!--<div id="mpwizard-test-credentials">--><!--test credentials section wrapper-->
    <h3><?php esc_html_e( 'Test credentials', 'mpwizard' ) ?></h3>
    <p class="mpwizard-setting-help"><?php esc_html_e( 'Keys to do the tests you want.', 'mpwizard' ) ?></p>
    <p><a href="https://www.mercadopago.com/developers/panel/credentials" target="_blank"><?php esc_html_e( 'Get credentials', 'mpwizard' ) ?></a></p>
    <?php
  }

}

if ( !function_exists( 'mpwizard_credentials_section_callback' ) ) {

  function mpwizard_credentials_section_callback() {
    ?>
    <!--</div>--><!--end test credentials section wrapper-->
    <!--<div id="mpwizard-production-credentials">--><!--production credentials section wrapper-->
    <h3><?php esc_html_e( 'Production credentials', 'mpwizard' ) ?></h3>
    <p class="mpwizard-setting-help"><?php esc_html_e( 'Keys to receive real payments from your clients.', 'mpwizard' ) ?></p>
    <p><a href="https://www.mercadopago.com/developers/panel/credentials" target="_blank"><?php esc_html_e( 'Get credentials', 'mpwizard' ) ?></a></p>
    <?php
  }

}

if ( !function_exists( 'mpwizard_payment_preferences_section_callback' ) ) {

  function mpwizard_payment_preferences_section_callback() {
    ?>
    <!--</div>--><!--end production credentials section wrapper-->
    <?php
  }
  
}

if ( !function_exists( 'mpwizard_payment_business_section_callback' ) ) {

  function mpwizard_payment_business_section_callback() {
    //echo '<p>'.__('Detalles de tu negocio.', 'mpwizard').'</p>';
  }

}

 /****************fields**************/

 if ( !function_exists( 'mpwizard_credentials_mode_callback' ) ) {

  function mpwizard_credentials_mode_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_credentials_mode');
    // output the field
    ?>
    <select id="mpwizard_credentials_mode" name="mpwizard_credentials_mode">
      <option value="test" <?php selected( $setting, 'test' ); ?> >No</option>
      <option value="production" <?php selected( $setting, 'production' ); ?> >Si</option>
    </select>
    <p class="mpwizard-setting-help"><?php esc_html_e( 'Choose "No" to activate test mode. Change to "Yes" only when you are ready to sell.', 'mpwizard' ) ?></p>
    <?php
   }

 }

if ( !function_exists( 'mpwizard_credentials_test_key_callback' ) ) {

  function mpwizard_credentials_test_key_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_credentials_test_key');
    // output the field
    ?>
    <input type="text" class="mpwizard-input-lg" name="mpwizard_credentials_test_key" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" placeholder="TEST-00000000-0000-0000-0000-000000000000"><br>
    <?php
  }

}

if ( !function_exists( 'mpwizard_credentials_test_token_callback' ) ) {

  function mpwizard_credentials_test_token_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_credentials_test_token');
    // output the field
    ?>
    <input type="text" class="mpwizard-input-lg" name="mpwizard_credentials_test_token" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" placeholder="TEST-000000000000000000000000000000000-000000-00000000000000000000000000000000-000000000"><br>
    <?php
  }

}

if ( !function_exists( 'mpwizard_credentials_key_callback' ) ) {

  function mpwizard_credentials_key_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_credentials_key');
    // output the field
    ?>
    <input type="text" class="mpwizard-input-lg" name="mpwizard_credentials_key" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" placeholder="APP-USR-00000000-0000-0000-0000-000000000000"><br>
    <?php
  }

}

if ( !function_exists( 'mpwizard_credentials_token_callback' ) ) {

  function mpwizard_credentials_token_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_credentials_token');
    // output the field
    ?>
    <input type="text" class="mpwizard-input-lg" name="mpwizard_credentials_token" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" placeholder="APP-USR-000000000000000000000000000000000-000000-00000000000000000000000000000000-000000000"><br>
    <?php
  }

}

if ( !function_exists( 'mpwizard_payment_preferences_currency_callback' ) ) {

  function mpwizard_payment_preferences_currency_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_payment_preferences_currency');
    // output the field
    ?>
    <select name="mpwizard_payment_preferences_currency">
      <option value="MLA" <?php selected( $setting, 'MLA' ); ?> >Argentina</option>
      <option value="MLB" <?php selected( $setting, 'MLB' ); ?> >Brasil</option>
      <option value="MLC" <?php selected( $setting, 'MLC' ); ?> >Chile</option>
      <option value="MLU" <?php selected( $setting, 'MLU' ); ?> >Uruguay</option>
      <option value="MCO" <?php selected( $setting, 'MCO' ); ?> >Colombia</option>
      <option value="MLV" <?php selected( $setting, 'MLV' ); ?> >Venezuela</option>
      <option value="MPE" <?php selected( $setting, 'MPE' ); ?> >Perú</option>
      <option value="MLM" <?php selected( $setting, 'MLM' ); ?> >México</option>
    </select>
    <p class="mpwizard-setting-help"><?php esc_html_e( 'Country to which the currency you want to sell belongs to.', 'mpwizard' ) ?></p>
    <?php
  }

}

if ( !function_exists( 'mpwizard_payment_preferences_installments_callback' ) ) {

  function mpwizard_payment_preferences_installments_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_payment_preferences_installments');
    // output the field
    ?>
  
    <select name="mpwizard_payment_preferences_installments">
      <option value="1" <?php selected( $setting, '1' ); ?> >1x <?php esc_html_e( 'installment', 'mpwizard' ) ?></option>
      <option value="2" <?php selected( $setting, '2' ); ?> >2x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="3" <?php selected( $setting, '3' ); ?> >3x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="4" <?php selected( $setting, '4' ); ?> >4x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="5" <?php selected( $setting, '5' ); ?> >5x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="6" <?php selected( $setting, '6' ); ?> >6x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="7" <?php selected( $setting, '7' ); ?> >7x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="8" <?php selected( $setting, '8' ); ?> >8x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="9" <?php selected( $setting, '9' ); ?> >9x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="10" <?php selected( $setting, '10' ); ?> >10x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="11" <?php selected( $setting, '11' ); ?> >11x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="12" <?php selected( $setting, '12' ); ?> >12x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="13" <?php selected( $setting, '13' ); ?> >13x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="14" <?php selected( $setting, '14' ); ?> >14x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="15" <?php selected( $setting, '15' ); ?> >15x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="16" <?php selected( $setting, '16' ); ?> >16x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="17" <?php selected( $setting, '17' ); ?> >17x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="18" <?php selected( $setting, '18' ); ?> >18x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="19" <?php selected( $setting, '19' ); ?> >19x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="20" <?php selected( $setting, '20' ); ?> >20x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="21" <?php selected( $setting, '21' ); ?> >21x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="22" <?php selected( $setting, '22' ); ?> >22x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="23" <?php selected( $setting, '23' ); ?> >23x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
      <option value="24" <?php selected( $setting, '24' ); ?> >24x <?php esc_html_e( 'installments', 'mpwizard' ) ?></option>
    </select>
    <p class="mpwizard-setting-help"><?php esc_html_e( 'Maximum installments with which a customer can buy.', 'mpwizard' ) ?></p>
    <?php
  }

}

if ( !function_exists( 'mpwizard_payment_preferences_binarymode_callback' ) ) {

  function mpwizard_payment_preferences_binarymode_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_payment_preferences_binarymode');
    // output the field
    ?>
    <select name="mpwizard_payment_preferences_binarymode">
      <option value="1" <?php selected( $setting, '1' ); ?> ><?php esc_html_e( 'Yes', 'mpwizard' ) ?></option>
      <option value="0" <?php selected( $setting, '0' ); ?> ><?php esc_html_e( 'No', 'mpwizard' ) ?></option>
    </select>
    <p class="mpwizard-setting-help"><?php esc_html_e( 'Payment can only be approved or rejected.', 'mpwizard' ) ?></p>
    <?php
  }

}

if ( !function_exists( 'mpwizard_payment_preferences_successdir_callback' ) ) {

  function mpwizard_payment_preferences_successdir_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_payment_preferences_successdir');
    // output the field
    ?>
    <input type="url" class="mpwizard-input-lg" name="mpwizard_payment_preferences_successdir" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" placeholder="https://success.com"><br>
    <p class="mpwizard-setting-help"><?php esc_html_e( 'URL that will be shown to your customers when they finish their purchase.', 'mpwizard' ) ?></p>
    <?php
  }

}

if ( !function_exists( 'mpwizard_payment_preferences_pendingdir_callback' ) ) {

  function mpwizard_payment_preferences_pendingdir_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_payment_preferences_pendingdir');
    // output the field
    ?>
    <input type="url" class="mpwizard-input-lg" name="mpwizard_payment_preferences_pendingdir" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" placeholder="http://pending.com"><br>
    <p class="mpwizard-setting-help"><?php esc_html_e( 'URL that will be shown to your customers when the payment is in the approval process.', 'mpwizard' ) ?></p>
    <?php
  }

}

if ( !function_exists( 'mpwizard_payment_preferences_failuredir_callback' ) ) {

  function mpwizard_payment_preferences_failuredir_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_payment_preferences_failuredir');
    // output the field
    ?>
    <input type="url" class="mpwizard-input-lg" name="mpwizard_payment_preferences_failuredir" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" placeholder="http://failure.com"><br>
    <p class="mpwizard-setting-help"><?php esc_html_e( 'URL that will be shown to your customers when the payment is rejected.', 'mpwizard' ) ?></p>
    <?php
  }

}

if ( !function_exists( 'mpwizard_business_marketplace_callback' ) ) {

  function mpwizard_business_marketplace_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_business_marketplace');
    // output the field
    ?>
    <input type="text" name="mpwizard_business_marketplace" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" placeholder="<?php esc_html_e('My business', 'mpwizard') ?>">
    <p class="mpwizard-setting-help"><?php esc_html_e( "This name will appear on your clients' invoice.", 'mpwizard' ) ?></p> 
    <?php
  }

}

if ( !function_exists( 'mpwizard_business_statementdesc_callback' ) ) {

  function mpwizard_business_statementdesc_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('mpwizard_business_statementdesc');
    // output the field
    ?>
    <input type="text" name="mpwizard_business_statementdesc" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>" placeholder="<?php esc_html_e('STORE-ID', 'mpwizard') ?>">
    <p class="mpwizard-setting-help"><?php esc_html_e( 'How the payment will appear on the card statement.', 'mpwizard' ) ?></p> 
    <?php
  }

}

/**
 * Initialize settings.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_settings_init' ) ) {

  function mpwizard_settings_init() {

    /****************register sections**************/
  
    add_settings_section(
      'mpwizard_credentials_mode_section',
      __('Operation mode', 'mpwizard'), 
      'mpwizard_credentials_mode_section_callback',
      'mpwizard-settings'
    );
  
    add_settings_section(
      'mpwizard_credentials_test_section',
      '', 
      'mpwizard_credentials_test_section_callback',
      'mpwizard-settings'
    );
  
    add_settings_section(
        'mpwizard_credentials_section',
        '', 
        'mpwizard_credentials_section_callback',
        'mpwizard-settings'
    );
  
    add_settings_section(
      'mpwizard_payment_preferences_section',
      __('Payment preferences', 'mpwizard'), 
      'mpwizard_payment_preferences_section_callback',
      'mpwizard-settings'
    );
  
    add_settings_section(
      'mpwizard_payment_business_section',
      __('Business information', 'mpwizard'), 
      'mpwizard_payment_business_section_callback',
      'mpwizard-settings'
    );
  
    /****************register fields**************/
  
    add_settings_field(
      'mpwizard_credentials_mode',
      __('Production', 'mpwizard'), 
      'mpwizard_credentials_mode_callback',
      'mpwizard-settings',
      'mpwizard_credentials_mode_section'
    );
  
    add_settings_field(
      'mpwizard_credentials_test_key',
      __('Public Key', 'mpwizard'), 
      'mpwizard_credentials_test_key_callback',
      'mpwizard-settings',
      'mpwizard_credentials_test_section'
    );
  
    add_settings_field(
      'mpwizard_credentials_test_token',
      __('Access Token', 'mpwizard'), 
      'mpwizard_credentials_test_token_callback',
      'mpwizard-settings',
      'mpwizard_credentials_test_section'
    );
  
    add_settings_field(
        'mpwizard_credentials_key',
        __('Public Key', 'mpwizard'), 
        'mpwizard_credentials_key_callback',
        'mpwizard-settings',
        'mpwizard_credentials_section'
    );
  
    add_settings_field(
      'mpwizard_credentials_token',
      __('Access Token', 'mpwizard'), 
      'mpwizard_credentials_token_callback',
      'mpwizard-settings',
      'mpwizard_credentials_section'
      );
  
      add_settings_field(
        'mpwizard_payment_preferences_currency',
        __('Country', 'mpwizard'), 
        'mpwizard_payment_preferences_currency_callback',
        'mpwizard-settings',
        'mpwizard_payment_preferences_section'
      );
  
      add_settings_field(
        'mpwizard_payment_preferences_installments',
        __('Maximum installments', 'mpwizard'), 
        'mpwizard_payment_preferences_installments_callback',
        'mpwizard-settings',
        'mpwizard_payment_preferences_section'
      );
  
      add_settings_field(
        'mpwizard_payment_preferences_binarymode',
        __('Binary mode', 'mpwizard'), 
        'mpwizard_payment_preferences_binarymode_callback',
        'mpwizard-settings',
        'mpwizard_payment_preferences_section'
      );
  
      add_settings_field(
        'mpwizard_payment_preferences_successdir',
        __('Approved payment URL', 'mpwizard'), 
        'mpwizard_payment_preferences_successdir_callback',
        'mpwizard-settings',
        'mpwizard_payment_preferences_section'
      );
  
      add_settings_field(
        'mpwizard_payment_preferences_pendingdir',
        __('Pending payment URL', 'mpwizard'), 
        'mpwizard_payment_preferences_pendingdir_callback',
        'mpwizard-settings',
        'mpwizard_payment_preferences_section'
      );
  
      add_settings_field(
        'mpwizard_payment_preferences_failuredir',
        __('Payment rejected URL', 'mpwizard'), 
        'mpwizard_payment_preferences_failuredir_callback',
        'mpwizard-settings',
        'mpwizard_payment_preferences_section'
      );
  
      add_settings_field(
        'mpwizard_business_marketplace',
        __('Store name', 'mpwizard'), 
        'mpwizard_business_marketplace_callback',
        'mpwizard-settings',
        'mpwizard_payment_business_section'
      );
  
      add_settings_field(
        'mpwizard_business_statementdesc',
        __('Store ID', 'mpwizard'), 
        'mpwizard_business_statementdesc_callback',
        'mpwizard-settings',
        'mpwizard_payment_business_section'
      );
  
    /****************register settings**************/
  
    register_setting('mpwizard', 'mpwizard_credentials_mode', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ) );
  
    register_setting('mpwizard', 'mpwizard_credentials_test_key', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ) );
    register_setting('mpwizard', 'mpwizard_credentials_test_token', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ) );
  
    register_setting('mpwizard', 'mpwizard_credentials_key', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ) );
    register_setting('mpwizard', 'mpwizard_credentials_token', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ) );
  
    register_setting('mpwizard', 'mpwizard_payment_preferences_currency', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ) );
    register_setting('mpwizard', 'mpwizard_payment_preferences_installments', array( 'type' => 'integer', 'sanitize_callback' => 'sanitize_text_field' ) );
    register_setting('mpwizard', 'mpwizard_payment_preferences_binarymode', array( 'type' => 'integer', 'sanitize_callback' => 'sanitize_text_field' ) );
    register_setting('mpwizard', 'mpwizard_payment_preferences_successdir', array( 'type' => 'string', 'sanitize_callback' => 'esc_url_raw' ) );
    register_setting('mpwizard', 'mpwizard_payment_preferences_pendingdir', array( 'type' => 'string', 'sanitize_callback' => 'esc_url_raw' ) );
    register_setting('mpwizard', 'mpwizard_payment_preferences_failuredir', array( 'type' => 'string', 'sanitize_callback' => 'esc_url_raw' ) );
  
    register_setting('mpwizard', 'mpwizard_business_marketplace', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ) );
    register_setting('mpwizard', 'mpwizard_business_statementdesc', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ) );
    
  }

}
  
/**********************************************************
 settings filters
***********************************************************/

/**
 * Encript a settings field.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_encript_settings_field' ) ) {

  function mpwizard_encript_settings_field( $value, $option, $old_value ) {

    global $mpwizard_settings_credentials_fields;

    if( in_array( $option, $mpwizard_settings_credentials_fields, true ) && ! empty( $value ) ) {

        $value = mpwizard_secure_encrypt( $value ); 

    }
  
    return $value;
  
  }

}

/**
 * Decript a settings field.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_decript_settings_field' ) ) {

  function mpwizard_decript_settings_field( $value, $option ) {

    global $mpwizard_settings_credentials_fields;

    if( in_array( $option, $mpwizard_settings_credentials_fields, true ) && ! empty( $value ) ) {

      $value = mpwizard_secure_decrypt( $value );

    }

    return $value;

  }

}
  
