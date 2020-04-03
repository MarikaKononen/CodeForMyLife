<?php
/**
 * This file generates default dummy data in WordPress database.
 * You can run this with wp-cli: $ wp eval-file data/seed.php
 */

echo __FILE__ . ": Starting the seed script...\n";

/**
 * Update permalinks
 */
$permalink = '/%category%/%postname%/';

echo __FILE__ . ": Updating permalink_structure -> {$permalink}\n";

update_option( 'permalink_structure', $permalink );

flush_rewrite_rules();

// Use preferred language from the system
if ( function_exists( 'pll_default_language' ) ) {
    $default_locale = pll_default_language();
} else {
    $default_locale = get_locale();
}

/**
 * Default settings for pages
 */
$page_defaults = [
    'post_status' => 'publish',
    'post_type' => 'page',
    'post_author'   => 1,
];

/**
 * Default pages for all languages
 */
$pages = [
    [
        'post_title' => [
            'en' => 'Home',
            'fi' => 'Etusivu',
            'sv' => 'Framsida',
        ],
        #'page_template' => 'models/page-frontpage.php',
    ],
    [
        'post_title' => [
            'en' => 'Subpage',
            'fi' => 'Alasivu',
            'sv' => 'Delsida',
        ],
        #'page_template' => 'models/page-page.php',
    ],
    [
        'post_title' => [
            'en' => 'Contact Us',
            'fi' => 'Ota yhteyttä',
            'sv' => 'Kontakta oss',
        ],
        #'page_template' => 'models/page-contact.php',
    ],
];

/**
 * Default navigation for all languages
 */
$default_navigation = [
    'name' => [
        'en' => 'Main-menu',
        'fi' => 'Päävalikko',
        'sv' => 'Generell',
    ]
];

// Use this same navigation for all registered nav menus
$navigations = [];
foreach ( get_registered_nav_menus() as $navigation_slug => $navigation_name ) {
    $navigations[ $navigation_slug ] = $default_navigation;
}

// Put all pages here
$created_page_ids = [
    'en' => [],
    'fi' => [],
    'sv' => [],
];

/**
 * Update polylang options
 */
if ( function_exists( 'pll_languages_list' ) ) {
    $polylang_opt = get_option( 'polylang' );

    // Redirect all languages into pretty urls
    $polylang_opt['redirect_lang'] = 1;

    // Don't handle media uploads with polylang
    $polylang_opt['media_support'] = 1;

    update_option( 'polylang', $polylang_opt );
}

/**
 * Create all pages
 * - If polylang exists, we will create pages for different languages
 */
echo __FILE__ . ": Creating pages...\n";
foreach ( $pages as $page ) {

    // Use default settings for all pages
    $page_settings = array_merge( $page_defaults, $page );

    // Create all language versions if polylang exists and has languages
    if ( function_exists( 'pll_languages_list' ) ) {
        // Link the created post types
        $post_lang_ids = [];

        foreach ( $page['post_title'] as $lang => $post_title ) {
            // Set title for language
            $page_settings = array_merge( $page_settings, [ 'post_title' => $post_title ] );

            // Create post for the language
            echo __FILE__ . ": Creating page {$page_settings['post_title']}...\n";
            $id = wp_insert_post( $page_settings );
            if ( ! is_wp_error( $id ) ) {
                echo __FILE__ . ": Success! Created id: {$id}\n";
                // Store the post id for later usage such as linking and menus
                $post_lang_ids[ $lang ] = $created_page_ids[ $lang ][] = $id;

                // Set post language for polylang
                pll_set_post_language( $id, $lang );
            } else {
                echo __FILE__ . ": Error! Something went wrong...\n";
            }
        }

        // Link all corresponding language versions of page together
        pll_save_post_translations( $post_lang_ids );

    } else {
        // If polylang doesn't exist replace post_title
        $page_settings['post_title'] = $page['post_title'][ $default_locale ];

        // Create post for the language
        $id = wp_insert_post( $page_settings );
        if ( ! is_wp_error( $id ) ) {
            $created_page_ids[ $default_locale ][] = $id;
        }
    }
}

/**
 * Set frontpage from english version of the site
 */
