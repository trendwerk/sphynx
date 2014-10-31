<?php
/**
 * All query adjustments
 *
 * @package TrendPress
 */

class TP_Query {
    function __construct() {
        add_action( 'pre_get_posts', array( $this, 'queries' ) );
    }

    /**
     * Define all query adjustments in the function below
     */
    function queries( $query ) {
        
    }
} new TP_Query;
