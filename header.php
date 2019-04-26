<?php
/**
 * 
 * Default Header
 *
 */
?>
 <!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php $key="seo_description"; echo get_post_meta($post->ID, $key, true); ?>" />  
  <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
  <title><?php $key="seo_title"; echo get_post_meta($post->ID, $key, true); ?></title>

  <?php wp_head(); ?>
  <?php do_action('wp_head()'); ?><!-- added for custom wp colors from theme customizer -->
</head>
<body <?php body_class(); ?> >

  <header id="header">
    <!-- NAVBAR  ================================================== -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <div class="container">
        <!-- custom calls to options stored in Admin section "Theme Options" to display the logo or not -->
         <a class="navbar-brand" id="logo" href="<?php echo site_url(); ?>"><img src="<?php header_image(); ?>" alt="Our Logo" class="img-responsive logo"/></a>
        <!-- custom calls to options stored in Admin section "Theme Options" to display the logo or not -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#jd-bootstrap-nav-collapse" aria-controls="jd-bootstrap-nav-collapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collect the nav links from WordPress -->
        <div class="collapse navbar-collapse" id="jd-bootstrap-nav-collapse">         
    		  <?php 

          $args = array(
            'theme_location' => 'mega_menu', // primary_menu or mega-menu
            'depth' => 0,
            'container' => '',
            'menu_class'  => 'navbar-nav mr-auto',
            'walker'  => new BootstrapNavMenuWalker()
            );
          wp_nav_menu($args);
          ?>
        </div><!-- ./collapse -->
      </div><!-- /.container -->
    </nav>
  </header>