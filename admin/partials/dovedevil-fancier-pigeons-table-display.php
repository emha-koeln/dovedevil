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

     <div class="wrap">

			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="post">
								<?php
								$this->main->fancier->display();
								if ($this->main->fancier->isFancier){
    								$this->pigeons_table->prepare_items();
    								$this->pigeons_table->display();
								}
								?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>

    
</div>