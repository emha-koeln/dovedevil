<?php
/**
 * Database handles.
 *
 * @link       http://emha.koeln
 * @since      0.1.1
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 */

/**
 * Database handles.
 *
 * This class handles handles the DB requests
 *
 * @since      0.1.1
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 * @author     emha.koeln <mheep@emha.koeln>
 */

class Dovedevil_DB{
    
    protected $main;
    
    protected $clubs;
    
    protected $fanciers;
    
    protected $pigeons;
    
    /** Class constructor */
    public function __construct( $main )
    {
        $this->main = $main;
        
        global $wpdb;
        
        $this->clubs = $wpdb->prefix . "dovedevil_clubs";
        $this->fanciers = $wpdb->prefix . "dovedevil_fanciers";
        $this->pigeons = $wpdb->prefix . "dovedevil_pigeons";
    
    }
    
    public function  import_from_parser( array $ary){
        
        //var_dump($ary);
        
        if(isset($ary['type'])){
        
            if ( $ary['type'] === 'Club'){
                $this->save_club($ary);
            }elseif ( $ary['type'] === 'Fancier'){
                $this->save_fancier($ary);
            }elseif ( $ary['type'] === 'Pigeon'){
                $this->save_pigeon($ary);
            }
        }
        
    }
    
    public function save_club( array $ary){
        var_dump($ary);
        
        global $wpdb;
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "SELECT * FROM " . $this->clubs . " WHERE `club_verb` = '" . $ary['club_verb'] ."'";
        
        $result = array();
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );
        
        echo 'is already in DB? (' . $sql . ")";
        
        var_dump($result);
        
        if (sizeof($result)>0){
            //update
            
            echo '<br>UPDATE<br>';
            
            $federation_name= $ary['federation_name'];
            $federation_reg = $ary['federation_reg'];
            $federation_rv  = $ary['federation_rv'];
            $club_nr        = $ary['club_nr'];
            $club_nr        = $ary['club_nr'];
            $club_name      = $ary['club_name'];
            
            
            $sql = "UPDATE `" . $this->clubs . "` ";
            $sql .= "SET ";
            $sql .= "`federation_name` = '" . $ary['federation_name'] ."' ";
            $sql .= ", `federation_reg` = '" . $ary['federation_reg'] ."' ";
            $sql .= ", `federation_rv` = '" . $ary['federation_rv'] ."' ";
            $sql .= ", `club_verb` = '" . $ary['club_verb'] ."' ";
            $sql .= ", `club_nr` = '" . $ary['club_nr'] ."' ";
            $sql .= ", `club_name` = '" . $ary['club_name'] ."' ";
            
            $sql .= "WHERE `id` = ".$result[0]['id'] ."";
            
            dbDelta($sql);
            
        }else{
            //insert
            echo '<br>INSERT<br>';
            
            $federation_name= $ary['federation_name'];
            $federation_reg = $ary['federation_reg'];
            $federation_rv  = $ary['federation_rv'];
            
            $club_verb      = $ary['club_verb'];
            $club_nr        = $ary['club_nr'];
            $club_name      = $ary['club_name'];
            
            
            $sql = "INSERT INTO $this->clubs (
                    time,
                    federation_name,
    				federation_reg,
    				federation_rv,
                    club_verb,
                    club_nr,
                    club_name
                    )
    			VALUES (
    				now(),
                    '$federation_name',
                    '$federation_reg',
                    '$federation_rv',
    				'$club_verb',
                    '$club_nr',
                    '$club_name'
                    )";// $charset_collate;";
            
