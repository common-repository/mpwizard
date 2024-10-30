/**
 * Admin functions
 * 
 * @since  1.0.0
 */
jQuery(document).ready(function($){

/**********************************************************
 Global vars and functions
***********************************************************/

//const { __, _x, _n, sprintf } = wp.i18n;

let mpwizardPicPholder = mpwizard_ajax_obj.img_placeholder;

/**
* Show clean imgage link.
*
* @since 1.0.0
*/
function mpwizardShowCleanImgLink() {

    const imageSrc = $('#mpwizard-btn-picture-img').attr('src');
    
    if ( imageSrc !== undefined && imageSrc !== '' && ! imageSrc.includes( 'image-placeholder' ) ) {
        $('#mpwizard-btn-clean-img').css('visibility','visible');
    }
    
}

/**
* Reset image placeholder.
*
* @since 1.0.0
*/
function mpwizardResetImgPholder() {

    $('#mpwizard-btn-clean-img').css('visibility','hidden');
    $('#mpwizard-btn-picture-img').attr('src', mpwizardPicPholder);
    $('#mpwizard-btn-picture-url').val('');
    
}

/**
* Copy content to clipboard.
*
* @since 1.0.0
*
* @param Object element Html element
* @param string contentToCopy html, data attr or text
*/
function mpwizardCopyToClipboard(element, contentToCopy = 'html') {
    const mpwizardTempInput = $('<input>');
    $('body').append(mpwizardTempInput);

    if ( contentToCopy === 'html' ) {
        mpwizardTempInput.val($(element).html()).select();
    } else if ( contentToCopy === 'text' ) {
        mpwizardTempInput.val(element).select();
    } else {
        const myElement = $(element);
        mpwizardTempInput.val(myElement.data(contentToCopy)).select();
    }
    
    document.execCommand('copy');

    mpwizardTempInput.remove();
}


/**
* Clean product fields.
*
* @since 1.0.0
*
*
*/
function mpwizardCleanAddButtonFields() {
    $('#mpwizard-btn-title').val('');
    $('#mpwizard-btn-quantity').val('1');
    $('#mpwizard-btn-price').val('');
    $('#mpwizard-btn-text').val('');
    mpwizardResetImgPholder();
    $('#mpwizard-btn-desc').val('');
    $('#mpwizard-btn-refnumber').val('');
    $('#mpwizard-btn-activationd').val('');
    $('#mpwizard-btn-expirationd').val('');
}


/**
* Change submmit button state.
*
* @since 1.0.0
*
* @param string disabled State
* @param string html Html content
*
*/
function mpwizardBtnAddSubmmitState(disabled, html) {

    $('#mpwizard-btn-add-submmit').prop('disabled', disabled);
    $('#mpwizard-btn-add-submmit').html(html);
    
}

/**
* Change submmit button state.
*
* @since 1.0.0
*
* @param bool showGeneralSetting Show general settings
* @param bool showStyleSettings Show style settings
*
*/
function mpwizardShowAddButtonFields(showGeneralSetting, showStyleSettings) {

    if ( showGeneralSetting === true ) {
        $('#mpwizard-btn-general-settings').css('display', 'grid'); 
    } else {
        $('#mpwizard-btn-general-settings').css('display', 'none');  
    }

    if ( showStyleSettings === true ) {
        $('#mpwizard-btn-style-settings').css('display', 'grid'); 
    } else {
        $('#mpwizard-btn-style-settings').css('display', 'none');  
    }
    
}


if ( mpwizard_ajax_obj.log === 'no' ) {
    $('#mpwizard-fieldset').attr('disabled','disabled');
}

/**
* Validate product form.
*
* @since 1.0.0
*
*/
function mpwizardAddBtnValidateForm() {

    if ( ! $('#mpwizard-btn-add-form')[0].checkValidity() ) {

           //switch to general settings tab
           $('#mpwizard-btn-general-settings-tab').addClass('nav-tab-active');            

           $('#mpwizard-btn-style-settings-tab').removeClass('nav-tab-active');      

           mpwizardShowAddButtonFields(true, false);

           //show html5 validation errors
           return $('#mpwizard-btn-add-form')[0].reportValidity();
        
    } else {
        return true;
    }

}
    
/**********************************************************
 Media file
***********************************************************/

//show clean image link if necessary
mpwizardShowCleanImgLink();

$('#mpwizard-btn-picture').click(function(e) {
    e.preventDefault();

  // Extend the wp.media object
  mediaUploader = wp.media.frames.file_frame = wp.media({
            title: mpwizard_ajax_obj.translations.SelectPicture,
            button: {
            text: mpwizard_ajax_obj.translations.SelectPicture
        }, multiple: false });

  // When a file is selected, grab the URL and set it as the text field's value
  mediaUploader.on('select', function() {
        attachment = mediaUploader.state().get('selection').first().toJSON();
        $('#mpwizard-btn-picture-img').attr('src', attachment.url);
        $('#mpwizard-btn-picture-url').val(attachment.url);
        $('#mpwizard-btn-clean-img').css('visibility','visible');
    });

  // Open the uploader dialog
  mediaUploader.open();

});

$('#mpwizard-btn-clean-img').click(function(e) {
    e.preventDefault();
    mpwizardResetImgPholder();
});

/**********************************************************
 Add and edit button form submit handler
***********************************************************/

$('#mpwizard-btn-add-form').submit(function(event) {
    event.preventDefault();
    
    //validate form
    if ( mpwizardAddBtnValidateForm() === true ) {

        mpwizardBtnAddSubmmitState(true, 'Registrar <i class="fas fa-circle-notch fa-spin"></li>');

        let mpwizarFormData = new FormData(this);

        mpwizarFormData.append('_ajax_nonce', mpwizard_ajax_obj.nonce);
        mpwizarFormData.append('action', 'mpwizard_add_button');

        //check if id param exits for add or edit action
        const urlParams = new URLSearchParams(window.location.search);
        const idParam = urlParams.get('id');

        if ( idParam !== null ) {
            mpwizarFormData.append('post_id', idParam);       
        }

        $.ajax({
            url: mpwizard_ajax_obj.ajax_add_url,
            data: mpwizarFormData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){

                if (data.post_id !== -1) {

                    //clean fields
                    if ( idParam === null ) {
                        mpwizardCleanAddButtonFields();          
                    }
                    
                    $.alert({
                    title: idParam !== null ? mpwizard_ajax_obj.translations.UpdatedProduct : mpwizard_ajax_obj.translations.RegisteredProduct,
                    content: /*idParam !== null ? 
                             mpwizard_ajax_obj.translations.UpdatedProduct : */
                             mpwizard_ajax_obj.translations.HereIsYourPaymentLink + ': <br>' + 
                                '<strong id="mpwizard-link">' + data.init_point + '</strong> <br>' + 
                                '<span id="mpwizard-shortcode-copied">' + mpwizard_ajax_obj.translations.ClickOnItToCopy + '</span> <br>',
                    type: 'green',
                    boxWidth: '400px',
                    useBootstrap: false,
                    icon: 'fas fa-check-circle fa-2x',
                    escapeKey: true,
                    backgroundDismiss: true
                    });

                } else {

                    //TODO LOG

                    $.dialog({
                        title: mpwizard_ajax_obj.translations.AnErrorHasOccurred,
                        content: data.error,
                        type: 'red',
                        boxWidth: '400px',
                        useBootstrap: false,
                        icon: 'fas fa-exclamation-circle fa-2x',
                        escapeKey: true,
                        backgroundDismiss: true
                    });

                }

                mpwizardBtnAddSubmmitState( false, idParam !== null ? mpwizard_ajax_obj.translations.Update : mpwizard_ajax_obj.translations.Register );
            
            },
            error: function(data){

                //TODO LOG
                
                    $.dialog({
                        title: mpwizard_ajax_obj.translations.AnErrorHasOccurred,
                        content: data.error,
                        type: 'red',
                        boxWidth: '400px',
                        useBootstrap: false,
                        icon: 'fas fa-exclamation-circle fa-2x',
                        escapeKey: true,
                        backgroundDismiss: true
                    });

                    mpwizardBtnAddSubmmitState( false, idParam !== null ? mpwizard_ajax_obj.translations.Update : mpwizard_ajax_obj.translations.Register );
                
            }
        });
        
    } 
      
});

/********************link result***************************************/

$(document).on('click', '#mpwizard-link', function(event){

    event.preventDefault();

    mpwizardCopyToClipboard('#mpwizard-link');

    $('#mpwizard-shortcode-copied').html( mpwizard_ajax_obj.translations.Copied );

    $('#mpwizard-shortcode-copied').css('color', '#2ECC71');
});

/**********************************************************
 products list
***********************************************************/

function appendProcessing(element) {

    const processing = $( '<i id="processing" class="fas fa-circle-notch fa-spin icon-green"></i>' ); 

    $(element).append( processing );

    $(element).find('.mpwizard-ip-copy').css('display','none'); 
    
}

function removeProcessing(element) {

    $(element).find('.mpwizard-ip-copy').css('display','inline'); 

    $(element).find( '#processing' ).remove();
    
}

function appendCheck(element) {

    const check = $( '<i class="fas fa-check-circle icon-green"></i>' ); 

    $(element).append( check );

    check.fadeOut( 2600 );
    
}

$(document).on('click', '.mpwizard-sc-copy', function(event) {

    event.preventDefault();

    mpwizardCopyToClipboard($(this).parent(), 'content');

    appendCheck($(this).parent());
});

$(document).on('click', '.mpwizard-ip-copy', function(event) {

    event.preventDefault();

    const myElement = $(this);

    const parent = myElement.parent();

    //update preference just in case of changes
    const poductId = parent.data('postId');

        let mpwizarFormData = new FormData();

        mpwizarFormData.append( '_ajax_nonce', mpwizard_ajax_obj.nonce );
        mpwizarFormData.append( 'action', 'mpwizard_get_init_point' );
        mpwizarFormData.append( 'product', poductId );

        appendProcessing(parent);

        $.ajax({
            url: mpwizard_ajax_obj.ajax_init_point_url,
            data: mpwizarFormData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){

                if ( data.init_point !== -1 && data.init_point !== '' ) {

                    //if actual data-content 
                    //is empty fill it
                    if ( parent.data('content') === '#' ) {//TODO Decidir si quita el atributo data-content
                        parent.attr('data-content', data.init_point);
                    }

                   //copy to clipboard
                   mpwizardCopyToClipboard(data.init_point, 'text');
                   removeProcessing(parent);
                   appendCheck(parent);

                } else {

                    //TODO LOG

                    removeProcessing(parent);

                    $.alert({
                        title: '',
                        content: data.error,
                        type: 'red',
                        boxWidth: '400px',
                        useBootstrap: false,
                        icon: 'fas fa-exclamation-circle fa-2x',
                        escapeKey: true,
                        backgroundDismiss: true
                    });

                }
            },
            error: function(data){

                //TODO LOG

                removeProcessing(parent);

                $.alert({
                    title: '',
                    content: data.error,
                    type: 'red',
                    boxWidth: '400px',
                    useBootstrap: false,
                    icon: 'fas fa-exclamation-circle fa-2x',
                    escapeKey: true,
                    backgroundDismiss: true
                });   
            }
        });

});

