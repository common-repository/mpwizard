<?php

/**
 * Create a preference
 *
 * @since 1.0.0
 * 
 * @param  string $item_title
 * @param  int    $item_quantity
 * @param  float  $item_price
 * @param  string $item_picture_url
 * @param  string $item_description
 * @param  string $external_reference
 * @param  string $expiration_date_from
 * @param  string $expiration_date_to
 * @param  string $preference_id
 * 
 * @return mixed
 * 
 */
if ( !function_exists( 'create_preference' ) ) {
    
    function create_preference( $item_title, $item_quantity, $item_price, $item_picture_url = null, $item_description = null, $external_reference = null, $expiration_date_from = null, $expiration_date_to = null, $preference_id = null ){
   
        $preference =   new stdClass();

        $item = array(
            'title' =>  $item_title,
            'quantity'  =>  \intval( $item_quantity ),
            'unit_price'    =>  \floatval( $item_price )
        );

        $curl=  null;

        $access_token   =   null;

        //Set Mercado Pago access token
        if ( !empty( mpwizard_get_settings()[ 'access_token' ] ) ) {
            $access_token   =   mpwizard_get_settings()[ 'access_token' ];
        }
        
    
        if (! isset($item_title) || empty($item_title)) {
            return new WP_Error( 'mpwizard_error', esc_html__( 'Product name has not been established', 'mpwizard' ) );
        }
        if (! isset($item_quantity) || empty($item_quantity)) {
            return new WP_Error( 'mpwizard_error', esc_html__( 'Product quantity has not been established', 'mpwizard' ) );
        }
        if (! isset($item_price) || empty($item_price)) {
            return new WP_Error( 'mpwizard_error', esc_html__( 'Product price has not been established', 'mpwizard' ) );
        }   
        
        if ( isset( $item_picture_url ) || ! empty( $item_picture_url ) ) {
            array_push( $item, array( 'picture_url', $item_picture_url ) );
        }
        /*if ( isset( $item_description ) || ! empty( $item_description ) ) {
            array_push( $item, array( 'description', $item_description ) );
        }*/     
        if ( isset( $external_reference ) || ! empty( $external_reference ) ) {
            $preference->external_reference = $external_reference;
        }
        if ( isset( $expiration_date_from ) && ! empty( $expiration_date_from ) ) {
            $expiration_date_from = new DateTime( $expiration_date_from );
            $preference->expiration_date_from = $expiration_date_from->format('Y-m-d\TH:i:s');
            $preference->expires = true;
        }
    
        if ( isset( $expiration_date_to ) && ! empty( $expiration_date_to ) ) {
            $expiration_date_to = new DateTime( $expiration_date_to );
            $preference->expiration_date_to = $expiration_date_to->format('Y-m-d\TH:i:s');
            $preference->expires = true;
        }
        //get general settings
        $mpwizard_settings  =   mpwizard_get_settings();
        if ( ! empty( $mpwizard_settings['currency'] ) ) {
            $preference->curency_id =   $mpwizard_settings['currency'];
        }
    
        if ( ! empty( $mpwizard_settings['installments'] ) ) {
            $payment_methods    =   new stdClass();
            $payment_methods->installments  =   intval( $mpwizard_settings['installments'] );
            $preference->payment_methods    =   $payment_methods;
        }
        if ( ! empty( $mpwizard_settings['marketplace'] ) ) {
            $preference->marketplace =   strval( $mpwizard_settings['marketplace'] );//TODO Ver por que no registra el marketplace
        }
        if ( ! empty( $mpwizard_settings['statementdesc'] ) ) {
            $preference->statement_descriptor =   strval( $mpwizard_settings['statementdesc'] );
        }
        if ( ! empty( $mpwizard_settings['binarymode'] ) ) {
            $preference->binary_mode =   boolval( $mpwizard_settings['binarymode'] );
        }
    
        $back_urls = new stdClass();
        if ( ! empty( $mpwizard_settings['successdir'] ) ) {
            $back_urls->success = $mpwizard_settings['successdir'];
            //if success url exits set auto_return to approved
            $preference->auto_return = 'approved';
        }
        if ( ! empty( $mpwizard_settings['pendingdir'] ) ) {
            $back_urls->pending = $mpwizard_settings['pendingdir'];
        }  
        if ( ! empty( $mpwizard_settings['failuredir'] ) ) {
            $back_urls->failure = $mpwizard_settings['failuredir'];
        }
    
        $preference->back_urls = $back_urls;

        $preference->items  =   array( $item );
    
        //check again preference_id for update or create action
        if ( ! is_null( $preference_id ) ) {

            \array_push( $item, array( 'id', $preference_id ) );

            $curl   =   \curl_init( "https://api.mercadopago.com/checkout/preferences/{$preference_id}" );

            \curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'PUT' );

        } else {    

            $curl   =   \curl_init( 'https://api.mercadopago.com/checkout/preferences' );

            \curl_setopt($curl, CURLOPT_POST, true);
            
        }

        $json_string    =   wp_json_encode( $preference );

        \curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);
        
        \curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ));
            
        \curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response   =   \curl_exec($curl);

        \curl_close($curl);

        $response = \json_decode( $response );
        
        if ( isset( $response->error ) ) {
            return new WP_Error( 'mpwizard_error', '<strong>' . 
                                                    esc_html__( 'Mercado Pago error:', 'mpwizard' ) .
                                                    '</strong><br><br>' .
                                                    $response->error . ': ' .
                                                    $response->message /*. '<br><a href="#" target="_blank">' .
                                                    esc_html__( 'Conoce más sobre este tipo de errores', 'mpwizard' ) . '</a>'*/
                                );
        } else {
            return $response;
        }   
    
    }

}

