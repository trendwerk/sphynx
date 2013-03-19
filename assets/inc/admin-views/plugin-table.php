<table cellspacing="0" class="widefat">
	<tbody>
		<?php $i=0; foreach($plugins as $plugin=>$labels) { $i++; ?>
			<tr <?php if($i%2) echo 'class="alternate"'; ?>>
			
				<td class="row-title" style="width:220px;">
					<?php if(!$this->has_plugin($labels['path'])) { ?>
						<a href="<?php echo wp_nonce_url('update.php?action=install-plugin&amp;plugin='.$plugin,'install-plugin_'.$plugin); ?>"><?php echo $labels['name']; ?></a>
					<?php } else { ?>
						<?php echo $labels['name']; ?>
					<?php } ?>
				</td>
				
				<td class="desc">
					<?php echo $labels['description']; ?>
				</td>
				
				<td class="settings" style="width:200px; text-align: left;">
					<?php if(!$this->has_plugin($labels['path'])) { ?>
						<a href="<?php echo wp_nonce_url('update.php?action=install-plugin&amp;plugin='.$plugin,'install-plugin_'.$plugin); ?>"><?php _e('Install now','tp'); ?></a>
					<?php } else if(is_plugin_active($labels['path']) && isset($labels['settings'])) { ?>
						<a href="<?php echo admin_url('plugins.php?page=tp-recommended-plugins&settings='.$plugin); ?>" onclick="if(!confirm('<?php _e('Are you sure you want to reset to the recommended TrendPress settings?','tp'); ?>')) return false;"><?php _e('Apply settings','tp'); ?></a>
					<?php } else if(!is_plugin_active($labels['path'])) { ?>
						<a href="<?php echo wp_nonce_url('plugins.php?action=activate&plugin='.urlencode($labels['path']),'activate-plugin_'.$labels['path']); ?>"><?php _e('Activate'); ?></a>
					<?php } ?>
				</td>					
			</tr>
		<?php } ?>
	</tbody>
</table>