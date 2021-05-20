<?php
/**
 * Parser for import and i18n.
 *
 * @link       http://emha.koeln
 * @since      0.1.1
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 */

/**
 * Parser for import and i18n.
 *
 * This class parses information for import and i18n.
 *
 * @since      0.1.1
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 * @author     emha.koeln <mheep@emha.koeln>
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

    
class Dovedevil_Parser
{

    public $fancier;
    
    /** Class constructor */
    public function __construct()
    {
           
    }
    
    public function parse_line( $line ){
        
        $ret = array();
        
        echo 'Line to parse:' . $line . '<br>';
        
        if ( substr($line, 0, 1) === "3" ){
            
            echo 'Found Magic Number:' . substr($line, 0, 1) . '<br>';
            echo 'seems like a Club:' . '<br>';

            if(get_option('dovedevil' . '_federation_name')
                && get_option('dovedevil' . '_federation_reg')
                && get_option('dovedevil' . '_federation_rv')){
                
                   //echo get_option('dovedevil' . '_federation_name');
                   //echo get_option('dovedevil' . '_federation_reg');
                   //echo get_option('dovedevil' . '_federation_rv');
                    
                    
            }else{
                echo '<br><h2>';
                _e('Set the Information on the Club-Page first', 'dovedevil');
                echo '<br></h2>';
                
                exit();
            }
            
            
            $ret['type'] = 'Club';
    
            $ret['federation_name'] = get_option('dovedevil' . '_federation_name');
            $ret['federation_reg'] = get_option('dovedevil' . '_federation_reg');
            $ret['federation_rv'] = get_option('dovedevil' . '_federation_rv');
            
            
            echo 'Club_Nr:';
            echo substr($line, 1, 2) . '<br>';
            $ret['club_nr'] = substr($line, 1, 2);
            
            // search last ' ';
            $last_white = strrpos($line, '');
            echo 'Club_Name:';
            echo iconv('IBM850','UTF-8',substr($line, 5, $last_white - 8) ). '<br>';
            $ret['club_name'] = iconv('IBM850','UTF-8',trim(substr($line, 5, $last_white - 8)));
            
            echo 'Club_Verb:';
            echo substr($line, $last_white - 7) . '<br>';
            $ret['club_verb'] = trim(substr($line, $last_white - 7));
            
        }elseif ( substr($line, 0, 1) === "4" ){
            
            echo 'Found Magic Number:' . substr($line, 0, 1) . '<br>';
            echo 'seems like a Fancier:' . '<br>';
            $ret['type'] = 'Fancier';
            
            echo ':Club_Nr:';
            echo substr($line, 1, 2) . '<br>';
            $ret['club_nr'] = substr($line, 1, 2);
            
            echo ':Fancier_Nr:';
            echo substr($line, 3, 3) . '<br>';
            $ret['fancier_nr'] = substr($line, 3, 3);
            
            // last two white ' '
            $last_white = strrpos($line, ' ');
            $sec_last_white = strrpos($line, ' ', $last_white);
            $sec_last_white = strlen($line) - $sec_last_white;
            echo ':Fancier_Name:';
            echo iconv('IBM850','UTF-8', substr($line, 6, $sec_last_white + 9 ) ) . '<br>';
            $ret['fancier_name'] = iconv('IBM850','UTF-8',trim(substr($line, 6, $sec_last_white + 9 )));
            
        }elseif ( substr($line, 0, 1) === "0" ){
            
            echo 'Found Magic Number:' . substr($line, 0, 1) . '<br>';
            echo 'seems like a Pigeon:' . '<br>';
            $ret['type'] = 'Pigeon';
            
            echo ':Club_Nr:';
            echo substr($line, 1, 2) . '<br>';
            $ret['club_nr'] = substr($line, 1, 2);
            
            echo ':Fancier_Nr:';
            echo substr($line, 3, 3) . '<br>';
            $ret['fancier_nr'] = substr($line, 3, 3);
            
            $country = "DE";
            //echo substr($line, 6, 2 );
            if (substr($line, 6, 1 ) === " "){
                
            }else{
                $country = trim(substr($line, 6, 2 ));
            }

            echo ':Pigeon_Ringnr:';
            echo trim(substr($line, 6, 12 )) . '<br>';
            $ret['pigeon_i18n_ringnr'] = trim(substr($line, 6, 12 ));
            
            echo ':Pigeon_Country:';
            echo $country . '<br>';
            $ret['pigeon_country'] = $country;
            
            echo ':Pigeon_Year:';
            echo substr($line, 8, 2 ) . '<br>';
            $ret['pigeon_year'] = substr($line, 8, 2 );
            
            echo ':Pigeon_Club:';
            echo substr($line, 10, 4 ) . '<br>';
            $ret['pigeon_club'] = substr($line, 10, 4 );
            
            echo ':Pigeon_Nr:';
            echo substr($line, 14, 4 ) . '<br>';
            $ret['pigeon_nr'] = substr($line, 14, 4 );
            
            $gender = "W";
            if( substr($line, 18, 1 ) !== "W"
                && substr($line, 19, 1 ) !== "W"){
                $gender = "M";
            }
            echo ':Pigeon_Gender:'; // . substr($line, 18, 1 ) ;
            echo $gender . '<br>';
            $ret['pigeon_gender'] = $gender;
            
            echo ':Pigeon_RFID:';
            if($country == "DE"){
                echo substr($line, 19) . '<br>';
                $ret['pigeon_rfid'] = trim(substr($line, 19));
            }else{
                echo substr($line, 19) . '<br>';
                $ret['pigeon_rfid'] = trim(substr($line, 19));
            }
            
            
        }else {
            echo 'Magic Number not found: ' . $line . '<br>';
        }
        
        return $ret;        
    }
   
    public function parse_ringnr( $ringnr){
        
        $ret = array();
        
        if ( is_numeric( substr($ringnr,0,1) ) ){
            // 01234.67.90123
            $ret['county'] = "DE";
            
            $ret['year'] = substr($ringnr, 6 ,2);
            $ret['club'] = substr($ringnr, 1 ,4);
            $ret['nr'] = substr($ringnr, 9 ,4);
            
            
            $ret['gender'] = substr($ringnr, 13 ,1);
           
            
            $ret['ringnr'] = "0" . $ret['club'] . "." . $ret['year'] . "." . $ret['nr'] . $ret['gender'];
            
        }else{
            $ret['county'] = substr($ringnr, 0,2);
            //TODO
        }
        
        return $ret;
        
    }
    
    public function build_ringnr($country, $year, $club, $nr, $gender ){
        
        $ret ="Country not done";
        
        if ($country === "DE"){
            
            $ret = "0";
            $ret .= $club;
            $ret .= '.';
            $ret .= $year;
            $ret .= '.';
            
        }else{
            $ret = $country;
            $ret .= '.';
            $ret .= $year;
            $ret .= '.';
            $ret .= $club;
        }
        
        
        if( strlen($nr) < 4 ){
            
            $ret .= str_pad($nr, 4, "0", STR_PAD_LEFT);
            
        }else{
            
            $ret .= $nr;
        }
        
        $gender = strtoupper($gender);
        
        if( strtoupper($gender) === "F"
            || strtoupper($gender) === "W"){
            
            $gender = "W";
            $ret .= $gender;
            
        }else{
            
        }
        
        return $ret;
        
    }
    
}