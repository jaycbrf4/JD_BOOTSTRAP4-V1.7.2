  <div id="sidebar1" class="col" role="complementary">
    <aside>   
    <?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>
      <?php dynamic_sidebar( 'sidebar1' ); ?>

    <?php else : ?>
    </aside>
      <!-- This content shows up if there are no widgets defined in the backend. -->

        <div class="alert alert-message">   
          <p><?php _e("Please activate some Widgets","JD_BOOTSTRAP"); ?>.</p> 
        </div>

    <?php endif; ?>

  </div><!--/#sidebar1 -->

