<?php
    if ( post_password_required() )
    	return;
?>

<div id="comments">

    <?php if ( have_comments() ) : ?>
    
        <h2 class="comments-title">
            <?php printf( _n( 'One response to &ldquo;%2$s&rdquo;', '%1$s responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'tp' ), get_comments_number(), '<span>' . get_the_title() . '</span>' ); ?>
        </h2>
        
        <ol class="commentlist">
            <?php wp_list_comments(
            	array(
				'walker'            => null,
				'max_depth'         => '',
				'style'             => 'ul',
				'callback'          => null,
				'end-callback'      => null,
				'type'              => 'all',
				'reply_text'        => __( 'Reply', 'tp'),
				'page'              => '',
				'per_page'          => '',
				'avatar_size'       => 60,
				'reverse_top_level' => null,
				'reverse_children'  => '',
				'format'            => 'html5',
				'short_ping'        => false
			));
            ?>
        </ol>
        
    <?php endif; ?>
    
    <?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
    
    	<p class="no-comments">
    		<?php _e( 'Comments are closed', 'tp' ); ?>.
    	</p>
    	
    <?php endif; ?>
    
    <?php comment_form(); ?>
    
</div>