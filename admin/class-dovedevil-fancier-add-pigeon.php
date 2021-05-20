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

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

    
class Dovedevil_Add_Pigeon
{
    /**
     * Store plugin main class to allow public access.
     *
     * @since    0.1.1
     * @var      Dovedevil  The main class.
     */
    public $main;
    public $parser;
    
    // fancier (TODO replace with $fancier)
    public $club_nr;                // 01               Verein
    public $fancier_nr;             // 002              lfd
    /**
     * fancier.
     *
     * @since    0.1.1
     * @var      Dovedevil_Fancier  The Fancier.
     */
    public $fancier;
    
    // pigeon (TODO: replace with $pigeon)
    public $pigeon_country;
    public $pigeon_year;
    public $pigeon_club;
    public $pigeon_nr;
    public $pigeon_gender;
    public $pigeon_ringnr;
    public $isPigeon;
    /**
     * A pigeon.
     *
     * @since    0.1.1
     * @var      Dovedevil_Pigeon  The Pigeon.
     */
    public $pigeon;
    
    
    
    /** Class constructor */
    public function __construct( $plugin_main )
    {
        
        $this->main = $plugin_main;
        
        include_once $this->main->path . 'includes/class-dovedevil-pigeon.php';
        $this->pigeon = new Dovedevil_Pigeon();
    }
    
    /*
    public function set_fancier( $fancier){
        $this->fancier = $fancier;
    }
    
    public function set_parser( $parser){
        $this->parser = $parser;
    }
    */
    
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
    
    /**
     * Save a pigeon record.
     *
     * @param int $id pigeon ID
     */
    public function save_pigeon( $id, 
                                 $country,
                                 $year,
                                 $club,
                                 $nr,
                                 $gender ) {
        
                                     
        //Test
        //$pigeon = new Dovedevil_Pigeon();
        $this->pigeon->fancier =$this->main->fancier;
        $this->pigeon->isPigeon = TRUE; 
        $this->pigeon->pigeon_country =  $country;
        $this->pigeon->pigeon_year =  $year;
        $this->pigeon->pigeon_club =  $club;
        $this->pigeon->pigeon_nr =  $nr;
        $this->pigeon->pigeon_gender =  $gender;
        $this->pigeon->pigeon_ringnr = $this->main->parser->build_ringnr($country, $year, $club, $nr, $gender);
 
        $this->main->db->save_dd_pigeon( $this->pigeon );
                                     
       
        
        $this->set_pigeon_by_ringnr($this->pigeon->pigeon_ringnr);
        if ($this->isPigeon){
            echo '<div>';
                echo '<h2>';
                    echo '' . $this->pigeon_ringnr . ' ';
                    //echo '<br>';
                    //echo '' . $this->pigeon_gender . ' ';
                    //echo '<br>';
                echo '</h2>';
            echo '</div>';
        }else{
            echo '<div>';
            echo '<h2>';
            _e( 'Save failed!', 'dovedevil');
            //echo '<br>';
            //echo '<br>';
            echo '</h2>';
            echo '</div>';
        }
        
        
    }
    
    
    /**
     * Retrieve pigeon data from the database
     *
     * @param int $id pigeon id
     *
     * @return TRUE:FALSE
     */
    public function set_pigeon_by_id( $id ) {
        
        global $wpdb;
        
        $sql = "SELECT * FROM {$wpdb->prefix}dovedevil_pigeons WHERE `id` = " . $id;
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        //echo $sql;
        //echo __FILE__ . ': $result_fancier'; 
        //var_dump($result_fancier);
        
        if ( ! empty($result)){
            
            $this->isPigeon = TRUE;
            
            $this->club_nr = $result[0]['club_nr'];               // 01               Verein
         
            $this->fancier_nr = $result[0]['fancier_nr'];            // 002              lfd
           
            $this->pigeon_country = $result[0]['pigeon_country'];
            $this->pigeon_yeary = $result[0]['pigeon_yeary'];
            $this->pigeon_club = $result[0]['pigeon_club'];
            $this->pigeon_nr = $result[0]['pigeon_nr'];
            $this->pigeon_gender = $result[0]['pigeon_gender'];
            $this->pigeon_ringnr = $result[0]['pigeon_ringnr'];

            return TRUE;
            
        }else{
            
            $this->isPigeon = FALSE;
            
            return FALSE;
        }
        
    }
    /**
     * Retrieve pigeon data from the database
     *
     * @param int $id pigeon id
     *
     * @return TRUE:FALSE
     */
    public function set_pigeon_by_ringnr( $pigeon_ringnr ) {
        
        global $wpdb;
        
        $sql = "SELECT * FROM {$wpdb->prefix}dovedevil_pigeons WHERE `pigeon_ringnr` = '" . $pigeon_ringnr ."'";
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );
        
