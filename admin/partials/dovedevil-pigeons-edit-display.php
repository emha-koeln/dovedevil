<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://emha.koeln
 * @since      0.1.0
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <form action="options.php" method="post">
        <?php
            settings_fields( $this->plugin_name .'_pigeons' );
            do_settings_sections( $this->plugin_name . '_pigeons' );
            
            submit_button();
        ?>
    </form>
	<?php /*
	if (isset($_POST )){
	   var_dump($_POST);
	}
	if (isset($_GET )){
	    var_dump($_GET);
	}
	if (isset($_REQUEST )){
	    var_dump($_REQUEST);
	}
	*/
	?>
	
    
</div>