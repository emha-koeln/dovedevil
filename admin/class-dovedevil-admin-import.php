<?php
/**
 * Upload files and import.
 *
 * @link       http://emha.koeln
 * @since      0.1.1
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 */

/**
 * Upload files and import.
 *
 * This class handles upload and importt.
 *
 * @since      0.1.1
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 * @author     emha.koeln <mheep@emha.koeln>
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

    
class Dovedevil_Admin_Import
{

    protected $main;
    
    public $ary_upload;
    
    public $fancier;
    
    /** Class constructor */
    public function __construct( $main )
    {
        $this->main = $main;
    }
    
    public function set_fancier( $fancier){
        $this->fancier = $fancier;
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
        
        //echo $this->isPigeon;
        
        //var_dump($_REQUEST);

        if ( 'upload' === $this->current_action() ) {
            
           
            if (  ! wp_verify_nonce( $_POST['dovedevil_upload_nonce'], 'dovedevil_upload')   ) {
                die( 'Go get a life script kiddies' );
            }
            else {

                
                $file = $_FILES['fileToUpload'];
                
                //var_dump($file);
                
                $myfile = fopen($file['tmp_name'], "r") or die("Unable to open file!");
                $myfile_size = $file['size'];
                
                //var_dump($myfile);
                
                
                $count = 0;
                while(!feof($myfile)) {
                    echo "<br>" . '---------------------------------------------'. "<br>";
                    //echo 'LINE:' . fgets($myfile) . "<br>";
                    
                    $this->ary_upload[$count] = $this->main->parser->parse_line(fgets($myfile));
                    $count++;
                    //echo '---------------------------------------------'. "<br>";
                }
                
                copy($file['tmp_name'], 
                        $this->main->path . "/upload/dovedevil-import.txt");
                
                copy($file['tmp_name'], 
                        $this->main->path . "/upload/" . date("Y.m.d-G:i:s-") . $file['name']);
                
                //$mysave = fopen ("/tmp/dovedevil-import.txt", "w");
                //fwrite($mysave, $myfile);
                //fclose($mysave);
                
                //$this->file = $myfile;
                fclose($myfile);
                
                $this->display_import();
  
                
                
            }
        }elseif ( 'import' === $this->current_action() ) {
            
            // In our file that handles the request, verify the nonce.
            //$nonce = esc_attr( $_REQUEST['_wpnonce'] );
            
            if (  ! wp_verify_nonce( $_POST['dovedevil_import_nonce'], 'dovedevil_import')   ) {
                die( 'Go get a life script kiddies' );
            }
            else {

                
                $myfile = fopen($this->main->path . "/upload/dovedevil-import.txt", "r") 
                    or die("Unable to open file!");
                //$myfile_size = $file['size'];
                
                //var_dump($myfile);
                                
                $count = 0;
                while(!feof($myfile)) {
                    echo "<br" . '---------------------------------------------'. "<br>";
                    //echo 'LINE:' . fgets($myfile) . "<br>";
                    
                    $this->main->db->import_from_parser( $this->main->parser->parse_line(fgets($myfile)));
                    $count++;
                    //echo '---------------------------------------------'. "<br>";
                }
                
                //copy($this->main->path . "/upload/dovedevil-import.txt", 
                //     $this->main->path . "/upload/       "/tmp/dovedevil-import.txt");

                //$mysave = fopen ("/tmp/dovedevil-import.txt", "w");
                //fwrite($mysave, $myfile);
                //fclose($mysave);
                
                //$this->file = $myfile;
                fclose($myfile);
                
                
                //var_dump($this);
               // var_dump($this->ary_upload);
                
            }
        }else{
            $this->display_upload();
            //echo '<div>';
            //echo '<h2>';
            //_e('Your are not a registered fancier. Please contact your site-operator!', 'dovedevil');
            //echo '</h2>';
            //echo '</div>';
            
            
        }
        
    }
    
    public function display_upload( ) {
       
        ?>
        <div>   

    	<form method="post" enctype="multipart/form-data">
              <?php _e('Select file to import:' , 'dovedevil'); ?>
              
              <input type="file" name="fileToUpload" id="fileToUpload">
              <input type="submit" name="submit" value="Upload">
              <input type="hidden" id="action" name="action" value="upload">
              <?php wp_nonce_field( 'dovedevil_upload', 'dovedevil_upload_nonce' ); ?>
        </form>
    	
    	</div>
		<?php 
	}
	
	public function display_import() {
	    //echo __FUNCTION__;
	    //var_dump($this->main->upload->ary_upload);
	    ?>
        <div>   

    	<form action="#" method="post">
              <?php _e('If this looks reasonable, import the data' , 'dovedevil'); ?>
              
              <input type="submit" name="submit" value="Import">
              <input type="hidden" id="action" name="action" value="import">
              <?php wp_nonce_field( 'dovedevil_import', 'dovedevil_import_nonce' ); ?>
        </form>
    	
    	</div>
		<?php 
		//var_dump($this->main->ary_upload);
		//exit;
	}
		
    
}