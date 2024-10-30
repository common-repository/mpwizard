<?php

// add error/update messages

// check if the user have submitted the settings
// WordPress will add the "settings-updated" $_GET parameter to the url
$settings_updated   =   isset( $_GET['settings-updated'] ) ? sanitize_text_field( $_GET['settings-updated'] ) : null;
if ( isset( $settings_updated ) ) {
    // add settings saved message with the class of "updated"
    add_settings_error( 'mpwizard_messages', 'mpwizard_message', __( 'Saved settings', 'mpwizard' ), 'updated' );
}

?>
<div class="wrap">
    <?php $img_path = MPWIZARD_PLUGIN_URL . 'assets/images/mpwizard-logo.png'; ?>
    <img class="mpwizard-logo" src="<?php echo esc_attr( $img_path ) ?>" />
    <h2 class="mpwizard-hidden">Messages</h2>
    <?php 
        // show messages
        settings_errors( 'mpwizard_messages' );
    ?>
    <!--<div class="mpwizard-header">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    </div>--> 
    <form action="options.php" method="post">
        <div class="mpwizard-settings-wrapper">
            <?php
            // output security fields for the registered setting "mpwizard"
            settings_fields( 'mpwizard' );
            // output setting sections and their fields
            // (sections are registered for "mpwizard", each field is registered to a specific section)
            do_settings_sections( 'mpwizard-settings' );
            ?>
        </div>
        <button type="submit" class="mpwizard-button mpwizard-button-md"><?php esc_html_e( 'Save settings', 'mpwizard' ) ?></button>      
    </form>
</div>