<?php
/**
 * Plugin Name:  Register Theme Directory
 * Plugin URI:   https://roots.io/bedrock/
 * Description:  Register default theme directory
 * Version:      1.0.0
 * Author:       Roots
 * Author URI:   https://roots.io/
 * License:      MIT License
 */

// Register default themes from web/wp/wp-content if WP_DEFAULT_THEME is not defined
if ( ! defined( 'WP_DEFAULT_THEME' ) ) {
    register_theme_directory( ABSPATH . 'wp-content/themes' );
}
