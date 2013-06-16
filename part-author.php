<?php 
	if ( !$author ) { $author = get_the_author_ID(); }
	$authorurl = get_author_posts_url($author);
	if (get_the_author_meta('hide_profile',$author) != 1 ) :
?>
	<section class="author" itemscope itemtype="http://schema.org/Person">
		<div class="author-avatar" itemprop="image">
			<?php if (is_author()) { ?>
					<?php echo get_avatar($author,80); ?>
			<?php } else { ?>
				<a href="<?php echo $authorurl; ?>">
					<?php echo get_avatar($author,80); ?>
				</a>
			<?php } ?>
		</div>
		<div class="author-info">
			<?php if (is_single()) { echo '<span class="author-writtenby">'.__('Written by','tp').':</span>'; } ?>
			<h4 class="author-name" itemprop="name">
				<?php the_author_meta('display_name',$author); ?>
			</h4>
			<p class="author-bio" itemprop="description">
				<?php the_author_meta('description',$author); ?>
			</p>
			<ul class="author-social">
				<?php if($twitter = get_the_author_meta('twitter',$author)) : ?>
					<li class="twitter">
						<a href="https://twitter.com/<?php echo $twitter; ?>" itemprop="url" rel="external">
							<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/twitter.svg" />@<?php echo $twitter; ?>
						</a>
					</li>
				<?php endif; ?>
				<?php if($facebook = get_the_author_meta('facebook',$author)) : ?>
					<li class="facebook">
						<a href="<?php echo $facebook; ?>" itemprop="url" rel="external">
							<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/facebook.svg" /><?php _e('Facebook','tp'); ?>
						</a>
					</li>
				<?php endif; ?>
				<?php if($linkedin = get_the_author_meta('linkedin',$author)) : ?>
					<li class="linkedin">
						<a href="<?php echo $linkedin; ?>" itemprop="url" rel="external">
							<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/linkedin.svg" /><?php _e('LinkedIn','tp'); ?>
						</a>
					</li>
				<?php endif; ?>
				<?php if($googleplus = get_the_author_meta('googleplus',$author)) : ?>
					<li class="googleplus">
						<a href="<?php echo $googleplus; ?>" itemprop="url" rel="external">
							<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/google.svg" /><?php _e('Google+','tp'); ?>
						</a>
					</li>
				<?php endif; ?>
			</ul>
			<?php if (!is_author()) : ?>
				<a class="more" href="<?php echo $authorurl; ?>"><?php printf(__('View all %1$s posts','tp'),count_user_posts($author)); ?></a>
			<?php endif; ?>
			<div class="clear"></div>
		</div>
	</section>
<?php endif; ?>