echo __FILE__ . ": Setting up frontpage...\n";
update_option( 'show_on_front', 'page' );
if ( function_exists( 'pll_languages_list' ) ) {
    $lang = pll_default_language();
    update_option( 'page_on_front', $created_page_ids[ $lang ][0] );
} else {
    update_option( 'page_on_front', $created_page_ids[ $default_locale ][0] );
}

// debug all created pages
/**
 * Create all navigations
 */
echo __FILE__ . ": Creating navigation items...\n";
foreach ( $navigations as $nav_slug => $nav_settings ) {
    echo __FILE__ . ": Creating navigation {$nav_slug}...\n";

    if ( function_exists( 'pll_languages_list' ) ) {
        // Create all language versions
        // Get registered menus
        $locations = get_theme_mod( 'nav_menu_locations' );

        foreach ( $nav_settings['name'] as $nav_lang => $nav_name ) {
            echo __FILE__ . ": Creating {$nav_name} for language {$nav_lang}...\n";
            $nav_exists = wp_get_nav_menu_object( $nav_name );
            if ( ! $nav_exists ) {
                // Create menu
                $nav_id = wp_create_nav_menu( $nav_name );
                // Add all pages
                foreach ( $created_page_ids[ $nav_lang ] as $nav_page_id ) {
                    echo __FILE__ . ": Adding page {$nav_page_id} to navigation {$nav_name}...\n";
                    wp_update_nav_menu_item( $nav_id, $nav_page_id );
                }
                // Add all pages into the menu
                foreach ( $created_page_ids[ $default_locale ] as $nav_page_id ) {

                    echo __FILE__ . ": Adding page {$nav_page_id} to navigation {$nav_name}...\n";
                    $result = wp_update_nav_menu_item( $nav_id, 0, [
                        'menu-item-title' => get_the_title( $nav_page_id ),
                        'menu-item-object-id' => $nav_page_id,
                        'menu-item-object' => 'page',
                        'menu-item-type' => 'post_type',
                        'menu-item-status' => 'publish',
                    ]);
                }

                echo __FILE__ . ": Using {$nav_id} in menu location {$nav_slug}...\n";
                /**
                 * Set the default menus for all languages
                 */
                if ( $nav_lang == $default_locale ) {
                    $locations[ $nav_slug ] = $nav_id;
                } else {
                    // Set menu for other languages. Polylang menu items look like: 'menu___en'
                    $locations[ $nav_slug . '___' . $nav_lang ] = $nav_id;
                }
            }

            // Save new menus
            echo __FILE__ . ": Saving navigation items for all languages...\n";
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    } else {
        // Create only the default locale version of page
        $nav_exists = wp_get_nav_menu_object( $nav_settings['name'][ $default_locale ] );
        if ( $nav_exists ) {
            echo __FILE__ . ": Navigation {$nav_slug} already exists...\n";
        } else {
            // Create menu
            echo __FILE__ . ": Setting items for {$nav_slug} navigation menu...\n";
            $nav_id = wp_create_nav_menu( $nav_settings['name'][ $default_locale ] );

            // Add all pages into the menu
            foreach ( $created_page_ids[ $default_locale ] as $nav_page_id ) {

                $result = wp_update_nav_menu_item( $nav_id, 0, [
                    'menu-item-title' => get_the_title( $nav_page_id ),
                    'menu-item-object-id' => $nav_page_id,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                ]);
            }

            // Grab the theme locations and assign our newly-created menu to the menu location.
            if ( ! has_nav_menu( $nav_slug ) ) {
                echo __FILE__ . ": Using navigation id: {$nav_id} in location {$nav_slug}...\n";

                $locations = get_theme_mod( 'nav_menu_locations' );

                // Set this menu for this theme
                $locations[ $nav_slug ] = $nav_id;

                set_theme_mod( 'nav_menu_locations', $locations );
            }
        }
    }
}

/**
 * Update polylang menus from theme options
 */
if ( function_exists( 'pll_languages_list' ) ) {
    echo __FILE__ . ": Updating Polylang metadata for navigation items...\n";
    global $polylang;
    $polyMenu = new PLL_Admin_Nav_Menu( $polylang );
    $polyMenu->update_nav_menu_locations( get_theme_mod( 'nav_menu_locations' ) );
}
