<?php
/**
 * Include an entire folder of files
 */
 
class TP_Includer {
	function __construct( $folder ) {
		if( is_dir( $folder ) ) {
			foreach( scandir( $folder ) as $inc ) {
				if( '.' == substr( $inc, 0, 1 ) ) continue;
				if( substr( $inc, -4 ) != '.php' ) continue;

				$inc = $folder . $inc;

				if( is_readable( $inc ) )
					include_once( $inc );
			}
		}
	}
}
