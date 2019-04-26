<?php 
/*
Author: Jay Deutsch - http://hudsonvalleywebdesign.net
*/


/*
** SEO Meta-Box plugin 
*/
$meta_box['post'] = array(
   'id' => 'post-format-meta',   
   'title' => '<span class="dashicons dashicons-tag"></span> SEO Title & Description',    
   'context' => 'normal',    
   'priority' => 'default',
      
   'fields' => array(
      array(
        'name' => 'SEO-TItle',
        'desc' => 'SEO friendly title',
        'id' => 'seo_title',
        'class' => 'seo_title_count',
        'type' => 'text',
        'default' => ''
      ),
      array(
        'name' => 'SEO-Description',
        'desc' => 'Meta Description tag for individual page or post.',
        'id' => 'seo_description',
        'class' => 'seo_description_count',
        'type' => 'text',
        'default' => ''
      )
  )
); 

$meta_box['page'] = array(
    'id' => 'post-format-meta',   
    'title' => '<span class="dashicons dashicons-tag"></span> SEO Title & Description',    
    'context' => 'normal',    
    'priority' => 'default',
    'fields' => array(
      array(
        'name' => 'SEO-TItle',
        'desc' => 'SEO friendly title',
        'id' => 'seo_title',
        'class' => 'seo_title_count',
        'type' => 'text',
        'default' => ''
      ),
      array(
        'name' => 'SEO-Description',
        'desc' => 'Meta Description tag for individual page or post.',
        'id' => 'seo_description',
        'class' => 'seo_description_count',
        'type' => 'text',
        'default' => ''
      )
    )
); 
add_action('admin_menu', 'plib_add_box'); 

//Add meta boxes to post types
  function plib_add_box() {
    global $meta_box;
    
    foreach($meta_box as $post_type => $value) {
        add_meta_box($value['id'], $value['title'], 'plib_format_box', $post_type, $value['context'], $value['priority']);
      }
  }

//Format meta boxes
  function plib_format_box() {
    global $meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="plib_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    echo '<table class="form-table">';

    foreach ($meta_box[$post->post_type]['fields'] as $field) {
      // get current post meta data
      $meta = get_post_meta($post->ID, $field['id'], true);

      echo '<tr>'.
              '<th style="width:20%"><label for="'. $field['id'] .'">'. $field['name']. '</label></th>'.
              '<td>';
      switch ($field['type']) {
          case 'text':
              echo '<input  type="text" name="'. $field['id']. '" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['default']) . '" size="30" style="width:97%" />'. '<br />'. $field['desc'];
              echo '<div  class="alignright '. $field['class'] .'" style="margin-right: 24px;"></div>';
              break;
          case 'textarea':
              echo '<textarea  name="'. $field['id']. '" id="'. $field['id']. '" cols="60" rows="4" style="width:97%">'. ($meta ? $meta : $field['default']) . '</textarea>'. '<br />'. $field['desc'];
              break;
          case 'select':
              echo '<select name="'. $field['id'] . '" id="'. $field['id'] . '">';
              foreach ($field['options'] as $option) {
                  echo '<option '. ( $meta == $option ? ' selected="selected"' : '' ) . '>'. $option . '</option>';
              }
              echo '</select>';
              break;
          case 'radio':
              foreach ($field['options'] as $option) {
                  echo '<input type="radio" name="' . $field['id'] . '" value="' . $option['value'] . '"' . ( $meta == $option['value'] ? ' checked="checked"' : '' ) . ' />' . $option['name'];
              }
              break;
          case 'checkbox':
              echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '"' . ( $meta ? ' checked="checked"' : '' ) . ' />';
              break;
        }
        echo     '<td>'.'</tr>';
    }

    echo '</table>';

  }




//load script to count characters in title and description
  function load_counter_script_wp_admin() {
    wp_enqueue_script('meta_box_counterJS', get_template_directory_uri() . '/library/js/counter.js', array('jquery'),'0', true );
  }
add_action( 'admin_enqueue_scripts', 'load_counter_script_wp_admin' );

    
// Save data from meta box
  function plib_save_data($post_id) {
    global $meta_box,  $post;

    //Verify nonce
    if (!wp_verify_nonce($_POST['plib_meta_box_nonce'], basename(__FILE__))) {
    return $post_id;
    }

    //Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    }

    //Check permissions
    if ('page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
        return $post_id;
      }
    } elseif (!current_user_can('edit_post', $post_id)) {
      return $post_id;
    }

    foreach ($meta_box[$post->post_type]['fields'] as $field) {
      $old = get_post_meta($post_id, $field['id'], true);
      $new = $_POST[$field['id']];

      if ($new && $new != $old) {
        update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
        delete_post_meta($post_id, $field['id'], $old);
        }
      }
    }
add_action('save_post', 'plib_save_data');