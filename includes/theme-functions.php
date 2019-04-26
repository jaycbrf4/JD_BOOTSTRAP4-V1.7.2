<?php 
/*
Author: Jay Deutsch - http://hudsonvalleywebdesign.net
*/
  show_admin_bar( false ); //set to false to hide admin bar alltogether


//show_admin_bar( false ); //set to false to hide admin bar alltogether
add_action('wp_dashboard_setup', 'JD_custom_dashboard_widgets');
 
function JD_custom_dashboard_widgets() {
global $wp_meta_boxes;
 
wp_add_dashboard_widget('custom_help_widget', 'Theme Support', 'custom_dashboard_help');
}
 
function custom_dashboard_help() {
echo '<p>Welcome to JD_BOOTSTRAP Theme! Need help? Contact the developer <a href="mailto:dev@hudsonvalleywebdesign.net">here</a>.</p><p>Theme basd on Twitter Bootstrap 4.0.0. For code examples, colors and classes <a href="http://getbootstrap.com/docs/4.0/getting-started/introduction/"> Go here</a></p>';
}



// Function to remove menu items from admin area
// since we are not using comments or blog posts and never use tools - we can hide their menu items
add_action( 'admin_menu', 'my_remove_menu_pages' );
  function my_remove_menu_pages() {
    remove_menu_page('edit-comments.php'); 
    //remove_menu_page('edit.php'); 
    remove_menu_page('tools.php'); 
  }
  // Function to remove menu items from admin-bar on top 
add_action( 'admin_bar_menu', 'remove_wp_admin_bar_items', 999 );
function remove_wp_admin_bar_items( $wp_admin_bar ) {
  $wp_admin_bar->remove_node( 'comments' );
  $wp_admin_bar->remove_node( 'wp-logo' );
  $wp_admin_bar->remove_node( 'new-content' );
}


  function JD_BOOTSTRAP_theme_setup() {
    add_theme_support( 'post-thumbnails' );
    //set_post_thumbnail_size( 400, 600 );    // set thumbnail size for featured images
  }
add_action( 'after_setup_theme', 'JD_BOOTSTRAP_theme_setup' );

//remove default images sizes so there are no extra images in media folder
function add_image_insert_override($sizes){
    unset( $sizes['thumbnail']);
    unset( $sizes['medium']);
    unset( $sizes['large']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'add_image_insert_override' );

  // remove WP version from RSS
  function JD_bootstrap_rss_version() { '__return_empty_string'; }
add_filter('the_generator', 'JD_bootstrap_rss_version');

// Fixing the Read More in the Excerpts
// This removes the annoying […] to a Read More link
  function JD_bootstrap_excerpt_more($more) {
    global $post;
    return '...  <a href="'. get_permalink($post->ID) . '" class="more-link" title="Read '.get_the_title($post->ID).'">Read more <i class="fas fa-caret-right"></i></a>';
  }
add_filter('excerpt_more', 'JD_bootstrap_excerpt_more');

/* change excerpt length on posts */
function new_excerpt_length($length) {
return 70;
}
add_filter('excerpt_length', 'new_excerpt_length');

/* remove Howdy */
add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 10 );

  function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
    $user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $profile_url = get_edit_profile_url( $user_id );

    if ( 0 != $user_id ) {
      /* Add the "My Account" menu */
      $avatar = get_avatar( $user_id, 28 );
      $howdy = sprintf( __('Hey There, %1$s'), $current_user->display_name );
      $class = empty( $avatar ) ? '' : 'with-avatar';

      $wp_admin_bar->add_menu( array(
      'id' => 'my-account',
      'parent' => 'top-secondary',
      'title' => $howdy . $avatar,
      'href' => $profile_url,
      'meta' => array(
      'class' => $class,
      ),
      ) );
    }
  }

// Allow PHP in html
add_filter('widget_text','execute_php',100);
  function execute_php($html){
       if(strpos($html,"<"."?php")!==false){
        ob_start();
        eval("?".">".$html);
        $html=ob_get_contents();
        ob_end_clean();
       }
       return $html;
  }

/*
*
// Custom Backend Footer
*
*/
function custom_admin_footer() {
  echo '<span id="footer-thankyou">Developed by: Jay Deutsch</span>. Built using <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a> and some <span class="dashicons dashicons-heart"></span>';
}
// adding it to the admin area
add_filter('admin_footer_text', 'custom_admin_footer');


/*
*
//Add custom logo file
*
*/
$args = array(
  'default-image' => get_stylesheet_directory_uri() . '/images/logo.png',
  'uploads'       => true,
);
add_theme_support( 'custom-header', $args );


/***** hilight search term *****/
  function highlight_search_term($text){
      if(is_search()){
      $keys = implode('|', explode(' ', get_search_query()));
      $text = preg_replace('/(' . $keys .')/iu', '<span class="search-term" style="background: none repeat scroll 0 0 #ffda00;font-weight: bold;}">\0</span>', $text);
    }
      return $text;
  }
  add_filter('the_excerpt', 'highlight_search_term');
  add_filter('the_title', 'highlight_search_term');

/* custom functions for log-in screen */
  function custom_login_css() {
    echo '<link rel="stylesheet" type="text/css" href="'.get_stylesheet_directory_uri().'/login/style.css" />';
  }
add_action('login_head', 'custom_login_css');

  function my_login_logo_url() {
    return get_bloginfo( 'url' );
  }
add_filter( 'login_headerurl', 'my_login_logo_url' );

  function my_login_logo_url_title() {
    return get_bloginfo( 'name' );
  }
add_filter( 'login_headertitle', 'my_login_logo_url_title' );


//* Login Screen: Don't inform user which piece of credential was incorrect
add_filter ( 'login_errors', 'wp_failed_login' );
  function wp_failed_login () {
    return 'The login information you have entered is incorrect. Please try again.';
  }

// Stop Wordpress from adding <p> tags
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
  function filter_ptags_on_images($content){
     return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  }
add_filter('the_content', 'filter_ptags_on_images');


/**
 * Add to extended_valid_elements for TinyMCE
 *
 * @param $init assoc. array of TinyMCE options
 * @return $init the changed assoc. array
 */
  function my_change_mce_options( $init ) {
      // Command separated string of extended elements
      $ext = 'pre[id|name|class|style]';

      // Add to extended_valid_elements if it alreay exists
      if ( isset( $init['extended_valid_elements'] ) ) {
          $init['extended_valid_elements'] .= ',' . $ext;
      } else {
          $init['extended_valid_elements'] = $ext;
      }
      // Super important: return $init!
      return $init;
  }
add_filter('tiny_mce_before_init', 'my_change_mce_options');


/*
** Bootstrap Responsive Images 
*/
// remove width and height from images
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

  function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
  }
// remove all default image classes
add_filter( 'get_image_tag_class', '__return_empty_string' );
//add Bootstrap img-responsive class
  function image_tag_class($class) {
    $class .= 'img-fluid';
    return $class;
  }
add_filter('get_image_tag_class', 'image_tag_class' );

//remove class from the_post_thumbnail (featured image)
function the_post_thumbnail_remove_class($output) {
        $output = preg_replace('/class=".*?"/', 'class="featured-image img-fluid"', $output);
        return $output;
}
add_filter('post_thumbnail_html', 'the_post_thumbnail_remove_class');

// Add a filter to remove srcset attribute from generated <img> tag
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