$( '.mpwizard-delete-product' ).click( function (event) {

    event.preventDefault();

    const poductId = this.dataset.productId;

    $.confirm({
        title: '',
        content: mpwizard_ajax_obj.translations.AreYouSureYouWantToRemoveThisProduct,
        type: 'orange',
        boxWidth: '400px',
        useBootstrap: false,
        icon: 'far fa-trash-alt fa-2x',
        escapeKey: true,
        buttons: {
            confirm: {
                text: 'Aceptar',
                action: function () {

                    let mpwizarFormData = new FormData();

                    mpwizarFormData.append( '_ajax_nonce', mpwizard_ajax_obj.nonce );
                    mpwizarFormData.append( 'action', 'mpwizard_delete_product' );
                    mpwizarFormData.append( 'product', poductId );
    
                    $.ajax({
                        url: mpwizard_ajax_obj.ajax_delete_url,
                        data: mpwizarFormData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function(data){
            
                            if (data.post_id !== -1) {

                               //refresh page
                               location.reload();
            
                            } else {

                                //TODO LOG
                                $.alert({
                                    title: '',
                                    content: data.error,
                                    type: 'red',
                                    boxWidth: '400px',
                                    useBootstrap: false,
                                    icon: 'fas fa-exclamation-circle fa-2x',
                                    escapeKey: true,
                                    backgroundDismiss: true
                                });
                            }
                        },
                        error: function(data){
            
                            //TODO LOG
                            $.alert({
                                title: '',
                                content: data.error,
                                type: 'red',
                                boxWidth: '400px',
                                useBootstrap: false,
                                icon: 'fas fa-exclamation-circle fa-2x',
                                escapeKey: true,
                                backgroundDismiss: true
                            });   
                        }
                    });
                    
                }

            },
            cancel: {
                text: mpwizard_ajax_obj.translations.Cancel
            }
        }
    });

} );

});