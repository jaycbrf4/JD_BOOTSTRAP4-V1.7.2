<form action="<?php echo home_url( '/' ); ?>" method="get" class="form-inline">
 	<div class="form-group">
    		<label class="sr-only" for="search">Search</label>
			<input type="search" name="s" id="search" placeholder="<?php _e("Search","jd_bootstrap"); ?>" value="<?php the_search_query(); ?>" class="form-control" />
			<button type="submit" class="btn btn-info pull-right" style="margin-left:8px;"><?php _e("Search","jd_bootstrap"); ?></button>
	</div>
</form>
