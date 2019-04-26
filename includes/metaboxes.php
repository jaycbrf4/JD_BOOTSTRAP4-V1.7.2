<?php

/*
Author: Jay Deutsch - http://hudsonvalleywebdesign.net
*/

//Separator Text Metabox
function sep_text_metabox(){
    global $post;

    if(!empty($post))
    {
        $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

        if($pageTemplate == 'front-page.php' )
        {

  add_meta_box(
      'sep_lead_text', //Unique ID
      '<span class="dashicons dashicons-flag"></span> Separator Text', //Title
      'displaySepLeadText', //Callback function
      'page', //for pages
      'normal', //Context
      'high' //priority
      );
    }
  }
}

function displaySepLeadText( $object, $box ) {

  wp_nonce_field( basename( __FILE__ ), 'displaySepLeadText' );

  $sep_text  = esc_attr( get_post_meta( $object->ID, 'sep_lead_text', true ) );

  ?>
  <p style="font-weight: 600;">Home Page Separator Caption Text</p>
    <input type="text" name="sep_lead_text" value="<?php echo $sep_text; ?>" placeholder="Page Separator Caption Text" size="90%">   
  <?php 
}

/* Save the meta box's post metadata. */
function save_sep_text_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['displaySepLeadText'] ) || !wp_verify_nonce( $_POST['displaySepLeadText'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;
  
    $field_names = array('sep_lead_text',);
    
    foreach($field_names as $field_name)
    {
      /* Get the posted data and sanitize it for use as an HTML class. */
      $new_meta_value = ( isset( $_POST["$field_name"] ) ? $_POST["$field_name"] : '' );

      /* Get the meta key. */
      $meta_key = $field_name;

      /* Get the meta value of the custom field key. */
      $meta_value = get_post_meta( $post_id, $meta_key, true );

      /* If a new meta value was added and there was no previous value, add it. */
      if ( $new_meta_value && '' == $meta_value )
      add_post_meta( $post_id, $meta_key, $new_meta_value, true );

      /* If the new meta value does not match the old value, update it. */
      elseif ( $new_meta_value && $new_meta_value != $meta_value )
      update_post_meta( $post_id, $meta_key, $new_meta_value );

      /* If there is no new meta value but an old value exists, delete it. */
      elseif ( '' == $new_meta_value && $meta_value )
      delete_post_meta( $post_id, $meta_key, $meta_value );   
    } 
            
}

add_action( 'add_meta_boxes', 'sep_text_metabox' );

add_action( 'save_post', 'save_sep_text_meta', 10, 2 );



// Color picker for sep background color
add_action( 'add_meta_boxes', 'mytheme_add_meta_box' );
 
if ( ! function_exists( 'mytheme_add_meta_box' ) ) {
  function mytheme_add_meta_box(){
    global $post;

    if(!empty($post))
    {
        $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

        if($pageTemplate == 'front-page.php' )
        {
    add_meta_box( 
      'sep_text-bg', 
      esc_html__('Separator Background Color', 'mytheme' ), 
      'mytheme_sep_color_meta_box', 
      'page', 
      'normal', 
      'high'
    );
  }
}
}

add_action( 'admin_enqueue_scripts', 'mytheme_backend_scripts');
 
if ( ! function_exists( 'mytheme_backend_scripts' ) ){
  function mytheme_backend_scripts( $hook ) {
    wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker');
  }
}

if ( ! function_exists( 'mytheme_sep_color_meta_box' ) ) {
  function mytheme_sep_color_meta_box( $post ) {
    $custom = get_post_custom( $post->ID );
    $sep_color = ( isset( $custom['sep_color'][0] ) ) ? $custom['sep_color'][0] : '';
    wp_nonce_field( 'mytheme_sep_color_meta_box', 'mytheme_sep_color_meta_box_nonce' );
    ?>
    <script>
    jQuery(document).ready(function($){
        $('.color_field').each(function(){
            $(this).wpColorPicker();
            });
    });
    </script>
    <div class="pagebox">
        <p><?php esc_attr_e('Choose a color for Separator background.', 'mytheme' ); ?></p>
        <input class="color_field" type="hidden" name="sep_color" value="<?php esc_attr_e( $sep_color ); ?>"/>
    </div>
    <?php
  }
}

if ( ! function_exists( 'mytheme_save_sep_meta_box' ) ) {
  function mytheme_save_sep_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }
    if( !current_user_can( 'edit_pages' ) ) {
      return;
    }
    if ( !isset( $_POST['sep_color'] ) || !wp_verify_nonce( $_POST['mytheme_sep_color_meta_box_nonce'], 'mytheme_sep_color_meta_box' ) ) {
      return;
    }
    $sep_color = (isset($_POST['sep_color']) && $_POST['sep_color']!='') ? $_POST['sep_color'] : '';
    update_post_meta($post_id, 'sep_color', $sep_color);
  }
}
 
add_action( 'save_post', 'mytheme_save_sep_meta_box' );
}