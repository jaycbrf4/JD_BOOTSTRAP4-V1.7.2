<?php get_header(); ?>

<div id="main" class="clearfix" role="main">
  <div id="content">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="page-header wow fadeIn" data-wow-delay="0.5s">
            <h1>
              <span><?php _e("Search Results for","JD_BOOTSTRAP"); ?>:</span> <?php echo esc_attr(get_search_query()); ?>
            </h1>
          </div>
        </div><!-- /.col-sm-12 -->
      </div><!-- /.row -->
    </div><!-- /.container -->  

    <!-- loop the loop -->   
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      
    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix s-result mb-3 wow fadeIn'); ?> role="article"data-wow-delay="0.5s">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <header>
              <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
            </header> <!-- end article header -->
          
            <section class="post_content">
              <?php the_excerpt(); ?>
            </section> <!-- end article section -->
          </div><!-- /.col-sm-12 -->
        </div><!-- /.row -->
      </div><!-- /.container -->  
    </article> <!-- end article -->


    <?php endwhile; ?>  
    <?php else : ?>

    <!-- this area shows up if there are no results -->
    <article id="post-not-found">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <header>
              <h1><?php _e("Not Found", "JD_BOOTSTRAP"); ?></h1>
            </header>
            <section class="post_content">
              <p><?php _e("Sorry, but the requested content was not found on this site.", "JD_BOOTSTRAP"); ?></p>
            </section>
          </div><!-- /.col-sm-12 -->
        </div><!-- /.row -->
      </div><!-- /.container -->          
    </article>

    <?php endif; ?>


  </div> <!-- /content -->
</div> <!-- /main -->
<?php get_footer(); ?>