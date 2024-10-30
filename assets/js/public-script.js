/**
 * Public functions
 * 
 * @since  1.0.0
 */
jQuery(document).ready(function($){

/**********************************************************
 Checkout Pro
***********************************************************/

let mpwizardMp = null;
let mpwizardPreference = null;

/**
* Retrieve checkout from preference.
*
* @since 1.0.0
*
* @param string preferenceId Preference ID.
*
* @return Object Checkout.
*/
function getPreference( preferenceId ){

    // Inicializa el checkout
    const mpCheckout = mpwizardMp.checkout({
      preference: {
          id: preferenceId
      }
    });

    return mpCheckout;

}

if ( $('.mpwizard-product-btn').length > 0 && $('.mpwizard-product-btn').attr('onclick') === undefined ) {

    // Agrega credenciales de SDK
    mpwizardMp = new MercadoPago( mpwizard_ajax_obj.credentials_public_key, {
        //locale: 'es-MX'
    });

    mpwizardPreference = getPreference( $('.mpwizard-product-btn').data('preferenceId' ));

}


//Product button click handler
$('.mpwizard-product-btn').click(function(event) {

    const attrOnClick = $(this).attr('onclick');

    if ( attrOnClick === undefined ) {

        event.preventDefault();
        
        mpwizardPreference.open();
        
    }        
});

});