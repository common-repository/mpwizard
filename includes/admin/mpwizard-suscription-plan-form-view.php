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
    <h1><?php esc_html_e('Add New Suscription Plan', 'mpwizard'); ?> <a href="<?php menu_page_url('mpwizard-overview') ?>" class="mpwizard-button mpwizard-button-sm" ><?php esc_html_e('Back to list', 'mpwizard') ?></a></h1>
  </div>
    <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" class="mpwizard-form" id="mpwizard-btn-add-form" novalidate="novalidate">
    <fieldset id="mpwizard-fieldset">
        <div class="mpwizard-form-grid" id="mpwizard-btn-general-settings">
        <div>
              <label for="mpwizard-btn-title"><?php esc_html_e('Plan name', 'mpwizard') ?> <span class="mpwizard-required">*</span></label>
              <input class="mpwizard-long-text" type="text" name="mpwizard-btn-title" id="mpwizard-btn-title" value="<?php echo isset( $mpwizard_product->name ) ? esc_attr( $mpwizard_product->name ) : '' ?>" required="required">
              <span><?php esc_html_e('Suscription plan name', 'mpwizard') ?></span>

              <label for="mpwizard-btn-price"><?php esc_html_e('Price', 'mpwizard') ?> <span class="mpwizard-required">*</span></label>
              <input type="number" name="mpwizard-btn-price" id="mpwizard-btn-price" value="<?php echo isset( $mpwizard_product->price ) ? mpwizard_product_attr( $mpwizard_product->price ) : '' ?>" required="required">
              <span><?php esc_html_e('Suscription plan price', 'mpwizard') ?></span>
              
              <label for="mpwizard-btn-frecuency"><?php esc_html_e('Billing frequency', 'mpwizard') ?> <span class="mpwizard-required">*</span></label>
              <select id="mpwizard-btn-frecuency" name="mpwizard-btn-frecuency">
                  <option value="weekly"><?php esc_html_e('Weekly', 'mpwizard') ?></option>
                  <option value="monthly"><?php esc_html_e('Monthly', 'mpwizard') ?></option>
                  <option value="annual"><?php esc_html_e('Annual', 'mpwizard') ?></option>
                  <option value="biweekly"><?php esc_html_e('Biweekly', 'mpwizard') ?></option>
                  <option value="bimonthly"><?php esc_html_e('Bimonthly', 'mpwizard') ?></option>
                  <option value="trimestral"><?php esc_html_e('Trimestral', 'mpwizard') ?></option>
                  <option value="quarterly"><?php esc_html_e('Quarterly', 'mpwizard') ?></option>
                  <option value="biannual"><?php esc_html_e('Biannual', 'mpwizard') ?></option>
              </select> 
              <span><?php esc_html_e('Billing frequency', 'mpwizard') ?></span>       
        </div>
        <div>
              <div>
                <label for="mpwizard-btn-suscr-dur"><?php esc_html_e( 'Subscription duration', 'mpwizard' )?></label>
                <span class="mpwizar-btn-style-option"><input type="radio" name="mpwizard-btn-suscr-dur" value="unlimited" <?php echo isset( $mpwizard_product->button_style ) ? checked( $mpwizard_product->button_style, 'mp', false ) : 'checked="checked"' ?> > <?php esc_html_e( 'Unlimited', 'mpwizard' )?></span>
                <span class="mpwizar-btn-style-option"><input type="radio" name="mpwizard-btn-suscr-dur" value="limited" <?php  if ( isset( $mpwizard_product->button_style ) )  { checked( $mpwizard_product->button_style, 'default' ); } ?> > <?php esc_html_e( 'Limited', 'mpwizard' )?></span>
              </div>
              <span><?php esc_html_e('Define how many charges you want to be made', 'mpwizard') ?></span>

              <label for="mpwizard-btn-acharge"><?php esc_html_e('Amount of charges', 'mpwizard') ?></label>
              <input type="number" name="mpwizard-btn-acharge" id="mpwizard-btn-acharge" min="1" value="<?php echo isset( $mpwizard_product->quantity ) ? mpwizard_product_attr( $mpwizard_product->quantity ) : '1' ?>" required="required">
              <span><?php esc_html_e('e.g. 12', 'mpwizard') ?></span>      

              <label for="mpwizard-btn-refnumber"><?php esc_html_e('Reference number', 'mpwizard') ?></label>
              <input type="text" name="mpwizard-btn-refnumber" id="mpwizard-btn-refnumber" value="<?php echo isset( $mpwizard_product->external_reference ) ? mpwizard_product_attr( $mpwizard_product->external_reference ) : '' ?>">
              <span><?php esc_html_e('Unique identification to recognize your product or service', 'mpwizard') ?></span> 
                
        </div>
        <div>
              <label for="mpwizard-btn-approurl"><?php esc_html_e('Approved payment URL', 'mpwizard') ?></label>
              <input class="mpwizard-long-text" type="url" name="mpwizard-btn-approurl" id="mpwizard-btn-approurl" value="<?php echo isset( $mpwizard_product->external_reference ) ? mpwizard_product_attr( $mpwizard_product->external_reference ) : '' ?>">
              <span><?php esc_html_e('After subscribing, the customer will be taken to this URL', 'mpwizard') ?></span> 
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