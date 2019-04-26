<?php get_header(); ?>
<div id="main" class="clearfix" role="main">
  <div id="content">
    <!-- loop the loop -->  
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article"> 
        <section class="post_content post_content_blog">
          <div class="container wow fadeIn" data-wow-delay="0.5s">
            <div class="row">
              <div class="col-sm-8 col-md-9">
                <header>
                  <?php the_post_thumbnail(); ?>
                    <h1 class="h2"><?php the_title(); ?></h1>
                    <p class="meta">
                      <?php _e("Posted", "JD_BOOTSTRAP"); ?> 
                      <time datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time(); ?></time>
                      <?php _e("by", "JD_BOOTSTRAP"); ?> <?php the_author_posts_link(); ?> <span class="amp">&amp;</span> <?php _e("filed under", "JD_BOOTSTRAP"); ?> <?php the_category(', '); ?>.
                    </p>
                </header> <!-- end article header -->
                
                <?php the_excerpt(); ?>
              </div><!-- /.col-sm-8 col-md-9 -->
              <?php get_sidebar(); // sidebar 1 ?>
            </div><!-- /.row -->
          </div><!-- /.container -->             
        </section> <!-- end article section -->
      </article> <!-- end article -->
      <?php endwhile; ?>        
      <?php else : ?>

      <article id="post-not-found">
        <div class="container">
          <div class="row">
            <div class="col">
              <header>
                <h1><?php _e("Not Found", "JD_BOOTSTRAP"); ?></h1>
              </header>
              <section class="post_content">
                <p><?php _e("Sorry, but the requested resource was not found on this site.", "JD_BOOTSTRAP"); ?></p>
              </section>
            </div><!-- /.col-sm-12 -->
          </div><!-- /.row -->
        </div><!-- /.container -->          
      </article>
            
    <?php endif; ?>

  </div> <!-- /content -->
</div> <!-- /main -->    

<?php get_footer(); ?>