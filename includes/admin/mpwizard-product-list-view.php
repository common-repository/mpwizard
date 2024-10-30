<?php
  
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
    <h1><?php esc_html_e( 'My payment links', 'mpwizard' ) ?> <a href="<?php menu_page_url('mpwizard-add-button') ?>" class="mpwizard-button mpwizard-button-sm" ><?php esc_html_e('Add new', 'mpwizard') ?></a></h1>
    </div>
    <form method="post">
    <?php 
       $mpwizard_buttons_table = new MPWizard_Links_Table();
       $mpwizard_buttons_table->prepare_items(); 
       $mpwizard_buttons_table->search_box( __( 'Find', 'mpwizard' ), 'find-box');
       $mpwizard_buttons_table->display(); 
       ?>
    </form>
  </div>
