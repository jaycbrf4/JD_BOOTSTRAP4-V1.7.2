<?php get_header(); ?>
<div id="main" class="clearfix" role="main">
    <div id="content">
      <article id="post-not-found" class="clearfix">
        <div class="container">
          <div class="row">
            <div class="col">
              <header>
                <div class="hero-unit">
                  <h1 class ="wow fadeIn"><?php _e("404 - Article Not Found","JD_BOOTSTRAP"); ?></h1>
                  <p class="lead"><?php _e("Sorry, we can't find what you were looking for.","JD_BOOTSTRAP"); ?></p>
                </div> <!--/.hero-unit-->
              </header> <!-- end article header -->

              <section class="post_content">
                <p><?php _e("Whatever you were looking for was not found, either the page you are looking for has moved or is no longer available.","JD_BOOTSTRAP"); ?></p>
                
                <div class="col-lg-8" style="margin-bottom:24px;">
                <p><?php _e("Please use the seach box below if you are looking for something specific. ","JD_BOOTSTRAP"); ?></p>
                <p><a class="btn btn-info btn-white" href="<?php bloginfo('url'); ?>"> <i class="fal fa-home"></i> <?php bloginfo('name'); ?> Home </a></p>
                <br>
                <?php get_search_form(); ?>
              </section> <!-- end article section -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container -->  
      </article> <!-- end article -->

  </div><!-- /. content -->
</div><!--/main-->
<?php get_footer(); ?>
