<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) { ?>
	<p class="no-comments"><?php _e('This post is password protected. Try logging in.','tp'); ?></p>
<?php return; } ?>

<!-- You can start editing here. -->

<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>  	
	<?php die('You can not access this page directly!'); ?>  
<?php endif; ?>

<?php if(!empty($post->post_password)) : ?>
  	<?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
		<p><?php _e('This post is password protected. Try logging in.','tp'); ?></p>
  	<?php endif; ?>
<?php endif; ?>

<?php if($comments) : ?>
	<h3><?php _e('Responses','tp'); ?></h3>
  	<ol id="comments">
    	<?php foreach($comments as $comment) : ?>
  		<li id="comment-<?php comment_ID(); ?>">	
		<?php if(function_exists('get_avatar')) { echo get_avatar($comment, '75'); } ?>
  			<?php if ($comment->comment_approved == '0') : ?>
  			<p><?php _e('Your comment needs te be approved by us','tp'); ?>&hellip;
  			<?php endif; ?>
  			<?php comment_text(); ?>
  			<p class="meta"><?php comment_type(); ?> <?php _e('written by','tp'); ?> <?php comment_author_link(); ?> <?php _e('on','tp'); ?> <?php comment_date(); ?> - <?php comment_time(); ?></p>
  		</li>
		<?php endforeach; ?>
	</ol>
<?php else : ?>
	<p>No comments yet</p>
<?php endif; ?>
<?php if(comments_open()) : ?>
	<h3><?php _e('Respond','tp'); ?></h3>
	<?php if(get_option('comment_registration') && !$user_ID) : ?>
		<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p><?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if($user_ID) : ?>
				<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out','tp'); ?>"><?php _e('Log out &raquo;','tp'); ?></a></p>
			<?php else : ?>
				<p><label for="author"><small><?php _e('Name:','tp'); ?> <?php if($req) echo "*"; ?></small></label><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /></p>
				<p><label for="email"><small><?php _e('Email:','tp'); ?> <?php if($req) echo "*"; ?></small></label><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /></p>
				<p><label for="url"><small><?php _e('Website:','tp'); ?></small></label><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /></p>
			<?php endif; ?>
			<p><textarea name="comment" id="comment" cols="10" rows="10" tabindex="4"></textarea></p>
			<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Respond','tp'); ?>" />
			<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	<?php endif; ?>
<?php else : ?>
	<p>The comments are closed.</p>
<?php endif; ?>
