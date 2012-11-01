<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
		<div id="container" class="one-column">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="entry-title"><?php the_title(); ?>
					<?php edit_post_link( __( '(Edit)', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
					</h1>
                    
					<div class="entry-content">
					<div class="row clearfix">
					<div class="item">
						<?php
						global $prefix;
						$email = get_custom_field($prefix.'client_email');
						$phone = get_custom_field($prefix.'client_phone');
						$url = get_custom_field($prefix.'client_url');
						$other_referral = get_custom_field($prefix.'other_referral');
						$result = get_custom_field($prefix.'project_status');
						$summary = get_custom_field($prefix.'status_summary');
						$action = get_custom_field($prefix.'actionitem');
						$forward = get_custom_field($prefix.'forwarded_to');
						$reason = get_custom_field($prefix.'reason');
						$revenue = get_custom_field($prefix.'revenue');
						$expense = get_custom_field($prefix.'expense');
						$start = get_custom_field($prefix.'start_date');
						$end = get_custom_field($prefix.'end_date');
						
						
						echo '<h2>Client Information</h2>';
						echo '<p>';
						echo '<strong>Prospect ID:</strong> '.$post->ID.'<br />';
						echo '<strong>Status:</strong> '; the_terms($post->ID, 'category', '', ''); echo '<br />';
						if($email) echo '<strong>Email</strong>: '.$email. '<br />';
						if($url) echo '<strong>URL</strong>: '.$url. '<br />';
						if($phone) echo '<strong>Phone</strong>: '.$phone. '<br />';
						if($other_referral) echo '<strong>Other Referral</strong>: '.$other_referral. '<br />';
						echo '<strong>Source:</strong> '; the_terms($post->ID, 'sources', '', '', ''); echo '<br />';
						echo '<strong>Point of Contact: </strong>'; the_terms($post->ID, 'poc', '', ' &middot; ', ''); echo '<br />';
						if($action) echo '<strong>Timeline:</strong> '.$action. '<br />';
						echo '</p></div>';
						
						echo '<div class="item"><h2>Project Info</h2><p>';
						if($result) echo '<strong>Result:</strong> '. $result .'<br />';
						if ($forward) echo '<strong>Forwarded to:</strong> '. $forward . '<br />';
						if ($reason) echo '<strong>Reason:</strong> '. $reason . '<br />';
						if ($revenue) echo '<strong>Revenue:</strong> $'.number_format($revenue).'<br />';
						if ($expense) echo '<strong>Expense:</strong> $'. number_format($expense) . '<br />';
						if ($start) echo '<strong>Start Date: </strong>'. date('F j, Y', strtotime($start)) . '<br />';
						if ($end) echo '<strong>End Date: </strong>'. date('F j, Y', strtotime($end)) . '<br />'; 
						if ($summary) echo '<strong>Status:</strong><br /> '. $summary;
						echo '</p></div>';

							echo '<div class="item last"><h2>Attachments</h2>';
							$args = array(
								'post_type' => 'attachment',
								'numberposts' => null,
								'post_status' => null,
								'post_parent' => $post->ID
							);
							$attachments = get_posts($args);
							if ($attachments) {
								echo '<ul class="attach_list">';
								foreach ($attachments as $attachment) {
									echo '<li>'.wp_get_attachment_link($attachment->ID, array(32,32), 0, 1, false);
									echo '<span>';
									echo wp_get_attachment_link($attachment->ID, '' , false, false, $attachment->post_title); 
//									echo apply_filters('the_title', $attachment->post_title);
									echo '</span></li>';
								}
								echo '</ul>';
							} else {
								echo '<p><em>None at this time</em></p>';
							}
							echo '</div></div>';					

							if($content = $post->post_content ) {
							echo '<div class="notes"><h2>Project Notes</h2>';
							  the_content();
						   }
							echo '</div>';
					?>					
					

					</div><!-- .entry-content -->

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>