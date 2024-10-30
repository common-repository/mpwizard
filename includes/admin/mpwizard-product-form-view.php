<?php

$mpwizard_credentials_mode = mpwizard_product_attr( get_option( 'mpwizard_credentials_mode' ) );

$mpwizard_actual_credentials_mode = isset( $mpwizard_product->credentials_mode ) ? mpwizard_product_attr( $mpwizard_product->credentials_mode ) : '';

//production mode vars
$mpwizard_preference_id_production = isset( $mpwizard_product->preference_id ) ? mpwizard_product_attr( $mpwizard_product->preference_id ) : '';
$mpwizard_init_point_production = isset( $mpwizard_product->init_point ) ? mpwizard_product_attr( $mpwizard_product->init_point ) : '';

//actual mode vars
$mpwizard_preference_id_test = isset( $mpwizard_product->preference_id_test ) ? mpwizard_product_attr( $mpwizard_product->preference_id_test ) : '';
$mpwizard_init_point_test = isset( $mpwizard_product->init_point_test ) ? mpwizard_product_attr( $mpwizard_product->init_point_test ) : '';

?>
<div class="wrap">
<?php $img_path = MPWIZARD_PLUGIN_URL . 'assets/images/mpwizard-logo.png'; ?>
  <img class="mpwizard-logo" src="<?php echo esc_url( $img_path ) ?>" />
  <h2 class="mpwizard-hidden">Messages</h2>
  <?php 
        // show messages
        settings_errors( 'mpwizard_messages' );
  ?>
  <div class="mpwizard-header">
    <h1><?php esc_html_e('Add new payment link', 'mpwizard'); ?> <a href="<?php menu_page_url('mpwizard-overview') ?>" class="mpwizard-button mpwizard-button-sm" ><?php esc_html_e('Back to list', 'mpwizard') ?></a></h1>
  </div>
    <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" class="mpwizard-form" id="mpwizard-btn-add-form" novalidate="novalidate">
    <fieldset id="mpwizard-fieldset">
        <div class="mpwizard-form-grid" id="mpwizard-btn-general-settings">
        <div>
              <label for="mpwizard-btn-title"><?php esc_html_e('Name', 'mpwizard') ?> <span class="mpwizard-required">*</span></label>
              <input type="text" class="mpwizard-long-text" name="mpwizard-btn-title" id="mpwizard-btn-title" value="<?php echo isset( $mpwizard_product->name ) ? esc_attr( $mpwizard_product->name ) : '' ?>" required="required">
              <span><?php esc_html_e('Product or service name', 'mpwizard') ?></span>
              
              <label for="mpwizard-btn-quantity"><?php esc_html_e('Quantity', 'mpwizard') ?> <span class="mpwizard-required">*</span></label>
              <input type="number" name="mpwizard-btn-quantity" id="mpwizard-btn-quantity" min="1" value="<?php echo isset( $mpwizard_product->quantity ) ? mpwizard_product_attr( $mpwizard_product->quantity ) : '1' ?>" required="required">
              <span><?php esc_html_e('Elements number of the product or service', 'mpwizard') ?></span>
              
              <label for="mpwizard-btn-price"><?php esc_html_e('Price', 'mpwizard') ?> <span class="mpwizard-required">*</span></label>
              <input type="number" min="0" step="0.01" name="mpwizard-btn-price" id="mpwizard-btn-price" value="<?php echo isset( $mpwizard_product->price ) ? mpwizard_product_attr( $mpwizard_product->price ) : '' ?>" required="required">
              <span><?php esc_html_e('Product or service price', 'mpwizard') ?></span>

              <!--<label for="mpwizard-btn-text"><?php esc_html_e('Button text', 'mpwizard') ?> <span class="mpwizard-required">*</span></label>
              <input type="text" name="mpwizard-btn-text" id="mpwizard-btn-text" value="<?php echo isset( $mpwizard_product->button_text ) ? mpwizard_product_attr( $mpwizard_product->button_text ) : esc_html__( 'Pay now', 'mpwizard' ) ?>" required="required">
              <span><?php esc_html_e('Button text. Example: Pay now', 'mpwizard') ?></span>-->
        </div>

        <div>
              <label for="mpwizard-btn-picture"><?php esc_html_e('Picture', 'mpwizard') ?></label>
              <button name="mpwizard-btn-picture" id="mpwizard-btn-picture"><img src="<?php echo isset( $mpwizard_product->picture_url ) && !empty( $mpwizard_product->picture_url ) ? esc_attr( $mpwizard_product->picture_url ) : MPWIZARD_PLUGIN_URL . 'assets/images/image-placeholder-2.png' ?>" id="mpwizard-btn-picture-img"></button>
              <input type="hidden" name="mpwizard-btn-picture-url" id="mpwizard-btn-picture-url" value="<?php echo isset( $mpwizard_product->picture_url ) ? esc_attr( $mpwizard_product->picture_url ) : '' ?>" >
              <a href="#" id="mpwizard-btn-clean-img"><?php esc_html_e('Delete', 'mpwizard') ?></a>
              <span><?php esc_html_e('Select the product or service picture', 'mpwizard') ?></span>

              <!--<label for="mpwizard-btn-desc"><?php esc_html_e('Description', 'mpwizard') ?></label>
              <textarea name="mpwizard-btn-desc" id="mpwizard-btn-desc" rows="3" class="mpwizard-long-text"><?php echo isset( $mpwizard_product->description ) ? esc_textarea( $mpwizard_product->description ) : '' ?></textarea>
              <span><?php esc_html_e('Product or service description', 'mpwizard') ?></span>-->
    
              <label for="mpwizard-btn-refnumber"><?php esc_html_e('Reference number', 'mpwizard') ?></label>
              <input type="text" name="mpwizard-btn-refnumber" id="mpwizard-btn-refnumber" value="<?php echo isset( $mpwizard_product->external_reference ) ? mpwizard_product_attr( $mpwizard_product->external_reference ) : '' ?>">
              <span><?php esc_html_e('Unique identification to recognize your product or service', 'mpwizard') ?></span>    
        </div>
        <div>
              <label for="mpwizard-btn-activationd"><?php esc_html_e('Start date', 'mpwizard') ?></label>
              <input type="date" name="mpwizard-btn-activationd" id="mpwizard-btn-activationd" value="<?php echo isset( $mpwizard_product->expiration_date_from ) ? mpwizard_product_attr( $mpwizard_product->expiration_date_from ) : '' ?>">
              <span><?php esc_html_e('Date when you can start using this product', 'mpwizard') ?></span>

              <label for="mpwizard-btn-expirationd"><?php esc_html_e('Due date', 'mpwizard') ?></label>
              <input type="date" name="mpwizard-btn-expirationd" id="mpwizard-btn-expirationd" value="<?php echo isset( $mpwizard_product->expiration_date_to ) ? mpwizard_product_attr( $mpwizard_product->expiration_date_to ) : '' ?>">
              <span><?php esc_html_e('Date this product ends', 'mpwizard') ?></span>

        </div>
        </div>

        <!--Hiden field for env preference_id and init_point -->
        <input type="hidden" name="preference_id_production" value="<?php echo esc_attr( $mpwizard_preference_id_production ) ?>">

        <input type="hidden" name="init_point_production" value="<?php echo esc_attr( $mpwizard_init_point_production ) ?>">

        <!--Hiden field for actual preference_id and init_point -->
        <input type="hidden" name="preference_id_test" value="<?php echo esc_attr( $mpwizard_preference_id_test ) ?>">

        <input type="hidden" name="init_point_test" value="<?php echo esc_attr( $mpwizard_init_point_test ) ?>">

        <!--Hiden field for actual_credentials_mode-->
        <input type="hidden" name="actual_credentials_mode" value="<?php echo esc_attr( $mpwizard_actual_credentials_mode ) ?>">
        
        <!--Hiden field for POST action-->
        <input type="hidden" name="action" value="add_mpwizard_button">

        <div class="mpwizard-form-footer">
         <button type="submit" id="mpwizard-btn-add-submmit"><?php isset( $mpwizard_product->name ) ? esc_html_e('Update', 'mpwizard') : esc_html_e('Register', 'mpwizard') ?></button>
         <span></span>
        </div>
      </fieldset>      
    </form>    
</div>
<!--Glogbal JS variables-->
<script type="text/javascript" >
  const mpwizardGCssUnitFontsize = <?php echo isset( $mpwizard_product->fontsize_unit) ? "'" . esc_js( $mpwizard_product->fontsize_unit ) . "'" : 'null'; ?>;
  const mpwizardGCssUnitLineHeight = <?php echo isset( $mpwizard_product->lineheight_unit) ? "'" . esc_js( $mpwizard_product->lineheight_unit ) . "'" : 'null'; ?>;
  const mpwizardGCssUnitBorderRadius = <?php echo isset( $mpwizard_product->borderradius_unit) ? "'" . esc_js( $mpwizard_product->borderradius_unit ) . "'" : 'null'; ?>;
  const mpwizardGCssUnitPadding = <?php echo isset( $mpwizard_product->padding_unit) ? "'" . esc_js( $mpwizard_product->padding_unit ) . "'" : 'null'; ?>;
</script>