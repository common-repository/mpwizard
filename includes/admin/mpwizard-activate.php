<?php

/**
 * Activation tasks.
 *
 * @since 1.0.0
 * 
 */
if ( !function_exists( 'mpwizard_activate' ) ) {

  function mpwizard_activate() { 

    if ( ! get_option( 'mpwizard_credentials_mode' ) ) {
      update_option( 'mpwizard_credentials_mode', 'test' );
    }
  
    if ( ! get_option( 'mpwizard_credentials_test_key' ) ) {
      update_option( 'mpwizard_credentials_test_key', '' );
    }
  
    if ( ! get_option( 'mpwizard_credentials_test_token' ) ) {
      update_option( 'mpwizard_credentials_test_token', '' );
    }
  
    if ( ! get_option( 'mpwizard_credentials_key' ) ) {
      update_option( 'mpwizard_credentials_key', '' );
    }
  
    if ( ! get_option( 'mpwizard_credentials_token' ) ) {
      update_option( 'mpwizard_credentials_token', '' );
    }
  
    if ( ! get_option( 'mpwizard_payment_preferences_currency' ) ) {
      update_option( 'mpwizard_payment_preferences_currency', 'MLA' );
    }
  
    if ( ! get_option( 'mpwizard_payment_preferences_installments' ) ) {
      update_option( 'mpwizard_payment_preferences_installments', '1' );
    }
  
    if ( ! get_option( 'mpwizard_payment_preferences_binarymode' ) ) {
      update_option( 'mpwizard_payment_preferences_binarymode', '0' );
    }
  
    if ( ! get_option( 'mpwizard_payment_preferences_successdir' ) ) {
      update_option( 'mpwizard_payment_preferences_successdir', '' );
    }
  
    if ( ! get_option( 'mpwizard_payment_preferences_pendingdir' ) ) {
      update_option( 'mpwizard_payment_preferences_pendingdir', '' );
    }
  
    if ( ! get_option( 'mpwizard_payment_preferences_failuredir' ) ) {
      update_option( 'mpwizard_payment_preferences_failuredir', '' );
    }
  
    if ( ! get_option( 'mpwizard_business_marketplace' ) ) {
      update_option( 'mpwizard_business_marketplace', '' );
    }
  
    if ( ! get_option( 'mpwizard_business_statementdesc' ) ) {
      update_option( 'mpwizard_business_statementdesc', '' );
    }
  
  }

}
  
