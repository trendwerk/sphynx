<div class="wrap trendpress-options">
	<div id="icon-themes" class="icon32"><br></div>
	<h2><?php _e('Theme options','tp'); ?></h2>
	<form method="post" action="<?php echo admin_url('themes.php?page=tp-contact_info'); ?>">
		<fieldset>
			<h3><?php _e('General settings','tp'); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="sitename"><?php _e('Sitename','tp'); ?></label></th>
						<td><input class="regular-text" name="sitename" id="sitename" type="text" value="<?php echo get_bloginfo('name'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="description"><?php _e('Description','tp'); ?></label></th>
						<td><input class="regular-text" name="description" id="description" type="text" value="<?php echo get_bloginfo('description'); ?>"/></td>
					</tr>
				</tbody>
			</table>
			
			<h3><?php _e('Contact','tp'); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="naam"><?php _e('Company name','tp'); ?></label></th>
						<td><input class="regular-text" name="naam" id="naam" type="text" value="<?php echo get_option('tp-naam'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="adres"><?php _e('Address','tp'); ?></label></th>
						<td><input class="regular-text" name="adres" id="adres" type="text" value="<?php echo get_option('tp-adres'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="postcode"><?php _e('Postal code','tp'); ?></label></th>
						<td><input class="regular-text" name="postcode" id="postcode" type="text" value="<?php echo get_option('tp-postcode'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="plaats"><?php _e('City','tp'); ?></label></th>
						<td><input class="regular-text" name="plaats" id="plaats" type="text" value="<?php echo get_option('tp-plaats'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="email"><?php _e('E-mail','tp'); ?></label></th>
						<td><input class="regular-text" name="email" id="email" type="text" value="<?php echo get_option('tp-email'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="telefoon"><?php _e('Telephone','tp'); ?></label></th>
						<td><input class="regular-text" name="telefoon" id="telefoon" type="text" value="<?php echo get_option('tp-telefoon'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="fax"><?php _e('Fax','tp'); ?></label></th>
						<td><input class="regular-text" name="fax" id="fax" type="text" value="<?php echo get_option('tp-fax'); ?>"/></td>
					</tr>
				</tbody>
			</table>
			
			<h3><?php _e('Registration numbers &amp; financial','tp'); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="kvk"><?php _e('CC No.','tp'); ?></label></th>
						<td><input class="regular-text" name="kvk" id="kvk" type="text" value="<?php echo get_option('tp-kvk'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="btw"><?php _e('VAT No.','tp'); ?></label></th>
						<td><input class="regular-text" name="btw" id="btw" type="text" value="<?php echo get_option('tp-btw'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="bank"><?php _e('Bank name','tp'); ?></label></th>
						<td><input class="regular-text" name="bank" id="bank" type="text" value="<?php echo get_option('tp-bank'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="banknr"><?php _e('Bank No.','tp'); ?></label></th>
						<td><input class="regular-text" name="banknr" id="banknr" type="text" value="<?php echo get_option('tp-banknr'); ?>"/></td>
					</tr>
				</tbody>
			</table>
			
			<h3><?php _e('Social media links','tp'); ?></h3>
			<p class="description"><?php _e('Please provide full URLs to your profile pages (e.g. http://twitter.com/trendwerk/)','tp'); ?>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="twitter">Twitter URL</label></th>
						<td><input class="regular-text" name="twitter" id="twitter" type="text" value="<?php echo get_option('tp-twitter'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="facebook">Facebook URL</label></th>
						<td><input class="regular-text" name="facebook" id="facebook" type="text" value="<?php echo get_option('tp-facebook'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="linkedin">Linkedin URL</label></th>
						<td><input class="regular-text" name="linkedin" id="linkedin" type="text" value="<?php echo get_option('tp-linkedin'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="googleplus">Google Plus URL</label></th>
						<td><input class="regular-text" name="googleplus" id="googleplus" type="text" value="<?php echo get_option('tp-googleplus'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="youtube">YouTube URL</label></th>
						<td><input class="regular-text" name="youtube" id="youtube" type="text" value="<?php echo get_option('tp-youtube'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="newsletter"><?php _e('Newsletter / mailto link','tp'); ?></label></th>
						<td><input class="regular-text" name="newsletter" id="newsletter" type="text" value="<?php echo get_option('tp-newsletter'); ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"></th>
						<td><input name="rss" id="rss" type="checkbox" value="true" <?php if(get_option('tp-rss') == 'true') echo 'checked'; ?> /> <label for="rss"><?php _e('Show RSS feed in the social media widget','tp'); ?></label></td>
					</tr>
				</tbody>
			</table>
			
			<input type="submit" name="tp_submit" class="button-primary" value="<?php _e('Save','tp'); ?>"/>
		</fieldset>
	</form>
</div>