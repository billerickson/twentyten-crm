<?php global $user_identity, $user_ID; ?>
<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left border">
				<h2>At a glance</h2>
				<?php wp_nav_menu( array( 'theme_location' => 'top-panel-1', 'fallback_cb' => 'crm_nav_top1_fallback' ) );?>
			</div><!-- .left -->
			<div class="left">
				<h2>Admin</h2>
				<?php wp_nav_menu( array( 'theme_location' => 'top-panel-2', 'fallback_cb' => 'crm_nav_top2_fallback' ) );?>
			</div><!-- .left -->
			<div class="left">
				<h1>Welcome back, <span class="username"><?php echo $user_identity ?></span></h1>
				<h2>Search</h2>
				<form action="<?php bloginfo('url'); ?>" id="searchform" method="get">
					<label for="s" class="screen-reader-text">Search for:</label>
					<input type="text" id="s" name="s" value="" />
					<input type="submit" value="Search" id="searchsubmit" />
				</form>
			</div><!-- .left -->
		</div><!-- .content -->
	</div><!-- panel -->
		
	<div class="tab">
		<ul class="login">
			<li class="left"> </li>
			<!-- Logout -->
			<li><a href="<?php echo wp_logout_url( get_bloginfo('url') ); ?>" title="Logout">Logout</a></li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#">Show Panel</a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>
			</li>
			<li class="right"> </li>
		</ul>
	</div> <!-- .tab -->
</div> <!--END panel -->