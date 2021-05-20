<?php

/**
 * The admin- and fancier-specific functionality of the plugin.
 *
 * @link       http://emha.koeln
 * @since      0.1.0
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/admin
 */

/**
 * The admin- and fancier-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/admin
 * @author     emha.koeln <mheep@emha.koeln>
 */


class Dovedevil_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	
	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	0.1.1
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'dovedevil';
	
	
	/**
	 * Store plugin main class to allow public access.
	 *
	 * @since    0.1.0
	 * @var      object      The main class.
	 */
	public $main;
	
	/**
	 * The Upload and Import things
	 *
	 * @since  	0.1.1
	 * @access 	private
	 * @var  	object 		$upload 	The Upload and Import things
	 */
	public $upload;
	
	/**
	 * Assign WP-User to Fancier
	 *
	 * @since  	0.1.1
	 * @access 	private
	 * @var  	object 	Assign WP-User to Fancier
	 */
	public $assign;
	

	
	/**
	 * The pigeons table to be used in this plugin
	 *
	 * @since  	0.1.1
	 * @access 	private
	 * @var  	object 		$option_name 	Option name of this plugin
	 */
	public $pigeons_table;
	//public $testListTable;
	
	/**
	 * Add pigeon 
	 *
	 * @since  	0.1.1
	 * @access 	private
	 * @var  	Dovedevil_Add_Pigeon $add_pigeon 	Add Pigeon
	 */
	public $add_pigeon;
	//public $testListTable;
	

	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string      $plugin_name       The name of this plugin.
	 * @param      string      $version    The version of this plugin.
	 * @param      $object     $plugin_main
	 */
	public function __construct( $plugin_name, $version, $plugin_main ) {

   
	    $this->main = $plugin_main;
	    
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dovedevil_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dovedevil_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dovedevil-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dovedevil_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dovedevil_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dovedevil-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**************************************************************************
	 *
	 *  Menues
	 *
	 **************************************************************************/
	
	/**
	 * Add menu and options page
	 *
	 * @since  0.1.1
	 */
	public function add_menu_page() {
	    
	    // *************************************************************
	    // Admin
	    
	    add_menu_page(
	        __( 'DoveDevil General', 'dovedevil' ),
	        __( 'DoveDevil', 'dovedevil' ),
	        'manage_options',
	        $this->plugin_name,
	        array( $this, 'display_options_page' ),
	        //'',
	        $this->main->url .'images/icon_settings20.png',
	        //'',
	        3
	        );
	    
	    
	    
	    add_submenu_page(
	        $this->plugin_name,
	        __( 'DoveDevil Club', 'dovedevil' ),
	        __( 'Club', 'dovedevil' ),
	        'manage_options',
	        $this->plugin_name . '_club',
	        array( $this, 'display_club_page' ),
	        3
	        );
	    
	    
	    add_submenu_page(
	        $this->plugin_name,
	        __( 'DoveDevil Assign', 'dovedevil' ),
	        __( 'Assign', 'dovedevil' ),
	        'manage_options',
	        $this->plugin_name . '_assign',
	        array( $this, 'display_assign_page' ),
	        5
	        );
	    
	    add_submenu_page(
	        $this->plugin_name,
	        __( 'DoveDevil Import', 'dovedevil' ),
	        __( 'Import', 'dovedevil' ),
	        'manage_options',
	        $this->plugin_name . '_import',
	        array( $this, 'display_import_page' ),
	        5
	        );
	    
	    // Remove double Top and Sub
	    remove_submenu_page($this->plugin_name,$this->plugin_name);
	    
	    // *************************************************************
	    // Fanciers Admin
	    
	    $fancier = add_menu_page(
    	     __( 'DoveDevil Fancier', 'dovedevil' ),
    	     __( 'DoveDevil', 'dovedevil' ),
    	     'publish_posts',
    	     $this->plugin_name .'_fancier',
    	     array( $this, 'display_fancier_page' ),
    	     //'',
    	     $this->main->url .'images/icon20.png',
    	     //'',
    	     3
	     );
	    add_action( "load-$fancier", [ $this, 'screen_option_fancier' ] );
	    
	    $pigeons = add_submenu_page(
	        $this->plugin_name.'_fancier',
	        __( 'DoveDevil Pigeons Table', 'dovedevil' ),
	        __( 'Pigeons Table', 'dovedevil' ),
	        'publish_posts',
	        $this->plugin_name .'_pigeons_table',
	        array( $this, 'display_pigeons_table_page' ),
	        9
	    );
	    add_action( "load-$pigeons", [ $this, 'screen_option_pigeons' ] );
	    
	    add_submenu_page(
	        $this->plugin_name.'_fancier',
	        __( 'DoveDevil Add Pigeon', 'dovedevil' ),
	        __( 'Add Pigeon', 'dovedevil' ),
	        'publish_posts',
	        $this->plugin_name .'_pigeons_add',
	        array( $this, 'display_pigeons_add_page' ),
	        11
	        );
	    // Remove double Top and Sub
	    remove_submenu_page($this->plugin_name .'_fancier', $this->plugin_name .'_fancier');
	}
	
	public static function set_screen( $status, $option, $value ) {
	    return $value;
	}
	
	/**
	 * Screen options fancier
	 */
	public function screen_option_fancier() {
	    
	    // TODO: different structur (pigeons-table)
	    
	    //$option = 'DEBUG';
	    //$args   = [
	    //    'label'   => __('DEBUG', 'dovedevil'),
	    //   'default' => 0,
	    //    'option'  => 'DEBUG'
	    //];
	    //add_screen_option( $option, $args );
	  	  	    
	    //include_once 'class-dovedevil-fancier.php';
	    //$this->fancier = New Fancier();
	}
	
	/**
	 * Screen options pigeons
	 */
	public function screen_option_pigeons() {
	    
	    $option = 'per_page';
	    $args   = [
	        'label'   => __('Pigeons', 'dovedevil'),
	        'default' => 5,
	        'option'  => 'pigeons_per_page'
	    ];
	    add_screen_option( $option, $args );
   
	    include_once 'class-dovedevil-fancier-pigeons-table.php';
	    $this->pigeons_table = New Fancier_Pigeons_Table( $this->main );
	    //$this->pigeons_table->fancier->set_fancier_by_wp_id(get_current_user_id());
    
	}
	
	/**************************************************************************
	 *
	 *  Display
	 *
	 **************************************************************************/
	
	/**
	 * Render the options page for plugin
	 *
	 * @since  0.1.1
	 */
	public function display_options_page() {
	    
	    include_once 'partials/dovedevil-admin-display.php';
    
	}
	
	/**
	 * Render the clubs page for plugin
	 *
	 * @since  0.1.1
	 */
	public function display_club_page() {
	    
	    include_once 'partials/dovedevil-admin-club-display.php';
	    
	}
	
	
	/**
	 * Render the assign page for plugin
	 *
	 * @since  0.1.1
	 */
	public function display_assign_page() {
	    
	    $this->main->fancier->set_fancier_by_wp_id(get_current_user_id());
	    
	    include_once 'class-dovedevil-admin-assign.php';
	    $this->assign = new Dovedevil_Admin_Assign( $this->main );
	    
	    include_once 'partials/dovedevil-admin-assign-display.php';
	    
	}
	
	/**
	 * Render the import page for plugin
	 *
	 * @since  0.1.1
	 */
	public function display_import_page() {
	    
	    $this->main->fancier->set_fancier_by_wp_id(get_current_user_id());
	    
	    include_once 'class-dovedevil-admin-import.php';
	    $this->import = new Dovedevil_Admin_Import( $this->main );
	    
	    include_once 'partials/dovedevil-admin-import-display.php';
	    
	}
	
	/**
	 * Render the fancier page for plugin
	 *
	 * @since  0.1.1
	 */
	public function display_fancier_page() {
	    
	    $this->main->fancier->set_fancier_by_wp_id(get_current_user_id());
	    
	    if (  $this->main->fancier->isFancier){
	        
	    }else{
	        
	        $this->main->fancier->display();
	        exit();
	    }
	    
	    include_once 'partials/dovedevil-fancier-display.php';
	}
	
	
	/**
	 * Render the pigeons page for plugin
	 *
	 * @since  0.1.1
	 */
	public function display_pigeons_page() {
	    include_once 'partials/dovedevil-pigeons-display.php';
	}
	
	/**
	 * Render the pigeons table page for plugin
	 *
	 * @since  0.1.1
	 */
	public function display_pigeons_table_page() {
	    
	    $this->main->fancier->set_fancier_by_wp_id(get_current_user_id());
	    //$this->pigeons_table->admin_fancier = $this->admin_fancier; //->set_fancier_by_wp_id(get_current_user_id());
	    
	    if ( $this->main->fancier->isFancier){
	        
	    }else{
	        $this->main->fancier->display();
	        exit();
	    }
	    
	    include_once 'partials/dovedevil-fancier-pigeons-table-display.php';
	}
	
	/**
	 * Render the pigeons add page for plugin
	 *
	 * @since  0.1.1
	 */
	public function display_pigeons_add_page() {
	    
	    $this->main->fancier->set_fancier_by_wp_id(get_current_user_id());
	    
	    include_once 'class-dovedevil-fancier-add-pigeon.php';
        $this->add_pigeon = New Dovedevil_Add_Pigeon( $this->main );

	    if ( $this->main->fancier->isFancier){
	        
	    }else{

	        $this->main->fancier->display();
	        exit();
	    }
	   
	    
	    include_once 'partials/dovedevil-fancier-pigeon-add-display.php';
	}
	
	/**
	 * Render the pigeons edit page for plugin
	 *
	 * @since  0.1.1
	 */
	/*
	public function display_pigeons_edit_page() {
	    include_once 'partials/dovedevil-pigeons-edit-display.php';
	}
	*/
	
	/**************************************************************************
	 *
	 *  Settings
	 *
	 **************************************************************************/
	
	/**
	 * Register all related settings of this plugin
	 *
	 * @since  0.1.1
	 */
	public function register_setting() {
	    
	    // *************************************************************
	    // General
	    add_settings_section(
	        $this->option_name . '_general',
	        __( 'General', 'dovedevil' ),
	        array( $this, $this->option_name . '_general_cb' ),
	        $this->plugin_name . '_general'
	        );
	    
  
	    // *************************************************************
	    // General Club Settings
	    
	    add_settings_section(
	        $this->option_name . '_club',
	        __( 'Club', 'dovedevil' ),
	        array( $this, $this->option_name . '_club_cb' ),
	        $this->plugin_name .'_club'
	        );
	    /*
	    add_settings_field(
	        $this->option_name . '_position',
	        __( 'Text position', 'dovedevil' ),
	        array( $this, $this->option_name . '_position_cb' ),
	        $this->plugin_name . '_club',
	        $this->option_name . '_club',
	        array( 'label_for' => $this->option_name . '_position' )
	        );
	    */
	    add_settings_field(
	        $this->option_name . '_federation_name',
	        __( 'Federation Name', 'dovedevil' ),
	        array( $this, $this->option_name . '_federation_name_cb' ),
	        $this->plugin_name . '_club',
	        $this->option_name . '_club',
	        array( 'label_for' => $this->option_name . '_federation_name' )
	        );
	    register_setting( $this->plugin_name .'_club' , $this->option_name . '_federation_name', 'federation-name' );
	    
	    add_settings_field(
	        $this->option_name . '_federation_reg',
	        __( 'Federation Reg', 'dovedevil' ),
	        array( $this, $this->option_name . '_federation_reg_cb' ),
	        $this->plugin_name . '_club',
	        $this->option_name . '_club',
	        array( 'label_for' => $this->option_name . '_federation_reg' )
	        );
	    register_setting( $this->plugin_name .'_club' , $this->option_name . '_federation_reg', 'federation-reg' );
	    
	    add_settings_field(
	        $this->option_name . '_federation_rv',
	        __( 'Federation RV', 'dovedevil' ),
	        array( $this, $this->option_name . '_federation_rv_cb' ),
	        $this->plugin_name . '_club',
	        $this->option_name . '_club',
	        array( 'label_for' => $this->option_name . '_federation_rv' )
	        );
	    register_setting( $this->plugin_name .'_club' , $this->option_name . '_federation_rv', 'federation-rv' );
	    
	    //register_setting( $this->plugin_name .'_club' , $this->option_name . '_position', array( $this, $this->option_name . '_sanitize_position' ) );

	    // *************************************************************
	    // General Assign Settings
	    
	    add_settings_section(
	        $this->option_name . '_assign',
	        __( 'Assign', 'dovedevil' ),
	        array( $this, $this->option_name . '_assign_cb' ),
	        $this->plugin_name .'_assign'
	        );
	    
	    
	    add_settings_field(
	        $this->option_name . '_assign_fancier',
	        __( 'Fancier to simulate', 'dovedevil' ),
	        array( $this, $this->option_name . '_assign_fancier_cb' ),
	        $this->plugin_name . '_assign',
	        $this->option_name . '_assign',
	        array( 'label_for' => $this->option_name . '_assign_fancier' )
	        );
	    register_setting( $this->plugin_name .'_assign' , $this->option_name . '_assign_fancier', 'assign-fancier' );
	    
	    
	    
	    
	    // *************************************************************
	    // Fanciers
	    
	    // not used by now
	    
	    add_settings_section(
	        $this->option_name . '_fancier',
	        __( 'Fancier', 'dovedevil' ),
	        array( $this, $this->option_name . '_fancier_cb' ),
	        $this->plugin_name . '_fancier'
	        );
	    
	    add_settings_field(
	        $this->option_name . '_fancier_name',
	        __( 'Fancier Name', 'dovedevil' ),
	        array( $this, $this->option_name . '_fancier_name_cb' ),
	        $this->plugin_name . '_fancier',
	        $this->option_name . '_fancier',
	        array( 'label_for' => $this->option_name . '_fancier_name' )
	        );
	    register_setting( $this->plugin_name. '_fancier' , $this->option_name . '_fancier_name', 'fancier-name' );
	    
	    // Pigeons
	    add_settings_section(
	        $this->option_name . '_pigeons',
	        __( 'Pigeons', 'dovedevil' ),
	        array( $this, $this->option_name . '_pigeons_cb' ),
	        $this->plugin_name . '_pigeons'
	        );
	    
	    add_settings_field(
	        $this->option_name . '_pigeons_name',
	        __( 'Pigeons Name', 'dovedevil' ),
	        array( $this, $this->option_name . '_pigeons_name_cb' ),
	        $this->plugin_name . '_pigeons',
	        $this->option_name . '_pigeons',
	        array( 'label_for' => $this->option_name . '_pigeons_name' )
	        );
	    register_setting( $this->plugin_name. '_pigeons' , $this->option_name . '_pigeons_name', 'pigeons-name' );
	    
	    
	}
	
	
	/**************************************************************************
	 * 
	 *  Render callbacks
	 * 
	 **************************************************************************/
	
	/**************************************************************************
	 *
	 *  General
	 */
	
	/**
	 * Render the text for the general section
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_general_cb() {
	    //echo $this->option_name;
	    echo '<p>' . __( 'Welcome to DoveDevil.', 'dovedevil' ) . '</p>';
	}
	
	
	
	
	/**
	 * Render the text for the generaö fancier section
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_club_cb() {
	    echo '<p>' . __( 'Club.', 'dovedevil' ) . '</p>';
	}
	
	/**
	 * Render the radio input field for position option
	 *
	 * @since  0.1.1
	 */
	/*
	public function dovedevil_position_cb() {
	    $position = get_option( $this->option_name . '_position' );
	    ?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_position' ?>" id="<?php echo $this->option_name . '_position' ?>" value="before" <?php checked( $position, 'before' ); ?>>
					<?php _e( 'Before the content', 'dovedevil' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_position' ?>" value="after" <?php checked( $position, 'after' ); ?>>
					<?php _e( 'After the content', 'dovedevil' ); ?>
				</label>
			</fieldset>
		<?php
	}
    */
	
    /**
	 * Render the _federation_name input for this plugin
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_federation_name_cb() {
		$myoption = get_option( $this->option_name . '_federation_name' );
		echo '<input type="text" name="' . $this->option_name . '_federation_name' . '" id="' . $this->option_name . '_federation_name' . '" value="' . $myoption . '"> ';
	}
	
	/**
	 * Render the _federation_reg input for this plugin
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_federation_reg_cb() {
	    $myoption = get_option( $this->option_name . '_federation_reg' );
	    echo '<input type="text" name="' . $this->option_name . '_federation_reg' . '" id="' . $this->option_name . '_federation_reg' . '" value="' . $myoption . '"> ';
	}
	
	/**
	 * Render the _federation_rv input for this plugin
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_federation_rv_cb() {
	    $myoption = get_option( $this->option_name . '_federation_rv' );
	    echo '<input type="text" name="' . $this->option_name . '_federation_rv' . '" id="' . $this->option_name . '_federation_rv' . '" value="' . $myoption . '"> ';
	}

	/**
	 * Sanitize the text position value before being saved to database
	 *
	 * @param  string $position $_POST value
	 * @since  0.1.1
	 * @return string           Sanitized value
	 */
	public function dovedevil_sanitize_position( $position ) {
		if ( in_array( $position, array( 'before', 'after' ), true ) ) {
	        return $position;
	    }
	}
	
	
	/**
	 * Render the text for the generaö fancier section
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_assign_cb() {
	    echo '<p>' . __( 'Assign Fanciers.', 'dovedevil' ) . '</p>';
	}
	
	/**
	 * Render the _federation_name input for this plugin
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_assign_fancier_cb() {
	    $myoption = get_option( $this->option_name . '_assign_fancier' );
	    //echo '<input type="text" name="' . $this->option_name . '_general_fancier' . '" id="' . $this->option_name . '_general_fancier' . '" value="' . $myoption . '"> ';
	    
	    $ary = $this->main->db->get_fanciers();
	    //var_dump($ary);
	    echo '<select name="' . $this->option_name . '_assign_fancier' . '"
                        id="' . $this->option_name . '_assign_fancier' . '">';
	    
	    foreach ( $ary as $fancier){
	        echo '<option value="'. $fancier['id'] .'"' ;
	        
	        if ($fancier['id'] == $myoption){
	            echo ' selected';
	        }
	        echo '>' . $fancier['fancier_name'] . '</option>';
	    }
	    
	    echo ' </select>';
	    
	    //echo '<input type="text" name="' . $this->option_name . '_general_fancier' . '" id="' . $this->option_name . '_general_fancier' . '" value="' . $myoption . '"> ';
	    
	    //var_dump($ary);
	    
	}
	
	/**
	 * Render the text for the genera import section
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_import_cb() {
	    echo '<p>' . __( 'Import', 'dovedevil' ) . '</p>';
	}
	
	/**************************************************************************
	 *
	 *  Fancier
	 */
	
	/**
	 * Render the text for the fancier section
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_fancier_cb() {
	    echo '<p>' . __( 'Fancier.', 'dovedevil' ) . '</p>';
	}
	
	/**
	 * Render the fancier name input for this plugin
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_fancier_name_cb() {
	    $myoption = get_option( $this->option_name . '_fancier_name' );
	    echo '<input type="text" name="' . $this->option_name . '_fancier_name' . '" id="' . $this->option_name . '_fancier_name' . '" value="' . $myoption . '"> ' ;
	}
	
	/**
	 * Render the text for the pigeons section
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_pigeons_cb() {
	    echo '<p>' . __( 'Pigeons.', 'dovedevil' ) . '</p>';
	}
	
	/**
	 * Render the pigeons name input for this plugin
	 *
	 * @since  0.1.1
	 */
	public function dovedevil_pigeons_name_cb() {
	    $myoption = get_option( $this->option_name . '_pigeons_name' );
	    echo '<input type="text" name="' . $this->option_name . '_pigeons_name' . '" id="' . $this->option_name . '_pigeons_name' . '" value="' . $myoption . '"> ' ;

	}
	
	
}
