<?php

/*
Author: Jay Deutsch - http://hudsonvalleywebdesign.net
*/


// Cleaning up the Wordpress Head
function JD_bootstrap_head_cleanup() {
  // remove header links
  remove_action( 'wp_head', 'feed_links_extra', 3 );                                  // Category Feeds
  remove_action( 'wp_head', 'feed_links', 2 );                                        // Post and Comment Feeds
  remove_action( 'wp_head', 'rsd_link' );                                             // EditURI link
  remove_action( 'wp_head', 'wlwmanifest_link' );                                     // Windows Live Writer
  remove_action( 'wp_head', 'index_rel_link' );                                       // index link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );                          // previous link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );                           // start link
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );               // Links for Adjacent Posts
  remove_action( 'wp_head', 'wp_generator' );                                         // WP version
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );                      // Remove silly Emoji scripts
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
}
  // launching operation cleanup
  add_action('init', 'JD_bootstrap_head_cleanup');

// Initialize Wordpress Menu
function JD_BS_nav_setup() {
  register_nav_menus( array(
      'primary'     => __( 'Primary Menu', 'JD_BOOTSTRAP' ),
      'mega_menu'   => __( 'Mega Menu', 'JD_BOOTSTRAP' ),
  ) );
}
add_action( 'after_setup_theme', 'JD_BS_nav_setup' );


/************* ACTIVATE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function JD_bootstrap_register_sidebars() {

  //register MegaMenu widget if the Mega Menu is set as the menu location
    $location = 'mega_menu';
    $css_class = 'mega-menu-parent';
    $locations = get_nav_menu_locations();
    if ( isset( $locations[ $location ] ) ) {
      $menu = get_term( $locations[ $location ], 'nav_menu' );
      if ( $items = wp_get_nav_menu_items( $menu->name ) ) {
        foreach ( $items as $item ) {
          if ( in_array( $css_class, $item->classes ) ) {
            register_sidebar( array(
              'id'   => 'mega-menu-item-' . $item->ID,
              'description' => 'Mega Menu items',
              'name' => $item->title . ' - Mega Menu',
              'before_widget' => '<li id="%1$s" class="mega-menu-item">',
              'after_widget' => '</li>', 

            ));
          }
        }
      }
    }


  //standard widget areas
     register_sidebar(array(
      'id' => 'sidebar1',
      'name' => 'Main Sidebar',
      'description' => 'Main Sidebar',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h3 class="widgettitle">',
      'after_title' => '</h3>',
    ));
      register_sidebar(array(
      'id' => 'footer1',
      'name' => 'Footer Column 1',
      'description' => 'Footer Links 1',
      'before_widget' => '<div id="%1$s" class="widget %2$s col">',
      'after_widget' => '</div>',
      'before_title' => '<h3 class="widgettitle">',
      'after_title' => '</h3>',
    ));
      register_sidebar(array(
      'id' => 'footer2',
      'name' => 'Footer Column 2',
      'description' => 'Footer Links 2',
      'before_widget' => '<div id="%1$s" class="widget %2$s col">',
      'after_widget' => '</div>',
      'before_title' => '<h3 class="widgettitle">',
      'after_title' => '</h3>',
    ));
      register_sidebar(array(
      'id' => 'footer3',
      'name' => 'Footer Column 3',
      'description' => 'Footer Links 3',
      'before_widget' => '<div id="%1$s" class="widget %2$s col">',
      'after_widget' => '</div>',
      'before_title' => '<h3 class="widgettitle">',
      'after_title' => '</h3>',
    ));

} // don't remove this bracket!
add_action( 'widgets_init', 'JD_bootstrap_register_sidebars' ); // This function initializes widgets




// enqueue styles
function JD_BOOTSTRAP_scripts_styles() {
  // Loads Bootstrap minified JavaScript file.
  wp_enqueue_script('bootstrapjs', get_template_directory_uri() . '/library/js/bootstrap.bundle.min.js', array('jquery'),'4.3', true );
  // Loads WoW JavaScript file.
  wp_enqueue_script('WoWjs', get_template_directory_uri() . '/library/js/wow.js', array('jquery'),'', true );
  // Loads NivoLightbox JavaScript file.
  wp_enqueue_script('nivolightbox', get_template_directory_uri() . '/library/nivolightbox/nivo-lightbox.min.js', array('jquery'),'1.3.1', true );
  // Loads FontAwesome 5 Pro
  wp_enqueue_script('fontAwesome', get_template_directory_uri() . '/library/js/fontawesome-all.min.js', array(),'5.0.7', true );
  // Loads Bootstrap minified CSS file.
  wp_enqueue_style('bootstrapcss', get_template_directory_uri() . '/library/css/bootstrap.min.css', false ,'4.3');
  // Loads NivoLightbox CSS file.
  wp_enqueue_style('nivolightboxcss', get_template_directory_uri() . '/library/nivolightbox/nivo-lightbox.css', false ,'1.3.1');
    // Loads NivoLightbox theme CSS file.
  wp_enqueue_style('nivolightboxthemecss', get_template_directory_uri() . '/library/nivolightbox/themes/default/default.css', false ,'1.0');
   // Loads Animate.CSS file.
  wp_enqueue_style('animatecss', get_template_directory_uri() . '/library/css/animate.css', false ,'');

  
  // Loads our main stylesheet LAST
  wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css', false ,'1.7.2');
  // Loads theme JavaScript file LAST.
  wp_enqueue_script('themejs', get_template_directory_uri() . '/library/js/theme.js', array('jquery'),'0', true );

}
add_action('wp_enqueue_scripts', 'JD_BOOTSTRAP_scripts_styles');


// deregister WordPress default jQuery version for a higher version
function modify_jquery_version() {
  if (!is_admin()) {
      wp_deregister_script('jquery');
      wp_register_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', false, '2.2.4');
      wp_enqueue_script('jquery');
  }
}
add_action('init', 'modify_jquery_version');




require_once('includes/theme-functions.php');
require_once('includes/customizer.php');
require_once('includes/wp_bootstrap_mega_navwalker.php');
require_once('includes/custom_post_types.php');
require_once('includes/admin_meta.php');

require_once('includes/metaboxes.php');