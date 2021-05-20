<?php
/**
 * Assign WP-User to Fancier.
 *
 * @link       http://emha.koeln
 * @since      0.1.1
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 */

/**
 * Assign WP-User to Fancier.
 *
 * This class assigns a WP-User to a Fancer.
 *
 * @since      0.1.1
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 * @author     emha.koeln <mheep@emha.koeln>
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

    
class Dovedevil_Admin_Assign
{

    protected $main;
    
    private $wp_user_id;

    
    /** Class constructor */
    public function __construct( $main )
    {
        $this->main = $main;
    }

    /**
     * 
     */
    public function current_action(){
        
        if (! empty($_REQUEST['action'])){
            return $_REQUEST['action'] ;
        }else{
            return '';
        }
    }
    
    public function display() {
            
        echo 'Action: ' . $this->current_action();
        
 
        var_dump($_REQUEST);

        if ( 'assign' === $this->current_action() ) {
            
           
            if (  ! wp_verify_nonce( $_POST['dovedevil_assign_nonce'], 'dovedevil_assign')   ) {
                die( 'Go get a life script kiddies' );
            }
            else {

                //echo 'we are in assing mode, go on';
                //var_dump($_REQUEST);
                $this->main->db->assign_fancier_to_wp_user_ID( $this->main->fancier, $_REQUEST['wp-user-id'] );
                
                // TODO? reload $this->main->fancier ?
            
            }
        }else{
            
            $this->display_assign();

        }
        
        //$this->display_assign();
        
    }
    
    public function display_assign( ) {
       
        ?>
        <div>   
            <form method="post" enctype="multipart/form-data">
            
            <?php 
                $this->main->fancier->display();
            
                $wp_users = get_users( array( 'role__in' => array( 'author', 'subscriber' ) ) );
                
                // TODO: set 'selected' to show courrent assign
            	//echo '<select name="' . $this->option_name . '_general_fancier' . '" id="' . $this->option_name . '_general_fancier' . '">';
                _e('Select user to assign:' , 'dovedevil');
                echo '<select name="wp-user-id" id="wp-user-id">';
            
                echo '<option value="0"></option>' ;
                foreach ( $wp_users as $wp_user){
                    echo '<option value="'. $wp_user->ID .'"' ;
        
                	  if ($this->main->fancier->wp_id == $wp_user->ID){
                	           echo ' selected';
                	  }
                    echo '>' . $wp_user->display_name . '</option>';
        	   }
        	   
        	   echo ' </select>';
        	   echo ' <br>';
            ?>
    
        	
              
 
              <input type="submit" id='' name="submit" value="Assign">
              <input type="hidden" id="action" name="action" value="assign">
              <?php wp_nonce_field( 'dovedevil_assign', 'dovedevil_assign_nonce' ); ?>
      		</form>
        	
        </div>
		<?php 
	}
	

		
    
}