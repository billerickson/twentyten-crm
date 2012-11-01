<?php
global $prefix;
get_header(); 
?>

		<div id="container" class="one-column">
			<div id="content" role="main">
				<div class="row clearfix">
	<?php 
	//
	// Loads up all posts so I can calculate statistics. 
	// If you create your own widgets, you can hook into this using 'crm_pre_stat_loop' and 'crm_stat_loop'
	//
	$all = new WP_Query('showposts=-1&posts_per_page=-1');
	do_action('crm_pre_stat_loop');
	$total = 0;
	while ($all->have_posts()): $all->the_post();
		$meta = get_post_custom($post->ID);
		$total++;
		do_action('crm_stat_loop');
	endwhile;
	wp_reset_query(); 
	?>				
				
<div class="item">
	<?php if(! dynamic_sidebar('home-column-1')): ?>
		Go to Appearances > Widgets > Home Column 1 and add some widgets. I recommend the Old Prospects widget.
	<?php endif; ?>
</div>
					
<div class="item">
	<?php if(! dynamic_sidebar('home-column-2')): ?>
		Go to Appearances > Widgets > Home Column 2 and add some widgets. I recommend the Active Projects widget.
	<?php endif; ?>
</div>
					
<div class="item last">
	<?php if(! dynamic_sidebar('home-column-3')): ?>
		Go to Appearances > Widgets > Home Column 3 and add some widgets. I recommend the smaller widgets go here.
	<?php endif; ?>
</div>
				</div> <!-- .row -->

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>