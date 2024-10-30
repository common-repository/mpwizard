<?php

/**
 * Generate the table on the plugin overview page.
 *
 * @since 1.0.0
 */
class MPWizard_Links_Table extends WP_List_Table {

	/**
	 * Number of forms to show per page.
	 *
	 * @since 1.0.0
	 *
	 * @var int
	 */
	public $per_page;
		
	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 * 
	 */
	public function __construct() {

		// Utilize the parent constructor to build the main class properties.
		parent::__construct(
			array(
				'singular' => 'button',
				'plural'   => 'buttons',
				'ajax'     => false
			)
		);

		// Default number of forms to show per page.
		$this->per_page = 9;
	}

	/**
	 * Retrieve table data.
	 *
	 * @since 1.0.0
	 * 
	 */
	public function table_data()
	{
		$post_data = array();

		$loop = mpwizard_get_posts();
      
        while ( $loop->have_posts() ) {
      
          $loop->the_post();

		  $post_content = \json_decode( get_the_content() );

		  //get credentials mode
		  if( get_option('mpwizard_credentials_mode') === 'test') {
			$init_point	=	isset( $post_content->init_point_test ) && !empty( $post_content->init_point_test) ? $post_content->init_point_test : '#';
		  } else {
			$init_point	=	isset( $post_content->init_point ) && !empty( $post_content->init_point) ? $post_content->init_point : '#';
		  }

		  array_push($post_data, ['ID' => get_the_id(), 'button_name' => get_the_title(), 'shortcode' => get_the_id(), 'payment_link' => $init_point, 'created' => get_the_date( 'c' )]);  
    
        }

		return $post_data;

	}

	/**
	 * Retrieve the table columns.
	 *
	 * @since 1.0.0
	 * 
	 */
	public function get_columns() {

		$columns = array(
			'cb' => '<input type="checkbox" />',
			'button_name' => esc_html__( 'Name', 'mpwizard' ),
			'payment_link' =>	esc_html__( 'Payment link', 'mpwizard' ),
			'created'   => esc_html__( 'Created', 'mpwizard' )
		);

		return $columns;
	}

	/**
	 * Define sortable columns.
	 *
	 * @since 1.0.0
	 * 
	 */
	function get_sortable_columns() {
		$sortable_columns = array(
		  'button_name' => array( 'button_name',false ),
		  'created' => array( 'created', false )
		);
		return $sortable_columns;
	}

	/**
	 * Retrieve the table columns.
	 *
	 * @since 1.0.0
	 * 
	 */
	function usort_reorder( $a, $b ) {
		
		// Si no se especifica columna, por defecto la fecha
		$orderby = ( isset( $_GET['orderby'] ) && ! empty( sanitize_text_field( $_GET['orderby'] ) ) ) ? sanitize_text_field( $_GET['orderby'] ) : 'created';

		// Si no hay orden, por defecto descendente
		$order = ( isset( $_GET['order'] ) && ! empty( sanitize_text_field( $_GET['order'] ) ) ) ? sanitize_text_field( $_GET['order'] ) : 'desc';

		// Determina el orden de ordenamiento
		$result = strnatcmp( $a[$orderby], $b[$orderby] );

		// Envía la dirección de ordenamiento final a usort
		return ( $order === 'asc' ) ? $result : -$result;

	}

	/**
	 * Process bulk actions.
	 *
	 * @since 1.0.0
	 * 
	 */
	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {
		
		// In our file that handles the request, verify the nonce.
		$nonce = sanitize_text_field( $_REQUEST['_wpnonce'] );
		
		if ( ! wp_verify_nonce( $nonce, 'mpwizard_delete_product' ) ) {
			die( __( 'Invalid access', 'mpwizard' ) );
		}
		else {
		self::delete_product( absint( sanitize_text_field( $_GET['product'] ) ) );
		wp_redirect( esc_url( add_query_arg([]) ) );
		exit;
		}
		
		}

		$action	=	isset( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : null;

		$action2	=	isset( $_POST['action2'] ) ? sanitize_text_field( $_POST['action2'] ) : null;
		
		// If the delete bulk action is triggered
		if( isset( $_POST['bulk-action'] ) && ( $action == 'bulk-delete' || $action2 == 'bulk-delete' ) ) {

			$bulk_action	=	$_POST['bulk-action'];

			if( is_array( $bulk_action ) ) {

				foreach( $bulk_action as $key	=>	$value) {

					$bulk_action[ $key ]	=	sanitize_text_field( $value );
					
				}

			} else{

				$bulk_action	=	sanitize_text_field( $bulk_action );

			}
			

		$delete_ids = esc_sql( $bulk_action );
		
		// loop over the array of record IDs and delete them
		foreach ( $delete_ids as $id ) {	
			self::delete_product( $id );
		}
		//wp_redirect( esc_url( add_query_arg([]) ) );

		$url = esc_url( add_query_arg([]) );
		echo '<meta http-equiv="refresh" content="0;url= ' . $url . '" />';//TODO escape
		exit;
		}

	}

