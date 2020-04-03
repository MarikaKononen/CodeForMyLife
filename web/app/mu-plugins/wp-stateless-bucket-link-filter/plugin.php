<?php
/**
 * Plugin Name: WP Stateless Bucket Link Filter
 * Description: Plugin which enables filtering the WP Stateless bucket link with a PHP constant.
 * Version: 1.0.0
 * Plugin URI: https://github.com/devgeniem/wp-stateless-bucket-name-filter
 * Author: Ville Siltala / Geniem Oy
 * Author URI: https://github.com/villesiltala
 * License: GPLv3
 */

namespace Geniem;

/**
 * Filter the WP Statelss bucket link filter.
 */
if ( defined( 'WP_STATELESS_BUCKET_LINK_REPLACE' ) ) {
    add_filter( 'wp_stateless_bucket_link', function( $link ) {

        if ( function_exists( 'ud_get_stateless_media' ) ) {
            // Get the bucket name.
            $bucket_name = ud_get_stateless_media()->get( 'sm.bucket' );

            // This is the default link.
            $default = 'https://storage.googleapis.com/' . $bucket_name;

            // Get the constant and remove an unwanted trailing slash.
            $replace = rtrim( WP_STATELESS_BUCKET_LINK_REPLACE, '/' );

            return str_replace( $default, $replace, $link );
        }

        return $link;
    });
}
