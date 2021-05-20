<?php
/**
 * Database setup.
 *
 * @link       http://emha.koeln
 * @since      0.1.0
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 */

/**
 * Satic database setup.
 *
 * This class handles the DB init.
 *
 * @since      0.1.0
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 * @author     emha.koeln <mheep@emha.koeln>
 */
class Dovedevil_Static_DB{
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
    
    public static function set_sample_data(){
        
        global $wpdb;
        
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        
        // Clubs
        $table = $wpdb->prefix . "dovedevil_clubs";
        
        /*
               		`federation_name` varchar(30) NOT NULL,
              		`federation_reg` varchar(30) NOT NULL,
                    `federation_rv` varchar(30) NOT NULL,
                    `club_verb` varchar(30) NOT NULL,
                    `club_nr` varchar(30) NOT NULL,
                    `club_name` varchar(30) NOT NULL,
        */
        
        $sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
        			)
    			VALUES (
                    now(),
    				'406',
    				'16',
    				'D1969',
                    '01',
                    'Vereinte Freunde Horrem')
    				";
    				// echo $sql;
    				
    				dbDelta($sql);
    				
		$sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
            		)
            	VALUES (
                    now(),
            		'406',
            		'16',
            		'D2836',
                    '02',
                    'Schwalbe Habbelrath')
            		";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
        $sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
            		)
            	VALUES (
                    now(),
            		'406',
            		'16',
            		'D0600',
                    '03',
                    'Konkurrenz Glessen')
            		";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
            		
        $sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
            		)
            	VALUES (
                    now(),
            		'406',
            		'16',
            		'D3364',
                    '07',
                    'Planmäßig Königsdorf')
            		";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
        $sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
            		)
            	VALUES (
                    now(),
            		'406',
            		'16',
            		'D6318',
                    '12',
                    'Heimatliebe Oberaußem')
            		";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
        $sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
            		)
            	VALUES (
                    now(),
            		'406',
            		'16',
            		'D1180',
                    '13',
                    'Taubenpost Bergheim')
            		";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
         $sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
            		)
            	VALUES (
                    now(),
            		'406',
            		'16',
            		'D0113',
                    '14',
                    'Berrendorf-Elsdorf')
            		";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
          $sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
            		)
            	VALUES (
                    now(),
            		'406',
            		'16',
            		'D8086',
                    '15',
                    'Kehre Wieder Sindorf')
            		";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
          $sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
            		)
            	VALUES (
                    now(),
            		'406',
            		'16',
            		'D2435',
                    '16',
                    'Heimatliebe Geyen')
            		";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
          $sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
            		)
            	VALUES (
                    now(),
            		'406',
            		'16',
            		'D3954',
                    '23',
                    'Ohne Furcht Buir')
            		";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
          $sql = "INSERT INTO $table (
                    time,
    				federation_reg,
    				federation_rv,
              		club_verb,
                    club_nr,
                    club_name
            		)
            	VALUES (
                    now(),
            		'406',
            		'16',
            		'D3711',
                    '27',
                    'Luftpost Buschbell')
            		";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
         // FAnciers
         $table = $wpdb->prefix . "dovedevil_fanciers";
            		
         /*
                     wp_id` varchar(30) NOT NULL DEFAULT '0',
                    `club_nr` varchar(30) NOT NULL,
                    `fancier_nr` varchar(30) NOT NULL,
              		`fancier_name` text NOT NULL,
         */
         
         $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
              		fancier_name
        			)
    			VALUES (
    				now(),
    				'02',
                    '999',
                    'RS')
    				";
                    // echo $sql;
         
                    dbDelta($sql);
         
         
         $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
              		fancier_name
        			)
    			VALUES (
    				now(),
    				'02',
                    '001',
                    'Mörs Reiner')
    				";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
         $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
              		fancier_name
        			)
    			VALUES (
    				now(),
    				'02',
                    '003',
                    'Wirtz Theo')
    				";
            		// echo $sql;
            		
            		dbDelta($sql);

           $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
              		fancier_name
        			)
    			VALUES (
    				now(),
    				'16',
                    '011',
                    'Broich Hubert')
    				";
            		// echo $sql;
            		
            		dbDelta($sql);
  
         $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
              		fancier_name
        			)
    			VALUES (
    				now(),
    				'14',
                    '020',
                    'Kiedrowicz Mar.+Kac')
    				";
            		// echo $sql;
            		
            		dbDelta($sql);
  
            		
          $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
              		fancier_name
        			)
    			VALUES (
    				now(),
    				'12',
                    '014',
                    'Franken Ralf')
    				";
            		// echo $sql;
            		
                    dbDelta($sql);
            		
           $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
              		fancier_name
        			)
    			VALUES (
    				now(),
    				'15',
                    '005',
                    'Plessen Joachim')
    				";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
           $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
              		fancier_name
        			)
    			VALUES (
    				now(),
    				'03',
                    '010',
                    'Schmitz Lukas + Th.')
    				";
            		// echo $sql;
            		
            		dbDelta($sql);
          
          
          
          // Pigeons	
          $table = $wpdb->prefix . "dovedevil_pigeons";
          
          /*
                    `club_nr` varchar(30) NOT NULL,
                    `fancier_nr` varchar(30) NOT NULL,
              		`pigeon_country` varchar(30) NOT NULL,
                    `pigeon_year` varchar(30) NOT NULL,
                    `pigeon_club` varchar(30) NOT NULL,
                    `pigeon_nr` varchar(30) NOT NULL,
              		`pigeon_gender` varchar(1) NOT NULL DEFAULT '',
                    `pigeon_ringnr` varchar(30) NOT NULL,'',
          */
          $sql = "INSERT INTO $table (
                    time,
                    club_nr,
                    fancier_nr,
                    pigeon_country,
                    pigeon_year,
                    pigeon_club,
                    pigeon_nr,
              		pigeon_gender,
                    pigeon_ringnr
        			)
    			VALUES (
    				now(),
    				'02',
                    '001',
                    'DE',
                    '17',
                    '2836',
                    '1564',
                    'W',
                    '02836.17.1564W')
    				";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
          $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
                    pigeon_country,
                    pigeon_year,
                    pigeon_club,
                    pigeon_nr,
              		pigeon_gender,
                    pigeon_ringnr
        			)
    			VALUES (
    				now(),
    				'02',
                    '001',
                    'DE',
                    '16',
                    '2836',
                    '1872',
                    '',
                    '2836.16.1872')
    				";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
            		
           $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
                    pigeon_country,
                    pigeon_year,
                    pigeon_club,
                    pigeon_nr,
              		pigeon_gender,
                    pigeon_ringnr
        			)
    			VALUES (
    				now(),
    				'02',
                    '003',
                    'DE',
                    '17',
                    '2836',
                    '1438',
                    'W',
                    '2836.16.1872W')
    				";
            		// echo $sql;
            		
            		dbDelta($sql);
            
            $sql = "INSERT INTO $table (
                    time,
    				club_nr,
    				fancier_nr,
                    pigeon_country,
                    pigeon_year,
                    pigeon_club,
                    pigeon_nr,
              		pigeon_gender,
                    pigeon_ringnr
        			)
    			VALUES (
    				now(),
    				'02',
                    '003',
                    'DE',
                    '17',
                    '2836',
                    '0027',
                    '',
                    '2836.16.1872')
    				";
            		// echo $sql;
            		
            		dbDelta($sql);
            		
        
    }
}
?>