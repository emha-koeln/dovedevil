<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://emha.koeln
 * @since      0.1.1
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
                settings_fields( $this->plugin_name . '_import' );
                do_settings_sections( $this->plugin_name .'_import' );
                //submit_button();
            ?>
        </form>
    </div>

    <div class="wrap">
        <h2><?php _e('Import','dovedevil'); ?></h2>
           		<div id="poststuff">
            		<div id="post-body" class="metabox-holder columns-2">
            			<div id="post-body-content">
           					<div class="meta-box-sortables ui-sortable">
            					
            						<?php
                                        //$this->fancier->setprepare_items();
                                        $this->import->display(); 
                                    ?>
								
							</div>
						</div>
					</div>
					<br class="clear">
				</div>
		</div>