            dbDelta($sql);

        }
        
        
    }
    
    public function save_fancier( array $ary){
        
        global $wpdb;
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "SELECT * FROM " . $this->fanciers . " WHERE `club_nr` = '" . $ary['club_nr'] ."' ";
        $sql .= "AND `fancier_nr` = '" . $ary['fancier_nr'] . "'";
        $result = array();
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );
        
        echo 'is already in DB? (' . $sql . ")";
        
        //var_dump($result);
        $club_nr        = $ary['club_nr'];
        $fancier_nr     = $ary['fancier_nr'];
        $fancier_name   = $ary['fancier_name'];
            
        if (sizeof($result) > 0){
            //update
            
            echo '<br>UPDATE<br>';

            // TODO: use vars above
            $sql = "UPDATE `" . $this->fanciers . "` ";
            $sql .= "SET ";
            $sql .= "`club_nr` = '" . $ary['club_nr'] ."' ";
            $sql .= ", `fancier_nr` = '" . $ary['fancier_nr'] ."' ";
            $sql .= ", `fancier_name` = '" . $ary['fancier_name'] ."' ";
            
            $sql .= "WHERE `id` = ".$result[0]['id'] ."";
            
            dbDelta($sql);
        }else{
            //insert
            echo '<br>INSERT<br>';
            
            
            $sql = "INSERT INTO $this->fanciers (
                    time,
    				club_nr,
    				fancier_nr,
                    fancier_name
                    )
    			VALUES (
    				now(),
    				'$club_nr',
                    '$fancier_nr',
                    '$fancier_name'
                    )";// $charset_collate;";
    				
            
            dbDelta($sql);
        }
    }
    
    public function save_pigeon( array $ary ){
        
        //var_dump($ary);
        
        global $wpdb;
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        
        $sql = "SELECT * FROM " . $this->pigeons . " WHERE `club_nr` like '" . $ary['club_nr'] ."' ";
        $sql .= "AND `fancier_nr` like '" . $ary['fancier_nr'] . "' ";
        $sql .= "AND `pigeon_country` like '" . $ary['pigeon_country'] . "' ";
        $sql .= "AND `pigeon_year` like '" . $ary['pigeon_year'] . "' ";
        $sql .= "AND `pigeon_club` like '" . $ary['pigeon_club'] . "' ";
        $sql .= "AND `pigeon_nr` like '" . $ary['pigeon_nr'] . "' ";
        //$sql .= "AND `pigeon_country` = '" . $ary['pigeon_country'] . "' ";
        $result = array();
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );
        
        echo 'is already in DB? (' . $sql . ")";
        
        var_dump($result);
        
        if (sizeof($result) > 0){
            //update
            
            echo '<br>UPDATE<br>';  
            
            $club_nr = $ary['club_nr'];
            $fancier_nr  = $ary['fancier_nr'];
            $country     = $ary['pigeon_country'];
            $year        = $ary['pigeon_year'];
            $club        = $ary['pigeon_club'];
            $nr          = $ary['pigeon_nr'];
            $gender      = $ary['pigeon_gender'];
            $ringnr      = $this->main->parser->build_ringnr($country, $year, $club, $nr, $gender);
            $rfid        = $ary['pigeon_rfid'];
            
            $sql = "UPDATE `" . $this->pigeons . "` ";
            $sql .= "SET ";
            $sql .= "`club_nr` = '" . $ary['club_nr'] ."' ";
            $sql .= ", `fancier_nr` = '" . $ary['fancier_nr'] ."' ";
            $sql .= ", `pigeon_country` = '" . $ary['pigeon_country'] ."' ";
            $sql .= ", `pigeon_year` = '" . $ary['pigeon_year'] ."' ";
            $sql .= ", `pigeon_club` = '" . $ary['pigeon_club'] ."' ";
            $sql .= ", `pigeon_nr` = '" . $ary['pigeon_nr'] ."' ";
            $sql .= ", `pigeon_gender` = '" . $ary['pigeon_gender'] ."' ";
            $sql .= ", `pigeon_ringnr` = '" . $ringnr ."' ";
            $sql .= ", `pigeon_rfid` = '" . $rfid ."' ";
            
            $sql .= "WHERE `id` = ".$result[0]['id'] ."";
            
            dbDelta($sql);
            
            
        }else{
            
            echo '<br>INSERT<br>';
            
            //insert
            $club_nr     = $ary['club_nr'];
            $fancier_nr  = $ary['fancier_nr'];
            $country     = $ary['pigeon_country'];
            $year        = $ary['pigeon_year'];
            $club        = $ary['pigeon_club'];
            $nr          = $ary['pigeon_nr'];
            $gender      = $ary['pigeon_gender'];
            $ringnr = $this->main->parser->build_ringnr($country, $year, $club, $nr, $gender);
            $rfid        = $ary['pigeon_rfid'];
            //$ringnr      = $ary['ringnr'];
            
            
            $sql = "INSERT INTO $this->pigeons (
                    time,
    				club_nr,
    				fancier_nr,
                    pigeon_country,
                    pigeon_year,
                    pigeon_club,
                    pigeon_nr,
              		pigeon_gender,
                    pigeon_ringnr,
                    pigeon_rfid
        			)
    			VALUES (
    				now(),
    				'$club_nr',
                    '$fancier_nr',
                    '$country',
                    '$year',
                    '$club',
                    '$nr',
                    '$gender',
                    '$ringnr',
                    '$rfid')
    				";
            
            dbDelta($sql);
        }
        
    }
    
    public function save_dd_pigeon( Dovedevil_Pigeon $pigeon ){
        
        //echo __FILE__;
        //$pigeon->display();
        //$pigeon->fancier->display();
        
        //if( strlen($pigeon->pigeon_nr) < 4 ){

        $pigeon->pigeon_club = str_pad($pigeon->pigeon_club, 4, "0", STR_PAD_LEFT);
        $pigeon->pigeon_year = str_pad($pigeon->pigeon_year, 2, "0", STR_PAD_LEFT);
        
        $pigeon->pigeon_nr = str_pad($pigeon->pigeon_nr, 4, "0", STR_PAD_LEFT);
            
        //}
        
        
        global $wpdb;
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        
        $sql = "SELECT * FROM " . $this->pigeons . " WHERE `club_nr` like '" . $pigeon->fancier->club_nr ."' ";
        $sql .= "AND `fancier_nr` like '" . $pigeon->fancier->fancier_nr . "' ";
        $sql .= "AND `pigeon_country` like '" . $pigeon->pigeon_country . "' ";
        $sql .= "AND `pigeon_year` like '" . $pigeon->pigeon_year . "' ";
        $sql .= "AND `pigeon_club` like '" . $pigeon->pigeon_club . "' ";
        $sql .= "AND `pigeon_nr` like '" . $pigeon->pigeon_nr . "' ";
        //$sql .= "AND `pigeon_country` = '" . $ary['pigeon_country'] . "' ";
        $result = array();
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );
        
        //echo 'is already in DB? (' . $sql . ")";
        
        //var_dump($result);
        
        //
        $club_nr     = $pigeon->fancier->club_nr;
        $fancier_nr  = $pigeon->fancier->fancier_nr;
        $country     = $pigeon->pigeon_country;
        $year        = $pigeon->pigeon_year;
        $club        = $pigeon->pigeon_club;
        $nr          = $pigeon->pigeon_nr;
        $gender      = $pigeon->pigeon_gender;
        $ringnr = $this->main->parser->build_ringnr($country, $year, $club, $nr, $gender);
        $rfid        = $pigeon->pigeon_rfid;
        //$ringnr      = $ary['ringnr'];
        
        if (sizeof($result) > 0){
            //update
            
            echo '<br>UPDATE<br>';
            
     
            $sql = "UPDATE `" . $this->pigeons . "` ";
            $sql .= "SET ";
            $sql .= "`club_nr` = '" . $club_nr ."' ";
            $sql .= ", `fancier_nr` = '" . $fancier_nr ."' ";
            $sql .= ", `pigeon_country` = '" . $country ."' ";
            $sql .= ", `pigeon_year` = '" . $year ."' ";
            $sql .= ", `pigeon_club` = '" . $club ."' ";
            $sql .= ", `pigeon_nr` = '" . $nr ."' ";
            $sql .= ", `pigeon_gender` = '" . $gender ."' ";
            $sql .= ", `pigeon_ringnr` = '" . $ringnr ."' ";
            $sql .= ", `pigeon_rfid` = '" . $rfid ."' ";
            
            $sql .= "WHERE `id` = ".$result[0]['id'] ."";
            
            dbDelta($sql);
            
            
        }else{
            
            echo '<br>INSERT<br>';
            
            $sql = "INSERT INTO $this->pigeons (
                    time,
    				club_nr,
    				fancier_nr,
                    pigeon_country,
                    pigeon_year,
                    pigeon_club,
                    pigeon_nr,
              		pigeon_gender,
                    pigeon_ringnr,
                    pigeon_rfid
        			)
    			VALUES (
    				now(),
    				'$club_nr',
                    '$fancier_nr',
                    '$country',
                    '$year',
                    '$club',
                    '$nr',
                    '$gender',
                    '$ringnr',
                    '$rfid')
    				";
            
            dbDelta($sql);
        }
        
    }
    
    public function get_fanciers(){
        
        global $wpdb;
        
        $sql = "SELECT * FROM " . $this->fanciers . " WHERE 1";
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );
        
        return $result;
    }
    
    
    public function assign_fancier_to_wp_user_ID( $fancier, $wp_user_ID ){
        
        global $wpdb;
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        
        //echo 'do it...';
        
        //echo $fancier->club_nr;
        //echo $fancier->fancier_nr;
        //echo $wp_user_ID;
        
        
        $sql = "UPDATE `" . $this->fanciers . "` ";
        $sql .= "SET ";
        $sql .= "`wp_id` = '" . $wp_user_ID ."' ";
        
        $sql .= "WHERE ";
        $sql .= "`club_nr` = '" . $fancier->club_nr ."' ";
        $sql .= "AND `fancier_nr` = '" . $fancier->fancier_nr ."' ";

        
        dbDelta($sql);
        
    }
    
    
    
    // Old static
    // DB
    public static function create_db()
    {
        global $wpdb;
        
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        
        // create tables in wp database if not exists
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // clubs
        $table = $wpdb->prefix . "dovedevil_clubs";
        $sql = "CREATE TABLE IF NOT EXISTS $table (
             		`id` int(11) NOT NULL AUTO_INCREMENT,
          		    `time` timestamp NOT NULL DEFAULT '0000.00.00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
              		`federation_name` varchar(30) NOT NULL DEFAULT 'RV-Horrem',
              		`federation_reg` varchar(30) NOT NULL,
                    `federation_rv` varchar(30) NOT NULL,
                    `club_verb` varchar(30) NOT NULL,
                    `club_nr` varchar(30) NOT NULL,
                    `club_name` varchar(30) NOT NULL,
        			UNIQUE (`id`)
        		) $charset_collate;";
        dbDelta($sql);
        
        // fanciers
        $table = $wpdb->prefix . "dovedevil_fanciers";
        $sql = "CREATE TABLE IF NOT EXISTS $table (
             		`id` int(11) NOT NULL AUTO_INCREMENT,
          		    `time` timestamp NOT NULL DEFAULT '0000.00.00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
              		`wp_id` varchar(30) NOT NULL DEFAULT '0',
                    `club_nr` varchar(30) NOT NULL,
                    `fancier_nr` varchar(30) NOT NULL,
              		`fancier_name` text NOT NULL,
        			UNIQUE (`id`)
        		) $charset_collate;";
        dbDelta($sql);
        
        // pigeons
        $table = $wpdb->prefix . "dovedevil_pigeons";
        $sql = "CREATE TABLE IF NOT EXISTS $table (
             		`id` int(11) NOT NULL AUTO_INCREMENT,
          		    `time` timestamp NOT NULL DEFAULT '0000.00.00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
                    `club_nr` varchar(30) NOT NULL,
                    `fancier_nr` varchar(30) NOT NULL,
              		`pigeon_country` varchar(30) NOT NULL,
                    `pigeon_year` varchar(30) NOT NULL,
                    `pigeon_club` varchar(30) NOT NULL,
                    `pigeon_nr` varchar(30) NOT NULL,
              		`pigeon_gender` varchar(1) NOT NULL DEFAULT '',
                    `pigeon_ringnr` varchar(30) NOT NULL,
                    `pigeon_rfid` varchar(30) NOT NULL,
        			UNIQUE (`id`)
        		) $charset_collate;";
        dbDelta($sql);
        

    }
  
    
   
    
}
?>