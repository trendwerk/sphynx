<?php get_header(); ?>
<div class="container-inner">
	<aside class="sidebar fourcol">
		<?php if ( function_exists('dynamic_sidebar') ) dynamic_sidebar('page'); ?>
	</aside>
	<article id="content" class="eightcol">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1 id="page-title"><?php the_title(); ?></h1>
			<?php the_content(); ?>
			<?php 
				$users = get_users('orderby=display_name'); 
				if($users) : 
			?>
			<section id="authors">				
				<?php 
					foreach($users as $user) : 
						$author = $user->ID;
						include(locate_template('part-author.php'));
					endforeach; 
				?>
			</section>
			<?php endif; ?>	
		<?php endwhile; endif; ?>
	</article>
</div>
<?php get_footer(); ?>