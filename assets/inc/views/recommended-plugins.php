<?php
/**
 * HTML View of Recommended plugins
 *
 * @package TrendPress
 */
?>
<div class="wrap">

	<div id="icon-plugins" class="icon32"><br /></div>

	<h2>
		<?php _e( 'Recommended plugins', 'tp' ); ?>
	</h2>
	
	<p>
		<?php _e( 'On this page, you can install plugins recommended by Trendwerk and apply recommended settings to them after installing.', 'tp' ); ?>
	</p>
	
	<h3>
		<?php _e( 'Recommended plugins', 'tp' ); ?>
	</h3>
	<?php $this->show_plugins( $this->recommended ); ?>
	
	<br />
	
	<h3>
		<?php _e( 'Optional plugins', 'tp' ); ?>
	</h3>
	<?php $this->show_plugins( $this->optional ); ?>	

	<br />
	
	<h3>
		<?php _e( 'Developer tools', 'tp' ); ?>
	</h3>
	<?php $this->show_plugins( $this->development ); ?>	

</div>