        //echo $sql;
        
        
        if ( ! empty($result)){
            //echo __FUNCTION__ . ': $result';
            //var_dump($result);
            $this->isPigeon = TRUE;
            
            $this->club_nr = $result[0]['club_nr'];               // 01               Verein
            
            $this->fancier_nr = $result[0]['fancier_nr'];            // 002              lfd
            
            $this->pigeon_country = $result[0]['pigeon_country'];
            $this->pigeon_year = $result[0]['pigeon_year'];
            $this->pigeon_club = $result[0]['pigeon_club'];
            $this->pigeon_nr = $result[0]['pigeon_nr'];
            $this->pigeon_gender = $result[0]['pigeon_gender'];
            $this->pigeon_ringnr = $result[0]['pigeon_ringnr'];
            
            return TRUE;
            
        }else{
            
            $this->isPigeon = FALSE;
            
            return FALSE;
            
        }
        
    }
    
    /**
     * Display pigeon 
     *
     * @param int $id fancier id
     *
     * @return mixed
     */
    public function display() {
            
        echo 'Action: ' . $this->current_action();
        
        //echo $this->isPigeon;
        
        //var_dump($_REQUEST);
        
        if ($this->isPigeon){
            echo '<div>';
                echo '<h2>';
                    
                    echo '' . $this->club_nr . ' ';
                    //echo '<br>';
                    echo '' . $this->fancier_nr . ' ';
                    //echo '<br>';
                    echo '' . $this->pigeon_ringnr . ' ';
                    //echo '<br>';
                    echo '' . $this->pigeon_gender . ' ';
                    //echo '<br>';
 
                echo '</h2>';
            echo '</div>';
        }
        if ( 'save' === $this->current_action() ) {
            
            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );
            
             //echo 'Bulk $_REQUEST _wpnonce:' . esc_attr( $_REQUEST['_wpnonce']) . '<br>';
             //echo 'Bulk $_GET _wpnonce:' . esc_attr( $_GET['_wpnonce']) . '<br>';
             //echo 'Bulk $_POST _wpnonce:' . esc_attr( $_POST['_wpnonce']) . '<br>';
            
            //echo 'Bulk $_REQUEST:<br>';
            //var_dump($_REQUEST);
            
            if ( ! wp_verify_nonce( $nonce, 'dovedevil_save_pigeon' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                

                
                $this->save_pigeon( absint( $_REQUEST['id']), //is '', isn't it?
                                            $_REQUEST['pigeon_ringnr_cntr'],
                                            $_REQUEST['pigeon_ringnr_year'],
                                            $_REQUEST['pigeon_ringnr_club_id'],
                                            $_REQUEST['pigeon_ringnr_nr'],
                                            $_REQUEST['pigeon_gender']);
                
                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url
                //wp_redirect( esc_url_raw(add_query_arg()) );
                //exit;
            }
        }else{
            //echo '<div>';
            //echo '<h2>';
            //_e('Your are not a registered fancier. Please contact your site-operator!', 'dovedevil');
            //echo '</h2>';
            //echo '</div>';
            
        }
       $this->new_pigeon();
    }
    
    public function new_pigeon( ) {
        global $wpdb;
        
        $save_nonce = wp_create_nonce( 'dovedevil_save_pigeon' );
        
        ?>
        <div id="poststuff">
        	<div id="post-body" class="metabox-holder columns-2">
        		<div id="post-body-content">
        			<div class="meta-box-sortables ui-sortable">
        				<form method="post">
                              	<input type="hidden" id="id" name="id" 
                              	 <?php echo 'value="'. '' .'"';?>
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
                              	<select id="pigeon_ringnr_cntr" name="pigeon_ringnr_cntr">
                                    <option value="DE">DE</option>
                                    <option value="B">B</option>
                                    <option value="NL">NL</option>
                                    <option value="PL">PL</option>
                                </select>
                            
  								 </td>
  								 <td>
  								<input type="text" id="pigeon_ringnr_year" name="pigeon_ringnr_year" size="1" minlength="2" maxlength="2"
  								 <?php echo 'value="'. '' .'"';?>
  								 >
  								 </td>
  								 <td>
  								<input type="text" id="pigeon_ringnr_club_id" name="pigeon_ringnr_club_id" size="4" maxlength="4"
  								 <?php echo 'value="'. substr( $this->main->fancier->club_verb,1) .'"';?>
  								 >
  								 </td>
  								 
  								 <td>
  								 <input type="text" id="pigeon_ringnr_nr" name="pigeon_ringnr_nr" size="2" maxlength="4"
  								  <?php echo 'value="'. '' .'"';?>
  								  >
  								  </td>
  								  </tr>
  								  <tr>
  								  <td>
      								<label for="pigeon_gender">
      									<?php _e('Pigeon Gender','dovedevil');?>
      								</label>
  								  </td>
  								  <td>
      								<select id="pigeon_gender" name="pigeon_gender">
                                        <option value="M">
                                        <?php _e('Male','dovedevil');?>
                                        </option>
                                        <option value="F">
                                        <?php _e('Female','dovedevil');?>
                                        </option>
                                    </select>
                                </td>
                                </td>
                                </tr>
                                </table>
  								<br><br>
  								
  								<input type="submit" 
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
	}
		
    
}