<?php 

/**
 * Pigeons table.
 *
 * @link       http://emha.koeln
 * @since      0.1.1
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 */

/**
 * Pigeons Table.
 *
 * This class shows and handles the fanciers' pigeons.
 *
 * @since      0.1.1
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 * @author     emha.koeln <mheep@emha.koeln>
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

//if(!class_exists('WP_List_Table')){
//    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
//}
    
class Fancier_Pigeons_Table extends WP_List_Table
{
    /**
     * Store plugin main class to allow public access.
     *
     * @since    0.1.0
     * @var      object      The main class.
     */
    public $main;
    
    /**
     * The current fancier to be used 
     *
     * @since  	0.1.1
     * @access 	public
     * @var  	object 		
     */
    // TODO: Use main->fancier
    //public $admin_fancier;
    
    /**
     * The parser
     *
     * @since  	0.1.1
     * @access 	public
     * @var  	object
     */
    // TODO: Use main->parser // DONE?
    public $parser;
    
    /** Class constructor */
    public function __construct( $plugin_main )
    {

        // Set parent defaults.
        parent::__construct(array(
            'singular' => _x('pigeon', 'dovedevil'), // Singular name of the listed records.
            'plural' => _x('pigeons', 'dovedevil'), // Plural name of the listed records.
            'ajax' => false, // Does this table support ajax?
            ));
        
        $this->main = $plugin_main;
        
        add_action( 'admin_head', [ $this, 'admin_header']);
        
        //include_once 'class-dovedevil-fancier.php';
        //$this->admin_fancier = New Fancier();

        
    }
    
    /**
     *  Set css style of the pigeons_table
     */
    function admin_header() {
        $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
        
        //var_dump($page);
        
        if( 'dovedevil_pigeons_table' != $page )
            return;
            
            echo '<style type="text/css">';
            //echo '.wp-list-table .column-cb { width: 25%; }';
            echo '.wp-list-table .column-pigeon_ringnr { width: 30%; }';
            echo '.wp-list-table .column-pigeon_gender { width: 15%; }';
            //echo '.wp-list-table .column-isbn { width: 20%; }';
            echo '</style>';
    }
    
    /**
     * Retrieve customers data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed:NULL
     */
    public function get_pigeons( $per_page = 5, $page_number = 1 ) {
        
        global $wpdb;
        
        //$sql = "SELECT * FROM {$wpdb->prefix}dovedevil_pigeons";
        
        //var_dump($this->fancier);
        
        if ($this->main->fancier->isFancier){
        
            $sql = "SELECT * FROM {$wpdb->prefix}dovedevil_pigeons WHERE ";
            $sql .= "`club_nr` = " . $this->main->fancier->club_nr . " ";
            $sql .= "AND ";
            $sql .= "`fancier_nr` = " . $this->main->fancier->fancier_nr . " ";
            
            //echo $sql;
            
            if ( ! empty( $_REQUEST['orderby'] ) ) {
                $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
                $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
            }
            
            $sql .= " LIMIT $per_page";
            $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
            
            
            $result = $wpdb->get_results( $sql, 'ARRAY_A' );
            
            return $result;
        }else{
            return NULL;
        }
    }
    
    /**
     * Edit a pigeon record.
     *
     * @param int $id customer ID
     */
    public function edit_pigeon( $id ) {
        global $wpdb;
         
        $save_nonce = wp_create_nonce( 'dovedevil_save_pigeon' );
        
        $current_table = $wpdb->prefix . 'dovedevil_pigeons';
        
        $query = "SELECT * FROM  `" . $current_table .  "` WHERE `id` = ".$id ."";
 
        //TODO: result[0]
        $result = $wpdb->get_results( $query, 'ARRAY_A' );
        
        
        //var_dump($query);
        //var_dump($result);
        
        //var_dump($_POST);
        ?>
        <div id="poststuff">
        	<div id="post-body" class="metabox-holder columns-2">
        		<div id="post-body-content">
        			<div class="meta-box-sortables ui-sortable">
        				<form method="post">
                              	<input type="hidden" id="id" name="id" 
                              	 <?php echo 'value="'. $result[0]['id'] .'"';?>
                              	 >
                              	<input type="hidden" id="action" name="_wpnonce" 
                              	 <?php echo 'value="'. $save_nonce .'"';?>
                              	 >                              	
                              	
                              	<table>
                              	<tr>
                              	 <th>
                              	 </th>
                              	 <th>
                              		<?php _e('Land','dovedevil');?>
                              	 </th>
                              	 <th>
                              		<?php _e('Year','dovedevil');?>
                              	 </th>
                              	 <th>
                              		<?php _e('Club','dovedevil');?>
                              	 </th>
                              	 <th>
                              		<?php _e('Number','dovedevil');?>
                              	 </th>
                              	 </tr>
                              	 <tr>
                              	 <td>
                              	<label for="pigeon_ringnr">
                              		<?php _e('Pigeon RingNR','dovedevil');?>
                              	</label>
                              	</td>
                              	<td>
                              	<select id="pigeon_country" name="pigeon_country">
                                    <option value="DE"
                                    <?php 
                                        if($result[0]['pigeon_country'] === "DE"){
                                            echo ' selected';
                                        }
                                    ?>
                                    >DE</option>
                                    <option value="B"
                                    <?php 
                                        if($result[0]['pigeon_country'] === "B"){
                                            echo ' selected';
                                        }
                                    ?>
                                    >B</option>
                                    <option value="NL"
                                    <?php 
                                        if($result[0]['pigeon_country'] === "NL"){
                                            echo ' selected';
                                        }
                                    ?>
                                    >NL</option>
                                    <option value="PL"
                                    <?php 
                                        if($result[0]['pigeon_country'] === "PL"){
                                            echo ' selected';
                                        }
                                    ?>
                                    >PL</option>
                                </select>
                            
  								 </td>
  								   								 <td>
  								<input type="text" id="pigeon_year" name="pigeon_year" size="1" minlength="2" maxlength="2"
  								 <?php echo 'value="'. $result[0]['pigeon_year'] .'"';?>
  								 >
  								 </td>
  								 <td>
  								<input type="text" id="pigeon_club" name="pigeon_club" size="4"
  								<?php echo 'value="'. $result[0]['pigeon_club'] .'"';?>
  								 >
  								 </td>

  								 <td>
  								 <input type="text" id="pigeon_nr" name="pigeon_nr" size="2" maxlength="4"
  								  <?php echo 'value="'. $result[0]['pigeon_nr'] .'"';?>
  								  >
  								  </td>
  								  </tr>
  								</table>
  								
  								<label for="pigeon_gender">
  									<?php _e('Pigeon Gender','dovedevil');?>
  								</label>
  								<select id="pigeon_gender" name="pigeon_gender">
                                    <option value="M"
                                    <?php 
                                        if ($result[0]['pigeon_gender'] === "M"){
                                            echo ' selected';
                                        }
                                    ?>
                                    >
                                    <?php _e('Male','dovedevil');?>
                                    </option>
                                    <option value="F"
                                    <?php 
                                        if ($result[0]['pigeon_gender'] === "F"
                                            || $result[0]['pigeon_gender'] === "W" ){
                                            echo ' selected';
                                        }
                                    ?>
                                    >
                                    <?php _e('Female','dovedevil');?>
                                    </option>
                                </select>
  								 
  								 <br><br>
  								
  								<input type="submit" id="action" name="action" 
  								 <?php echo 'value="'. __('Save','dovedevil') .'"';?>
  								 >
  								<input type="hidden" id="action" name="action" value="save"> 
                            
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
        
		<?php 
		
		// DON'T DELETE IT BY NOW!
		
		//if ( empty($_POST)){
		//  exit();
		//}
    }
    
    /**
     * Save a pigeon record.
     *
     * @param int $id pigeon ID
     */
    public function save_pigeon( $id ) {
        global $wpdb;
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        
        $current_table = $wpdb->prefix . 'dovedevil_pigeons';
        
        if( strlen($_REQUEST['pigeon_nr']) < 4 ){
            $_REQUEST['pigeon_nr'] = str_pad($_REQUEST['pigeon_nr'], 4, "0", STR_PAD_LEFT);
        }
        
        $ringnr = $this->main->parser->build_ringnr($_REQUEST['pigeon_country'],
                                              $_REQUEST['pigeon_year'],
                                              $_REQUEST['pigeon_club'],
                                              $_REQUEST['pigeon_nr'],
                                              $_REQUEST['pigeon_gender']
                                              );
        
        // TODO: use DB class
        // UPDATE `wp_dovedevil_pigeons` SET `pigeon_gender` = '' WHERE `wp_dovedevil_pigeons`.`id` = 5; 
        $sql = "UPDATE `" . $current_table . "` ";
        $sql .= "SET ";
        $sql .= "`pigeon_country` = '" . $_REQUEST['pigeon_country'] ."' ";
        $sql .= ", `pigeon_year` = '" . $_REQUEST['pigeon_year'] ."' ";
        $sql .= ", `pigeon_club` = '" . $_REQUEST['pigeon_club'] ."' ";
        $sql .= ", `pigeon_nr` = '" . $_REQUEST['pigeon_nr'] ."' ";
        $sql .= ", `pigeon_gender` = '" . $_REQUEST['pigeon_gender'] ."' ";
        $sql .= ", `pigeon_ringnr` = '" . $ringnr ."' ";
        
        $sql .= "WHERE `id` = ".$id ."";
        
        dbDelta($sql);

    }
    
    /**
     * Delete a pigeon record.
     *
     * @param int $id pigeon ID
     */
    public static function delete_pigeon( $id ) {
        global $wpdb;
        
        $wpdb->delete(
            "{$wpdb->prefix}dovedevil_pigeons",
            [ 'id' => $id ],
            [ '%d' ]
        );
                 
    }
    
    
    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public function record_count() {
        global $wpdb;
        
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}dovedevil_pigeons";
        $sql .= " WHERE `club_nr` = '" . $this->main->fancier->club_nr . "'";
        $sql .= " AND `fancier_nr` = '" . $this->main->fancier->fancier_nr . "'";
        
        return $wpdb->get_var( $sql );
    }
    
    
    /** Text displayed when no customer data is available */
    public function no_items() {
        _e( 'No pigeons avaliable.', 'dovedevil' );
    }
    
    
    /**
     * Render a column when no column specific method exist.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'pigeon_ringnr':
                //return $item[ $column_name ];
            case 'pigeon_gender':
                //return $item[ $column_name ];
            case 'pigeon_country':
                //return $item[ $column_name ];
            case 'pigeon_year':
            case 'pigeon_club':
            case 'pigeon_nr':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }
    
    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
            );
        
    }
    
    
    /**
     * Method for pigeon_ringnr column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    
    function column_pigeon_ringnr( $item ) {
        
        $delete_nonce = wp_create_nonce( 'dovedevil_delete_pigeon' );
        $edit_nonce = wp_create_nonce( 'dovedevil_edit_pigeon' );
        
        $title = '<strong>' . $item['pigeon_ringnr'] . '</strong>';
        
        $actions = [
            //'sort' => sprintf( '<a href="?">'.__('Sort','dovedevil').'</a>'),
            'edit' => sprintf( '<a href="?page=%s&action=%s&pigeon=%s&_wpnonce=%s">'.__('Edit','dovedevil').'</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id'] ), $edit_nonce ),
            'delete' => sprintf( '<a href="?page=%s&action=%s&pigeon=%s&_wpnonce=%s">'.__('Delete','dovedevil').'</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
        ];
        
        return $title . $this->row_actions( $actions );
    }
    
    
    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns() {
        $columns = [
            'cb'      => '<input type="checkbox" />',
            'pigeon_ringnr'         => __( 'Ring Number', 'dovedevil' ),
            'pigeon_gender'         => __( 'Gender', 'dovedevil' ),
            'pigeon_country'         => __( 'Country', 'dovedevil' ),
            'pigeon_year'         => __( 'Year', 'dovedevil' ),
            'pigeon_club'         => __( 'Club', 'dovedevil' ),
            'pigeon_nr'         => __( 'Number', 'dovedevil' )
        ];
        
        return $columns;
    }
    
    
    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'pigeon_ringnr' => array( 'pigeon_ringnr', true ),
            'pigeon_gender' => array( 'pigeon_gender', false ),
            'pigeon_country'=> array( 'pigeon_country', false ),
            'pigeon_year'   => array( 'pigeon_year', false ),
            'pigeon_club'   => array( 'pigeon_club', false ),
            'pigeon_nr'     => array( 'pigeon_nr', false )
        );
        
        return $sortable_columns;
    }
    
    
    
    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = [
            'bulk-delete' => 'Delete'
        ];
        
        return $actions;
    }
    
    
    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {
        
        $this->_column_headers = $this->get_column_info();
        
        /** Process bulk action */
        $this->process_bulk_action();
        
        $per_page     = $this->get_items_per_page( 'pigeons_per_page', 25 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();
        
        $this->set_pagination_args( [
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ] );
 
        $this->items = self::get_pigeons( $per_page, $current_page );
       
    }
    
    
    
    
    public function process_bulk_action() {
        
        echo 'Action: ' . $this->current_action();
          
        //var_dump($_POST);
        
        //Detect when a bulk action is being triggered...
        if ( 'edit' === $this->current_action() 
             && !isset($_REQUEST['order'])   ) {
            
            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );
            
            //echo 'Bulk _wpnonce:' . esc_attr( $_REQUEST['_wpnonce']) . '<br>';
            
            //var_dump($_REQUEST);
            
            if ( ! wp_verify_nonce( $nonce, 'dovedevil_edit_pigeon' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::edit_pigeon( absint( $_GET['pigeon'] ) );
                
                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url
                //wp_redirect( esc_url_raw(add_query_arg()) );
                //exit;
            }
            
        }
        
        //Detect when a bulk action is being triggered...
        if ( 'save' === $this->current_action()
             && !isset($_REQUEST['order'])  ) {
            
            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );
            
           // echo 'Bulk _wpnonce:' . esc_attr( $_REQUEST['_wpnonce']) . '<br>';
           // echo 'Bulk _wpnonce:' . esc_attr( $_GET['_wpnonce']) . '<br>';
           // echo 'Bulk _wpnonce:' . esc_attr( $_POST['_wpnonce']) . '<br>';
            
            //echo 'Bulk $_REQUEST:<br>';
            //var_dump($_REQUEST);
            
            if ( ! wp_verify_nonce( $nonce, 'dovedevil_save_pigeon' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                
               
                $this->save_pigeon( absint( $_REQUEST['id']) );
                
                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url
                //wp_redirect( 'http://127.0.0.1/wp-admin/admin.php?page=dovedevil_pigeons_table' );
                //exit;        
                //$_REQUEST['action'] = '';
                //$_POST['action'] = '';
                //$_GET['action'] = '';
            }
            
        }
        
        //Detect when a bulk action is being triggered...
        if ( 'delete' === $this->current_action() 
             && !isset($_REQUEST['order'])) {
            
            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );
            
            //echo 'Bulk _wpnonce:' . esc_attr( $_REQUEST['_wpnonce']) . '<br>';
            
            if ( ! wp_verify_nonce( $nonce, 'dovedevil_delete_pigeon' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::delete_pigeon( absint( $_GET['pigeon'] ) );
                
                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url
                //wp_redirect( esc_url_raw(add_query_arg()) );
                //exit;
            }
            
        }
        
        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
            || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
            ) {
                
                $delete_ids = esc_sql( $_POST['bulk-delete'] );
                
                // loop over the array of record IDs and delete them
                foreach ( $delete_ids as $id ) {
                    self::delete_pigeon( $id );
                    
                }
                
                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url
                //wp_redirect( esc_url_raw(add_query_arg()) );
                //exit;
            }
    }

}
