<?php 
/*
Author: Jay Deutsch - http://hudsonvalleywebdesign.net
*/

// Register Custom Post Type
function contact_post_type() {

  $labels = array(
    'name'                  => _x( 'Contacts', 'Post Type General Name', 'JD_BOOTSTRAP' ),
    'singular_name'         => _x( 'Contact', 'Post Type Singular Name', 'JD_BOOTSTRAP' ),
    'menu_name'             => __( 'Contacts', 'JD_BOOTSTRAP' ),
    'name_admin_bar'        => __( 'Contacts', 'JD_BOOTSTRAP' ),
    'archives'              => __( 'Item Archives', 'JD_BOOTSTRAP' ),
    'attributes'            => __( 'Item Attributes', 'JD_BOOTSTRAP' ),
    'parent_item_colon'     => __( 'Parent Item:', 'JD_BOOTSTRAP' ),
    'all_items'             => __( 'All Items', 'JD_BOOTSTRAP' ),
    'add_new_item'          => __( 'Add New Item', 'JD_BOOTSTRAP' ),
    'add_new'               => __( 'Add New', 'JD_BOOTSTRAP' ),
    'new_item'              => __( 'New Item', 'JD_BOOTSTRAP' ),
    'edit_item'             => __( 'Edit Item', 'JD_BOOTSTRAP' ),
    'update_item'           => __( 'Update Item', 'JD_BOOTSTRAP' ),
    'view_item'             => __( 'View Item', 'JD_BOOTSTRAP' ),
    'view_items'            => __( 'View Items', 'JD_BOOTSTRAP' ),
    'search_items'          => __( 'Search Item', 'JD_BOOTSTRAP' ),
    'not_found'             => __( 'Not found', 'JD_BOOTSTRAP' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'JD_BOOTSTRAP' ),
    'featured_image'        => __( 'Featured Image', 'JD_BOOTSTRAP' ),
    'set_featured_image'    => __( 'Set featured image', 'JD_BOOTSTRAP' ),
    'remove_featured_image' => __( 'Remove featured image', 'JD_BOOTSTRAP' ),
    'use_featured_image'    => __( 'Use as featured image', 'JD_BOOTSTRAP' ),
    'insert_into_item'      => __( 'Insert into item', 'JD_BOOTSTRAP' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'JD_BOOTSTRAP' ),
    'items_list'            => __( 'Items list', 'JD_BOOTSTRAP' ),
    'items_list_navigation' => __( 'Items list navigation', 'JD_BOOTSTRAP' ),
    'filter_items_list'     => __( 'Filter items list', 'JD_BOOTSTRAP' ),
  );
  $args = array(
    'label'                 => __( 'Contact', 'JD_BOOTSTRAP' ),
    'description'           => __( 'Contacts from form', 'JD_BOOTSTRAP' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor' ),
    'taxonomies'            => array( 'category' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-admin-page',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
  );
  register_post_type( 'contacts', $args );

}
add_action( 'init', 'contact_post_type', 0 );