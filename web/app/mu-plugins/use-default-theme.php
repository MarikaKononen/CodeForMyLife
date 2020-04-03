<?php
/**
 * Plugin Name:  Switch default theme
 * Description:  Switches to default theme on theme errors
 * Version:      1.0.0
 * Author:       Onni Hakala / Geniem Oy
 * Author URI:   https://geniem.com/
 * License:      MIT License
 */

// Skip if blog is not installed.
if ( ! is_blog_installed() ) { return; }

/**
 * This helps CI to automatically enable the right theme after installation
 * if WP_DEFAULT_THEME is defined
 */
if ( defined( 'WP_DEFAULT_THEME' ) && ! empty( wp_get_theme()->errors() ) ) {
    switch_theme( WP_DEFAULT_THEME );
}
