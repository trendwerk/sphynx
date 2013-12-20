<?php
global $author;

if( ! $author ) 
	$author = get_the_author_ID();

if( get_the_author_meta( 'show_profile', $author ) ) {

	?>

	<section class="author-card" itemscope itemtype="http://schema.org/Person">
	
		<div class="author-avatar" itemprop="image">
			<?php if( is_author() ) { ?>
					<?php echo get_avatar( $author, 80 ); ?>
			<?php } else { ?>
				<a href="<?php echo get_author_posts_url( $author ); ?>" rel="author">
					<?php echo get_avatar( $author, 80 ); ?>
				</a>
			<?php } ?>
		</div>
		
		<div class="author-info">
		
			<?php if( is_single() ) echo '<span class="author-writtenby">' . __( 'Written by', 'tp' ) . ':</span>'; ?>
			
			<h4 class="author-name" itemprop="name">
				<?php the_author_meta( 'display_name', $author ); ?>
			</h4>
			
			<p class="author-bio" itemprop="description">
				<?php the_author_meta( 'description', $author ); ?>
			</p>
			
			<ul class="author-social">

				<li>
					<span class="label"><?php _e('Follow me on:', 'tp'); ?></span>
				</li>

				<?php if( $facebook = get_the_author_meta( 'facebook', $author ) ) { ?>
				
					<li>
						<a class="facebook" href="<?php echo $facebook; ?>" itemprop="url" rel="me external">
							<i class="icon-facebook"></i>
						</a>
					</li>
					
				<?php } ?>

				<?php if( $twitter = get_the_author_meta( 'twitter', $author ) ) { ?>
				
					<li >
						<a class="twitter" href="https://twitter.com/<?php echo $twitter; ?>" itemprop="url" rel="me external">
							<i class="icon-twitter"></i>
						</a>
					</li>
					
				<?php } ?>
								
				<?php if( $linkedin = get_the_author_meta( 'linkedin', $author ) ) { ?>
				
					<li>
						<a class="linkedin" href="<?php echo $linkedin; ?>" itemprop="url" rel="me external">
							<i class="icon-linkedin"></i>
						</a>
					</li>
					
				<?php } ?>
				
				<?php if( $googleplus = get_the_author_meta( 'googleplus', $author ) ) { ?>
				
					<li>
						<a class="google-plus" href="<?php echo $googleplus; ?>" itemprop="url" rel="me external">
							<i class="icon-google-plus"></i>
						</a>
					</li>
					
				<?php } ?>
				
			</ul>
			
			<?php if( ! is_author() ) { ?>
				<a class="more" href="<?php echo get_author_posts_url( $author ); ?>" rel="author">
					<?php printf( _n( 'View 1 post', 'View all %1$s posts', count_user_posts( $author ), 'tp' ), count_user_posts( $author ) ); ?>
				</a>
			<?php } ?>
			
			<div class="clear"></div>
			
		</div>
		
	</section>
	
	<?php 
} 
