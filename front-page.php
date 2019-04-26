<?php
/* 
*
* Template Name: Static Front Page
*
* This template is for a one page scrolling site. - rename to front-page.php and create pages
* Make sure to change page slug in loop to match pages in backend.
*/
?>

<?php get_header(); ?>
<div id="main" class="clearfix" role="main">
  <div id="content">
              
    <!-- begin sections where each section is a page of content -->
    <div class="section wow fadeIn" data-wow-delay="0.5s" id="first">
      <div class="container">
        <div class="row">
          <?php
              $query = new WP_query ('pagename=home'); // page name adds pages to loop
                // The LooP
                if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                  $query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
                    <section class="post_content">
                  <?php the_content(); ?>
                    </section> <!-- end article section -->
                  </article><!-- / article-->  
                <?php 
                  }
                }
              wp_reset_postdata();
            ?>

        </div><!--row-->
      </div><!--/container-->
    </div><!--/.section-->

      <div class="section sep1 my-4" style="background-color:
      <?php
        // set the variable to the value entered for the "Separator Color" custom field
        $sep_color = get_post_meta($post->ID, 'sep_color', true);
        // check if the Separator color variable has a value
        if($sep_color){ ?>
          <?php  echo $sep_color; 
        // if the Separator color variable does not have a value then default CSS is used
        }else{ 
        }
      ?>;">
    <div class="container">
      <div class="row">
        <div class="col">
           <p class="h1 wow fadeIn" data-wow-delay="0.5s">
              <?php
                // set the variable to the value entered for the "Separator Text" custom field
                $sep_text = get_post_meta($post->ID, 'sep_lead_text', true);
                // check if the Separator text variable has a value
                if($sep_text){ ?>
                  <!-- if the Separator text variable has a value and echo out the value of the variable -->
                  <?php  echo $sep_text; 
                // if the Separator text variable does not have a value then do the following
                }else{ 
                 echo "Please enter your separator text in the back end";
                }
              ?>
           </p><!-- /.h1 -->
        </div><!-- /.col-sm-12 -->
      </div><!-- /.row -->
    </div><!-- /.container -->
  </div><!-- /.section sep1 -->



    <div class="section wow fadeIn" data-wow-delay="0.5s" id="second">
      <div class="container">
        <div class="row">
            <?php
              $query = new WP_query ('pagename=home-page-2'); // page name adds pages to loop
                // The LooP
                if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                  $query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
                    <section class="post_content">
                  <?php the_content(); ?>
                    </section> <!-- end article section -->
                  </article><!-- / article-->  
                <?php 
                }
                }
              wp_reset_postdata();
            ?>
        </div><!--row-->
      </div><!--/container-->
    </div><!--/.section-->
              
  </div><!-- /. content -->
</div><!--/main-->
<?php get_footer(); ?>



                