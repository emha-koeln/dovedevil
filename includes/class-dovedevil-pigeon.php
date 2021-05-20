<?php
/**
 * A Pigeon Object.
 *
 * @link       http://emha.koeln
 * @since      0.1.0
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/admin
 */

/**
 * A Pigeon Object.
 *
 * Defines a Pigeon Object.
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/admin
 * @author     emha.koeln <mheep@emha.koeln>
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

    
class Dovedevil_Pigeon
{

    /**
     * Store plugin main class to allow public access.
     *
     * @since    0.1.1
     * @var      object      The main class.
     */
    public $main;
    
    /**
     * Pigeon's Fancier 
     *
     * @since    0.1.1
     * @var      Dovedevil_Fancier  Pigeon's Fancier
     */
    public $fancier;
    
    

    public $club_nr;                // 01               Verein
    public $fancier_nr;             // 002              lfd

    
    /**
     * Pigeon's Data
     * 
     * @var string
     */
    public $pigeon_country;
    public $pigeon_year;
    public $pigeon_club;
    public $pigeon_nr;
    public $pigeon_gender;
    public $pigeon_ringnr;
    public $pigeon_rfid;
    
    public $isPigeon;
    

    
    /** Class constructor */
    public function __construct( )
    {
        
       
        
    }
    
    public function set_pigeon(){
        
    }
    
    public function display(){
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
            _e( 'No Pigeon Data', 'dovedevil');
            //echo '<br>';
            //echo '<br>';
            echo '</h2>';
            echo '</div>';
        }
    }
}