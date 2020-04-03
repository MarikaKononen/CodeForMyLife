<?php
/**
 * Plugin Name: Disable Redis Object Cache Drop-In
 * Description: Disables Redis connection on various occasions.
 * Version: 1.0.0
 * Author: Ville Siltala / Geniem Oy
 * Author URI: https://github.com/villesiltala
 * License URI: https://opensource.org/licenses/MIT
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Invalid request.' );
}

add_filter( 'redis_object_cache_redis_status', function( $redis_status ) {

    global $wp_query;

    if ( isset( $wp_query ) && is_preview() ) {
    	// This disables the Redis connection usage
    	// when WP query is set and we are on a preview request.
    	// This still enables some basic loading to be done
    	// to Redis before the query is set like option loading.
        return false;
    }

    return $redis_status;
} );