/**
 * Create a suscription plan
 *
 * @since 1.1.0
 * 
 * @param  string $reason
 * @param  float  $frecuency
 * @param  string $frequency_type 
 * @param  string $transaction_amount
 * @param  string $currency_id 
 * @param  string $repetitions
 * @param  string $external_reference
 * @param  string $back_url
 * 
 * @return mixed
 * 
 */
/*if ( !function_exists( 'create_suscription_plan' ) ) {
    
    function create_suscription_plan( $reason, $frecuency, $frequency_type, $currency_id, $transaction_amount, $repetitions, $external_reference, $back_url ) {

        $access_token   =   null;

        //Set Mercado Pago access token
        if ( !empty( mpwizard_get_settings()[ 'access_token' ] ) ) {
            $access_token   =    mpwizard_get_settings()[ 'access_token' ];
        }

        // Crea el objeto auto_recurring
        $data   =   new stdClass();
        $data->reason   =   $reason;

        // Crea el objeto auto_recurring
        $auto_recurring   =   new stdClass();
        $auto_recurring->frequency  =   $frecuency;
        $auto_recurring->frequency_type  =   $frequency_type;
        $auto_recurring->transaction_amount  =   $transaction_amount;
        $auto_recurring->currency_id  =   $currency_id;
        $auto_recurring->repetitions  =   $repetitions;

        $data->auto_recurring   =   $auto_recurring;
        $data->external_reference   =   $external_reference;
        $data->back_url   =   $back_url;

        $url  = 'https://api.mercadopago.com/preapproval';

        $data = array(
          'license_key' => get_option( 'mpwizard_license_key' )
        );

        $response = wp_remote_post( $url, array( 
          'headers' => array( 'Content-Type' => 'application/json',
                              'Authorization' => 'Bearer' . ' ' . $access_token ),
          'body'  =>  json_encode($data) 
          ) 
        ); 

        var_dump( $response );

        $body     = wp_remote_retrieve_body( $response );

        $checker =  \json_decode( $body );

        var_dump( $body );
    
    }

}*/