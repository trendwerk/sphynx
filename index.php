<?php
	$protocol = "HTTP/1.0";
	if ( "HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"] )
	  $protocol = "HTTP/1.1";
	header( "$protocol 503 Service Unavailable", true, 503 );
	header( "Retry-After: 600" );
?>
<div style="font: 13px/20px sans-serif; margin: 10%; text-align: center;">
	<?php _e('Please activate a TrendPress child-theme to use this theme.','tp'); ?>
</div>