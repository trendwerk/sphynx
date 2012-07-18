<div class="wrap trendpress-options">
	<div id="icon-themes" class="icon32"><br></div>
	<h2><?php _e('Theme options','tp'); ?></h2>
	<form method="post" action="<?php echo admin_url('themes.php?page=tp-theme-option'); ?>">
		<fieldset>
			<h3><?php _e('General settings','tp'); ?></h3>
			
			<p><label for="sitename"><?php _e('Sitename','tp'); ?></label> <input name="sitename" id="sitename" type="text" value="<?php echo get_bloginfo('name'); ?>"/></p>
			<p><label for="description"><?php _e('Description','tp'); ?></label> <input name="description" id="description" type="text" value="<?php echo get_bloginfo('description'); ?>"/></p>			
			
			<h3><?php _e('Contact','tp'); ?></h3>
			
			<p><label for="naam"><?php _e('Name','tp'); ?></label> <input name="naam" id="naam" type="text" value="<?php echo get_option('tp-naam'); ?>"/></p>
			<p><label for="adres"><?php _e('Adres','tp'); ?></label> <input name="adres" id="adres" type="text" value="<?php echo get_option('tp-adres'); ?>"/></p>
			<p><label for="postcode"><?php _e('Postal code','tp'); ?></label> <input name="postcode" id="postcode" type="text" value="<?php echo get_option('tp-postcode'); ?>"/></p>
			<p><label for="plaats"><?php _e('City','tp'); ?></label> <input name="plaats" id="plaats" type="text" value="<?php echo get_option('tp-plaats'); ?>"/></p>
			<p><label for="email"><?php _e('E-mail','tp'); ?></label> <input name="email" id="email" type="text" value="<?php echo get_option('tp-email'); ?>"/></p>
			<p><label for="telefoon"><?php _e('Telephone','tp'); ?></label> <input name="telefoon" id="telefoon" type="text" value="<?php echo get_option('tp-telefoon'); ?>"/></p>
			<p><label for="kvk"><?php _e('CC No','tp'); ?></label> <input name="kvk" id="kvk" type="text" value="<?php echo get_option('tp-kvk'); ?>"/></p>
			<p><label for="btw"><?php _e('VAT No','tp'); ?></label> <input name="btw" id="btw" type="text" value="<?php echo get_option('tp-btw'); ?>"/></p>
			<p><label for="bank"><?php _e('Bank','tp'); ?></label> <input name="bank" id="bank" type="text" value="<?php echo get_option('tp-bank'); ?>"/></p>
			<p><label for="banknr"><?php _e('Bank No','tp'); ?></label> <input name="banknr" id="banknr" type="text" value="<?php echo get_option('tp-banknr'); ?>"/></p>
			
			<h3><?php _e('Social media links','tp'); ?></h3>
			
			<p><label for="twitter">Twitter</label> <input name="twitter" id="twitter" type="text" value="<?php echo get_option('tp-twitter'); ?>"/></p>
			<p><label for="facebook">Facebook</label> <input name="facebook" id="facebook" type="text" value="<?php echo get_option('tp-facebook'); ?>"/></p>
			<p><label for="googleplus">Google Plus</label> <input name="googleplus" id="googleplus" type="text" value="<?php echo get_option('tp-googleplus'); ?>"/></p>
			<p><label for="linkedin">Linkedin</label> <input name="linkedin" id="linkedin" type="text" value="<?php echo get_option('tp-linkedin'); ?>"/></p>
			<p><label for="youtube">YouTube</label> <input name="youtube" id="youtube" type="text" value="<?php echo get_option('tp-youtube'); ?>"/></p>
			
			<input type="submit" name="tp_submit" class="button-primary" value="<?php _e('Send','tp'); ?>"/>
		</fieldset>
	</form>
</div>