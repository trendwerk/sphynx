<?php
/**
 * Loop: Search
 */
?>

<article>
					
	<h2>
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>

	<?php the_excerpt(); ?>

	<a class="more-link" href="<?php the_permalink(); ?>">
		<?php _e( 'Read more', 'tp' ); ?>
	</a>
	
</article>
