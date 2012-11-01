<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */?>

<?php $first = TRUE; ?>

<?php
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>
     
<?php while ( have_posts() ) : the_post(); global $post; global $prefix; ?>

<?php /* How to display posts of the Aside format. The asides category is the old way. */ ?>
<?php if (is_new_day() && !$first) echo "</div><!-- day -->"; ?>
<?php $first = FALSE; ?>
<?php the_date('j M y', '<div class="day"><h2 class="date">', '</h2>', true); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="entry-content">
				<a href="<?php the_permalink();?>"><?php the_title(); ?></a> 
				<br />Source: <?php $sources = get_the_terms( $post->ID, 'sources', '', ', ', '' ); $list = ''; if ($sources) { foreach ($sources as $data) $list .= $data->name.', '; echo esc_attr( $list ); } ?> | Email: <?php echo get_custom_field($prefix.'client_email');?> | Phone: <?php echo get_custom_field($prefix.'client_phone');?>
			</div><!-- .entry-content -->
		</div><!-- #post-## -->

<?php endwhile; // End the loop. Whew. ?>
</div><!-- day -->

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php
 if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<?php if (function_exists('wp_pagenavi')) : wp_pagenavi(); else : ?>
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older Prospects', 'twentyten' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer Prospects <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
					<?php endif; ?>
				</div><!-- #nav-below -->
<?php endif; ?>