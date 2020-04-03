<?php
/**
 * Plugin Name: WP Define More
 * Description: Adds useful definable constants which are missing from the WP Core
 * Version: 0.0.1
 * Author: Onni Hakala / Geniem Oy
 * Author URI: https://github.com/onnimonni
 * License: GPLv2
 */

/**
 * Set maximum file size for UPLOADS
 * - This is useful if your reverse proxy ( nginx ) handles the maximum upload size instead of php
 * - This changes also the wp-admin javascript and will deny admins from uploading anything bigger
 */
if ( defined( 'WP_UPLOADS_MAX_SIZE' ) ) {
    add_filter( 'upload_size_limit', function( $max_upload ) {
        // Use the lower value in case $max_upload size was already smaller value
        return min( $max_upload, wp_convert_hr_to_bytes( WP_UPLOADS_MAX_SIZE ) );
    });
}

/**
 * Changes wp-content/uploads directory to custom directory
 * - Relative paths will be under wp-content/
 * - Absolute paths will work too
 */
if ( defined( 'WP_UPLOADS_DIR' ) ) {
    add_filter( 'pre_option_upload_path', function( $option ) {
        return WP_UPLOADS_DIR;
    });
}

/**
 * Changes the default uploads url http://wordpress.test/wp-content/uploads/ to custom url
 * - This is nice if you want to use other domain name for uploads
 * - Or you can map custom path for example /media/ into your uploads directory with nginx
 */
if ( defined( 'WP_UPLOADS_URL' ) ) {
    add_filter( 'pre_option_upload_url_path', function( $option ) {
        return WP_UPLOADS_URL;
    });
}
