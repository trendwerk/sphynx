<?php
/**
 * HTML View of the recommended plugins table
 *
 * @package TrendPress
 */
?>

<table cellspacing="0" class="widefat">

	<tbody>

		<?php $i = 0; foreach( $plugins as $plugin => $labels ) { $i++; ?>

			<tr <?php if( $i % 2 ) echo 'class="alternate"'; ?>>
			
				<td class="row-title" style="width: 220px;">
					<?php 
						if( ! $this->has_plugin( $labels['path'] ) ) { 
							echo '<a href="' . wp_nonce_url('update.php?action=install-plugin&amp;plugin='.$plugin,'install-plugin_'.$plugin) . '">' . $labels['name'] . '</a>';
						} else {
							echo $labels['name'];
						} 
					?>
				</td>
				
				<td class="desc">
					<?php echo $labels['description']; ?>
				</td>
				
				<td class="settings" style="width:200px; text-align: left;">
					<?php 
						if(!$this->has_plugin($labels['path'])) { 
							echo '<a href="' . wp_nonce_url( 'update.php?action=install-plugin&amp;plugin=' . $plugin, 'install-plugin_' . $plugin ) . '">' . __( 'Install now', 'tp' ) . '</a>';
						} else if( is_plugin_active( $labels['path'] ) && isset( $labels['settings'] ) ) {
							echo '<a href="' . admin_url( 'plugins.php?page=tp-recommended-plugins&settings=' . $plugin ) . '" onclick="return confirm(\'' . __( 'Are you sure you want to reset to the recommended TrendPress settings?', 'tp' ) . '\');">' . __( 'Apply settings', 'tp' ) . '</a>';
						} else if( ! is_plugin_active( $labels['path'] ) ) {
							echo '<a href="' . wp_nonce_url( 'plugins.php?action=activate&plugin=' . urlencode( $labels['path'] ), 'activate-plugin_' . $labels['path'] ) . '">' . __( 'Activate' ) . '</a>';
						} 
					?>
				</td>					
			</tr>

		<?php } ?>

	</tbody>

</table>