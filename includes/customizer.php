<?php


/*---------------------------------------------*
  * 	                       ADMIN MENUS
/*---------------------------------------------*/

function JD_bootstrap_add_options_page() {

	add_menu_page( 			// This will introducs a new top level menu to the admin bar
		'Theme Options', 		// Text to be displayed in the browser title bar
		'Theme Options', 		// Text to be used for the menu
		'manage_options', 		// The required capability of the user to access this menu : https://codex.wordpress.org/Roles_and_Capabilities#manage_options
		'theme-options', 		// The slug by which this menu is  accessible
		'show_theme_options',		// The name of the function used to display this menu's content
		'dashicons-art'	,		// The icon to display https://developer.wordpress.org/resource/dashicons/
			61
	);

	add_submenu_page(			// Add a submenu to Theme options
		'theme-options',		// Add the slug to the Parent Menu item
		'Google Analytics ID',		// The text shown in the title bar
		'Google Analytics ID',		// The text rendered in the menu
		'manage_options',		// User access level
		 'GA_options.php', 		// The slug by which this menu is  accessible
		'show_theme_options'		// The function to display this menu item

	 );		

	add_submenu_page(			// Add a submenu to Theme options
		'theme-options',		// Add the slug to the Parent Menu item
		'Copyright Name',			// The text shown in the title bar
		'Copyright Name',			// The text rendered in the menu
		'manage_options',		// User access level
		'copyright_name',		// The slug by which this menu is  accessible
		'show_theme_options'		// The function to display this menu item

	 );	



} // end add_options_page

add_action( 'admin_menu' , 'JD_bootstrap_add_options_page' );


/*---------------------------------------------*
  *                 SECTIONS, SETTINGS and FIELDS
/*---------------------------------------------*/


function JD_bootstrap_initialize_theme_options () {
/**
    * Register new Settings sections in WP Dashboard
 **/

	
	add_settings_section(
		'copyright_section',		// The ID to use for this section in attribute tags
		'<span class="dashicons-before dashicons-admin-users"></span> Copyright Name',		// The title of the section on the page
		'show_copyright',		// The callback to render the options for this section
		'theme-copyright'		// The page this section will be rendered on
	 );
/**
    * Register new Settings fields
 **/

		add_settings_field(
		'copyright_name',			// the ID (or name) of field
		'Content Copyright Holder',		// The text used to label the field
		'show_copyright_name',		// The callback function used to render toe field
		'theme-copyright',			// The page this setting should show up on
		'copyright_section'
	);
	// Register the  settings

		


	register_setting( 
		'copyright_section', 			// The name of the group settings
		'copyright_options',			// The name of the actual option or setting
		'sanitize_copyright'			// The callback to run sanitization
	);

} //end JD_bootstrap_initialize_theme_option

add_action( 'admin_init' , 'JD_bootstrap_initialize_theme_options' );


/*---------------------------------------------*
  *                  CALLBACKS/FUNCTIONS
/*---------------------------------------------*/

function show_theme_options () {
?>
	<div class="wrap"><div id="icon-options-general" class="icon32"></div>
	<h2>Theme Options</h2>
	<?php settings_errors( ); // for error reporting later  ?> 

	<?php  			// declaring active tab
		$active_tab = 'GA_options' ;
		if( isset( $_GET ['page'] ) ) {
			$active_tab = $_GET ['page'];
		} //end if
	?>

	<h2 class="nav-tab-wrapper">
	<a href="?page=GA_options.php" class="nav-tab <?php echo 'GA_options.php' == $active_tab || 'theme-options' == $active_tab ? 'nav-tab-active' : '' ; ?>">Google Analytics</a>
	<a href="?page=copyright_name" class="nav-tab <?php echo $active_tab == 'copyright_name' ? 'nav-tab-active' : '' ; ?>">Copyright Name</a>
	</h2><!-- //.nav-tab-wrapper -->

	<form method="post" action="options.php">
	<?php

			if ( 'copyright_name' == $active_tab ) {
				
				settings_fields( 'copyright_section' );
				do_settings_sections( 'theme-copyright' );

			} else {

				settings_fields( 'GA_options' );
				do_settings_sections( 'GA_options.php' );
			
			} // end if/else
			
			// Add the submit button to serialize options
			submit_button( );
	?>
	</form>

	</div><!-- /wrap -->


<?php
}// end of show_theme_options



function show_copyright () { // Renders the description of the setting below the title

	echo "These options will include the proper copyright information in the Footer" ;

} // end of show_copyright

