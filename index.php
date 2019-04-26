<?php get_header(); ?>
<div id="content">
   <div class="container wow fadeIn" data-wow-delay="0.5s">
     <div class="row">
          <div id="main" class="col-sm-9 clearfix" role="main">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article"> 
              <header>
                <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'wpbs-featured' ); ?></a>
                <div class="page-header">
                  <h1 class="h2 my-3">
                    <?php the_title(); ?>
                  </h1>
                </div>
                <p class="meta">
                  <?php _e("Posted", "JD_BOOTSTRAP"); ?> 
                  <time datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time(); ?></time> <?php _e("by", "JD_BOOTSTRAP"); ?> <?php the_author_posts_link(); ?> <span class="amp">&</span> <?php _e("filed under", "JD_BOOTSTRAP"); ?> <?php the_category(', '); ?>.
                </p>
              </header> <!-- end article header -->
                <section class="post_content clearfix">
                  <?php the_excerpt( __("Read more &raquo;","JD_BOOTSTRAP") ); ?>
                </section> <!-- end article section -->
              <footer>
                <p class="tags"><?php the_tags('<span class="tags-title">' . __("Tags","JD_BOOTSTRAP") . ':</span> ', ' ', ''); ?></p>
              </footer> <!-- end article footer -->
            </article> <!-- end article -->
            
            
            <?php endwhile; ?>  

              <nav class="wp-prev-next">
                <ul class="pager list-inline">
                  <li class="previous list-inline-item"><?php next_posts_link(_e('<i class="fas fa-caret-left"></i> Older Entries', "JD_BOOTSTRAP")) ?></li>
                  <li class="next list-inline-item"><?php previous_posts_link(_e('Newer Entries <i class="fas fa-caret-right"></i>', "JD_BOOTSTRAP")) ?></li>
                </ul>
              </nav> 
                        
            <?php else : ?>
            
            <article id="post-not-found">
              <header>
                <h1><?php _e("Not Found", "JD_BOOTSTRAP"); ?></h1>
              </header>
              <section class="post_content">
                <p><?php _e("Sorry, but the requested resource was not found on this site.", "JD_BOOTSTRAP"); ?></p>
              </section>
            </article>
            
            <?php endif; ?>
        
          </div> <!-- /main -->
      
          <?php get_sidebar(); // sidebar 1 ?>

    </div><!--/row-->
  </div><!-- /container -->
</div> <!-- /content -->
   

<?php get_footer(); ?>