	/**
	 * Fetch and setup the final data for the table.
	 *
	 * @since 1.0.0
	 * 
	 */
	function prepare_items() { 

		// check if a search was performed.

		$sanitized_search	=	isset( $_REQUEST['s'] ) ? sanitize_text_field( $_REQUEST['s'] ) : '';
		
		$user_search_key = wp_unslash( trim( $sanitized_search ) );

		$columns = $this->get_columns();

		$hidden = array();//$this->get_hidden_columns(); 

		$sortable = $this->get_sortable_columns(); 

		$table_data = $this->table_data();

		// filter the data in case of a search
		if( $user_search_key ) {
			$table_data = $this->filter_table_data( $table_data, $user_search_key );
		}	

		usort( $table_data, array( &$this, 'usort_reorder' ) );

		$total_items = count($table_data);

		//var_dump($total_items);

		$current_page = $this->get_pagenum();

		$this->set_pagination_args( array(
            'total_items' => $total_items,
            'per_page'    => $this->per_page
        ) );

		/** Process bulk action */
		$this->process_bulk_action();

		$table_data = array_slice($table_data,(($current_page-1) * $this->per_page), $this->per_page);

		$this->_column_headers = array( $columns ,$hidden , $sortable );

		$this->items = $table_data;

	} 

	/**
	 * Render the columns.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $button        Item data.
	 * @param string  $column_name Column Name.
	 *
	 * @return string
	 */
	public function column_default( $button, $column_name ) {

		switch ( $column_name ) {
			case 'button_name':
				$value = $button[ $column_name ];
				break;

			case 'payment_link':
				$value = '<span  data-post-id="'. $button[ 'shortcode' ] .'" data-content="' . $button[ $column_name ] . '">' . 'https://www.mercado...' . ' <a href="#" class="mpwizard-ip-copy">' . esc_html__( 'Copy', 'mpwizard' ) . '</a>' . '</span>';
				break;

			case 'created':
				$value = date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $button[ $column_name ] ) );
				break;

				default:
				return print_r( $item, true ) ;
		}

		return $value;
	}

	/**
	* Delete a product.
	*
	* @param int $id Product ID
	*
	* @return mixed
	*/
	public static function delete_product( $id ) {

		return wp_delete_post( $id, true );

	}

	/**
	* Render row actions.
	*
	* @param int $item Item data
	*
	* @return string
	*/
	function column_button_name( $item ) {

		// create delete nonce
		$delete_nonce = wp_create_nonce( 'mpwizard_delete_product' );

		$actions = array(
				  'edit'      => sprintf('<a href="?page=mpwizard-add-button&id=%s">%s</a>',$item['ID'], esc_html__('Edit', 'mpwizard') ),
				  'delete'    => sprintf('<a class="mpwizard-delete-product" href="?page=%s&action=%s&product=%s&_wpnonce=%s"data-product-id="%s">%s</a>', sanitize_text_field( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce, absint( $item['ID'] ),  esc_html__( 'Delete', 'mpwizard' ) )
			  );
	  
		return sprintf('%1$s %2$s', $item['button_name'], $this->row_actions( $actions ) );
	}

	/**
	 * Define bulk actions available for our table listing.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = [
		'bulk-delete' => esc_html__( 'Delete', 'mpwizard' )
		];

		return $actions;
	}

	/**
	 * Render the checkbox column.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $item Item data.
	 *
	 * @return string
	 */
	function column_cb($item) {
		return sprintf(
			   '<input type="checkbox" name="bulk-action[]" value="%s" />', $item['ID']
			   );    
	}



	/**
	 * Filter the table data based on the search key.
	 *
	 * @since 1.0.7
	 *
	 * @param $table_data Table data.
	 * @param $search_key Search ey.
	 *
	 * @return array
	 */
	public function filter_table_data( $table_data, $search_key ) {
		$filtered_table_data = array_values( array_filter( $table_data, function( $row ) use( $search_key ) {
			foreach( $row as $row_val ) {
				if( stripos( $row_val, $search_key ) !== false ) {
					return true;
				}				
			}			
		} ) );

		return $filtered_table_data;

	}

}