function show_copyright_name () { //Renders the input field for the 'copyright_options'

		$options = (array) get_option('copyright_options' );
		$name = $options[ 'name' ];
		echo '<input type="text" name="copyright_options[name]" id="copyright_name" value="'.$name . ' " />' ;

} //End copyright_name_display



/**
   *	Sanitizes the text tha's saved in the footer options to remove any code
   *	@param 	array 	$options               		The array of options to be sanitized
   *	@param 	array  	$sanitized_options		The array of sanitized options
   *	
**/	

function sanitize_copyright ( $options ) {

	$sanitized_options  = array();

	foreach( $options as $option_key => $option_val ) {

		$sanitized_options [ $option_key ] = strip_tags( stripslashes( $option_val ) );

	} // end foreach

	return $sanitized_options;

} // end sanitize_footer_options



/*
// Google Analytics 
*/


function wp_theme_page()
{
?>

      <h1>Google Analytics Options</h1>
   
 <?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
<?php } ?>


      <form method="post" enctype="multipart/form-data" action="options.php">
        <?php 
          settings_fields(
                 'GA_options'
            ); 
        
          do_settings_sections(
                 'GA_options.php'
            );
        ?>
            <p class="submit">  
                <input type="submit" class="button-primary" value="<?php _e('Save Tracking ID') ?>" />  
            </p>  
            
      </form>
      

    <?php
} // end wp_theme_page


add_action(
      'admin_init',
      'wp_register_settings' 
);

function wp_register_settings()
{
    // Register the settings with Validation callback
    register_setting( 
                            'GA_options', 
                            'GA_options', 
                            'wp_validate_settings'
  );

    // Add settings section
    add_settings_section( 
                              'wp_text_section', 
                              '<img src="../wp-content/themes/JD_BOOTSTRAP4-V1.7.2/images/analytics.png"> <br><br><span class="dashicons-before dashicons-chart-area"></span> Google Analytics Tracking ID', 
                              'wp_display_section', 
                              'GA_options.php' 
          );

    // Create textbox field
    $field_args = array(
      'type'      => 'text',
      'id'        => 'wp_textbox',
      'name'      => 'wp_textbox',
      'desc'      => 'Enter Google Analytics Tracking ID',
      'std'       => '',
      'label_for' => 'wp_textbox',
      'class'     => 'css_class'
    );

    add_settings_field(
                       'wp_textbox', 
                       'Google Analytics Tracking ID', 
                       'wp_display_setting', 
                       'GA_options.php', 
                       'wp_text_section', 
                       $field_args
         );
} //end wp_register_settings


/**
 * Function to add extra text to display on each section
 */
function wp_display_section($section){ 
	echo '<p>Enter your Google Analytics tracking code here. It will be inserted into the footer script.</p>';
}
function wp_display_setting($args)
{ 

    extract( $args );
    $option_name = 'GA_options';
  
    $options = get_option( $option_name );

    switch ( $type ) {  
          case 'text':  
              $options[$id] = stripslashes($options[$id]);  
              $options[$id] = esc_attr( $options[$id]);  
              echo "<input class='regular-text$class' type='text' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";  
              echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
          break;  
    }
}

/**
 * Callback function to the register_settings function will pass through an input variable
 * You can then validate the values and the return variable will be the values stored in the database.
 */
function wp_validate_settings($input)
{
  foreach($input as $k => $v)
  {
    $newinput[$k] = trim($v);
    
    // Check the input is a letter or a number
    if(!preg_match('/^[A-Z0-9  -_]*$/i', $v)) {
      $newinput[$k] = '';
    }
  }
  return $newinput;
}

function my_customize_register( $wp_customize ) {
  $wp_customize->remove_section('colors');
};
add_action('customize_register','my_customize_register');


/*** 
*
Add custom color settings to populate the default Customizer menu 


add_action('customize_register', function($wpcolor) {
	$wpcolor->add_setting('bgcolor', array (
		'default' => '#ffffff'
		));
	$wpcolor->add_setting('textcolor', array (
		'default' => '#000000'
		));


$wpcolor->add_control('bgcolor-control', array(
	'label' => 'Background Color',
	'section' => 'colors',
	'settings' => 'bgcolor'
	));

$wpcolor->add_control('textcolor-control', array(
	'label' => 'Text Color',
	'section' => 'colors',
	'settings' => 'textcolor'
	));

});

add_action('wp_head', function() { ?>
		<style type='text/css'>
			body { 
					background-color: <?php echo get_theme_mod('bgcolor'); ?>;
					color: <?php echo get_theme_mod('textcolor'); ?>;
						}
			</style>

<?php });**/
