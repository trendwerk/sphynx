<?php
/**
 * Debug functions for developers
 */

/**
 * Debug a variable
 * 
 * @param mixed $var
 */
 
function dbg($var) {
	echo '<pre>';
		print_r($var);
	echo '</pre>';
}
?>