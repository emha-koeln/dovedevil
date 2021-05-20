<?php
/**
 * Fanciers view.
 *
 * @link       http://emha.koeln
 * @since      0.1.1
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 */

/**
 * Fanciers view..
 *
 * This class is ths Fanciers view.
 *
 * @since      0.1.1
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 * @author     emha.koeln <mheep@emha.koeln>
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

    
class Dovedevil_Fancier
{
    public $federation_name;        // RV-Horrem
    public $federation_reg;         // 406              Reg
    public $federation_rv;          // 06               RV
    
    public $wp_id;
    
    public $club_verb;              // D0815            Verband
    public $club_nr;                // 01               Verein
    public $club_name;              // Schwalbe Habb.   Verein Name
    
    public $fancier_nr;             // 002              lfd
    public $fancier_name;
    
    public $isFancier = FALSE;
    
    /** Class constructor */
    public function __construct()
    {

    }
    
    
    /**
     * Retrieve fancier data from the database
     *
     * @param int $id fancier id
     *
     * @return TRUE:FALSE
     */
    public function set_fancier_by_wp_id( $id ) {
        
        global $wpdb;
        
        
        if(is_admin()){
            $options = get_option('dovedevil_assign_fancier');
            
            $sql = "SELECT * FROM {$wpdb->prefix}dovedevil_fanciers WHERE `id` = " . $options;
            $result_fancier = $wpdb->get_results( $sql, 'ARRAY_A' );
            
            
        }else {
        
            $sql = "SELECT * FROM {$wpdb->prefix}dovedevil_fanciers WHERE `wp_id` = " . $id;
            $result_fancier = $wpdb->get_results( $sql, 'ARRAY_A' );
        }
        
        
        //echo $sql;
        //echo __FILE__ . ': $result_fancier'; 
        //var_dump($result_fancier);
        
        if ( ! empty($result_fancier)){
            
            $this->isFancier = TRUE;
            
            $sql = "SELECT * FROM {$wpdb->prefix}dovedevil_clubs WHERE `club_nr` = " . $result_fancier[0]['club_nr'];
            $result_club = $wpdb->get_results( $sql, 'ARRAY_A' );
            
            
            //var_dump($result_club);
            
            $this->federation_name = $result_club[0]['federation_name'];        // RV-Horrem
            $this->federation_reg = $result_club[0]['federation_reg'];         // 406              Reg
            $this->federation_rv = $result_club[0]['federation_rv'];         // 06               RV
            
            $this->wp_id = $result_fancier[0]['wp_id']; 
            
            $this->club_verb = $result_club[0]['club_verb'];              // D0815            Verband
            $this->club_nr = $result_fancier[0]['club_nr'];               // 01               Verein
            $this->club_name = $result_club[0]['club_name'];             // Schwalbe Habb.   Verein Name
            
            $this->fancier_nr = $result_fancier[0]['fancier_nr'];            // 002              lfd
            $this->fancier_name = $result_fancier[0]['fancier_name'];
            return TRUE;
        }else{
            
            //echo 'HERE WE ARE';
            
            $this->isFancier = FALSE;
            
            return FALSE;
        }
        
    }
    
    public function get_club_nr(){
        
        return (string) $this->club_nr;
        
    }
    
    public function get_fancier_nr(){
        
        return (string) $this->fancier_nr;
        
    }
    
    /**
     * Display fancier 
     *
     * @param int $id fancier id
     *
     * @return mixed
     */
    public function display() {
            
        if ($this->isFancier){
            echo '<div>';
                echo '<h2>';
                    echo 'Reg ' . $this->federation_reg . ' ';
                    echo 'RV ' . $this->federation_rv . ' ';
                    //echo '<br>';
                    echo '' . $this->federation_name .'';
                    echo '<br>';
                    //echo '<br>';
                    
                    echo '' . $this->club_nr . ' ';
                    //echo '<br>';
                    echo '' . $this->club_verb . ' ';
                    echo '' . $this->club_name . ' ';
                    //echo '<br>';
                    echo '<br>';
                    
                    echo '' . $this->fancier_nr . ' ';
                    //echo '<br>';
                    
                    echo '' . $this->fancier_name;
                echo '</h2>';
            echo '</div>';
        }else{
            echo '<div>';
            echo '<h2>';
            _e('Your are not a registered fancier. Please contact your site-operator!', 'dovedevil');
            echo '</h2>';
            echo '</div>';
        }
       
    }
    
}